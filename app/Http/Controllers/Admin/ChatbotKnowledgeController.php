<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatbotKnowledge;
use Maatwebsite\Excel\Facades\Excel;

class ChatbotKnowledgeController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        $rows = Excel::toArray([], $request->file('file'))[0];

        foreach ($rows as $index => $row) {
            if ($index === 0) continue; // bỏ header

            ChatbotKnowledge::create([
                'keywords' => $row[0], // cột A
                'content'  => $row[1], // cột B
            ]);
        }

        return back()->with('success', 'Import chatbot knowledge thành công');
    }
}