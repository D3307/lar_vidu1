<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ChatbotKnowledge;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function send(Request $request)
    {
        $prompt = trim($request->input('message', ''));
        $lowerPrompt = mb_strtolower($prompt);

        if ($prompt === '') {
            return response()->json([
                'reply' => 'Vui lòng nhập nội dung tin nhắn.'
            ], 400);
        }

        /* ======================================================
         | 1️⃣ TRA CỨU ĐƠN HÀNG – LOGIC NGHIỆP VỤ (KHÔNG AI)
         ====================================================== */
        if (str_contains($lowerPrompt, 'đơn hàng')) {

            preg_match('/(order_[\w\d_]+|\d+)/i', $prompt, $matches);

            if (empty($matches[1])) {
                return response()->json([
                    'reply' => 'Bạn vui lòng cung cấp mã đơn hàng (ví dụ: 67 hoặc ORDER_67_1769089996).'
                ]);
            }

            $code = $matches[1];

            $order = ctype_digit($code)
                ? Order::where('id', (int)$code)->first()
                : Order::where('momo_order_id', $code)->first();

            if (! $order) {
                return response()->json([
                    'reply' => "❌ Không tìm thấy đơn hàng với mã <b>{$code}</b>."
                ]);
            }

            return response()->json([
                'reply' => "
                    ✅ <b>Thông tin đơn hàng</b><br>
                    • Mã đơn: {$order->momo_order_id}<br>
                    • Trạng thái: {$order->status}<br>
                    • Thanh toán: {$order->payment_status}<br>
                    • Tổng tiền: " . number_format($order->final_total) . " VNĐ<br>
                    • Ngày tạo: {$order->created_at}
                "
            ]);
        }

        /* ======================================================
         | 2️⃣ LẤY TRI THỨC TỪ EXCEL (DB) – KHÔNG TRẢ LỜI NGAY
         ====================================================== */
        $matchedKnowledges = [];

        $knowledges = ChatbotKnowledge::all();

        foreach ($knowledges as $row) {
            $keywords = array_map(
                'trim',
                explode(',', mb_strtolower($row->keywords))
            );

            foreach ($keywords as $keyword) {
                if ($keyword !== '' && str_contains($lowerPrompt, $keyword)) {
                    $matchedKnowledges[] = $row->content;
                    break;
                }
            }
        }

        /* ======================================================
         | 3️⃣ AI DIỄN GIẢI TRI THỨC (RAG)
         ====================================================== */
        if (! empty($matchedKnowledges)) {

            $knowledgeText = implode("\n- ", $matchedKnowledges);

            $systemPrompt = <<<PROMPT
Bạn là trợ lý bán hàng của Bridal Shop.

Chỉ được sử dụng thông tin sau để trả lời:
- {$knowledgeText}

Yêu cầu:
- Trả lời tự nhiên, lịch sự
- Không bịa thêm thông tin
- Nếu thông tin chưa đủ, nói rõ là shop chưa có dữ liệu
PROMPT;

            try {
                $res = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                    'Content-Type' => 'application/json',
                ])->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'temperature' => 0.6,
                    'max_tokens' => 300,
                ]);

                if ($res->successful()) {
                    return response()->json([
                        'reply' => $res->json()['choices'][0]['message']['content']
                            ?? 'Mình chưa có phản hồi phù hợp.'
                    ]);
                }

                Log::warning('AI response failed', [
                    'status' => $res->status()
                ]);

            } catch (\Throwable $e) {
                Log::error('RAG AI error', [
                    'msg' => $e->getMessage()
                ]);
            }
        }

        /* ======================================================
         | 4️⃣ FALLBACK – KHÔNG CÓ TRI THỨC / HẾT QUOTA
         ====================================================== */
        return response()->json([
            'reply' => '🤖 Mình chưa có thông tin cho câu hỏi này.
Bạn có thể hỏi về đơn hàng, giao hàng, đổi trả hoặc dịch vụ của shop nhé.'
        ]);
    }
}