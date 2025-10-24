<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function send(Request $request)
    {
        $prompt = trim($request->input('message', ''));
        if ($prompt === '') {
            return response()->json(['reply' => 'Vui lòng nhập tin nhắn.'], 400);
        }

        $apiKey = env('OPENAI_API_KEY');
        if (empty($apiKey)) {
            Log::warning('CHATBOT: OPENAI_API_KEY not set; returning mock reply.');
            return response()->json(['reply' => 'Xin chào! Chatbot chưa được cấu hình.'], 200);
        }

        // helper để gọi OpenAI Chat API
        $callOpenAI = function($messages, $temperature = 0.8) use ($apiKey) {
            return Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => $messages,
                'max_tokens' => 400,
                'temperature' => $temperature,
                'top_p' => 1.0,
                'n' => 1,
            ]);
        };

        // system prompt — bắt model không chỉ lặp lại câu hỏi, trả lời ngắn gọn, hữu ích
        $system = "Bạn là trợ lý bán hàng cho Bridal Shop. Trả lời ngắn gọn, thân thiện, cung cấp bước tiếp theo (ví dụ: link sản phẩm, hướng dẫn mua) khi có thể. KHÔNG chỉ lặp lại nguyên văn câu hỏi của người dùng. Nếu người dùng hỏi để mua, đề xuất kích cỡ và hướng dẫn thanh toán.";

        // lần gọi đầu
        $messages = [
            ['role' => 'system', 'content' => $system],
            ['role' => 'user', 'content' => $prompt],
        ];

        try {
            $res = $callOpenAI($messages, 0.8);
            if (! $res->successful()) {
                Log::error('OpenAI error', ['status' => $res->status(), 'body' => $res->body()]);
                return response()->json(['reply' => 'Đã xảy ra lỗi khi kết nối AI.'], 500);
            }

            $json = $res->json();
            $reply = $json['choices'][0]['message']['content'] ?? '';

            // nếu model trả về đúng hoặc gần giống input, thử gọi lại với temperature cao hơn và instruction mạnh hơn
            $cleanReply = trim(preg_replace('/\s+/', ' ', mb_strtolower(strip_tags($reply))));
            $cleanPrompt = trim(preg_replace('/\s+/', ' ', mb_strtolower(strip_tags($prompt))));
            if ($cleanReply === $cleanPrompt || stripos($cleanReply, $cleanPrompt) !== false) {
                // thêm instruction rõ ràng yêu cầu paraphrase + thêm thông tin hữu ích
                $messages[] = ['role' => 'system', 'content' => 'Hãy trả lời KHÔNG lặp lại nguyên văn câu hỏi. Tóm tắt, đưa giải pháp hoặc bước tiếp theo cụ thể.'];
                $messages[] = ['role' => 'user', 'content' => $prompt];
                $res2 = $callOpenAI($messages, 1.0);
                if ($res2->successful()) {
                    $json2 = $res2->json();
                    $reply = $json2['choices'][0]['message']['content'] ?? $reply;
                } else {
                    Log::warning('OpenAI retry failed', ['status' => $res2->status(), 'body' => $res2->body()]);
                }
            }

            $reply = trim($reply) ?: 'AI chưa trả về phản hồi hợp lệ.';
            return response()->json(['reply' => $reply], 200);

        } catch (\Throwable $e) {
            Log::error('CHATBOT exception: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['reply' => 'Đã xảy ra lỗi khi kết nối AI.'], 500);
        }
    }
}