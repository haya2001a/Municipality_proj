<?php

namespace App\Http\Controllers\CitizenControllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class ChatBotController extends Controller
{
    public function chat(Request $request)
    {
        $message = $request->input('message');
        $apiKey = config('services.gemini.api_key');

        if (!$apiKey) {
            return response()->json(['reply' => 'مفتاح API غير موجود. يرجى التحقق من الإعدادات.']);
        }

        $context = "  هذا الموقع عبارة عن تطبيق لبلدية السموع يستخدمه كل من المواطن والموظف ، يطلب من خلاله المواطن خدمات ويقدم شكاوي ويمكنه التواصل مع البلدية من خلاله يمكنك من خلال هذا الموقع تقديم خدمة وتتبع حالتها ،تقديم شكوى ايضا بالاضافة الى تتبع حالة رخصتك التجارية اذا كان لديك سجل تجاري ";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $context . "\nسؤال المستخدم: " . $message
                            ]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.9,
                    'topK' => 1,
                    'topP' => 1,
                    'maxOutputTokens' => 2048,
                ],
                'safetySettings' => [
                    [
                        'category' => 'HARM_CATEGORY_HARASSMENT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                    [
                        'category' => 'HARM_CATEGORY_HATE_SPEECH',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                    [
                        'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                    [
                        'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ]
                ]
            ]);

            Log::info('Gemini API Response:', ['response' => $response->json()]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['candidates']) && 
                    count($data['candidates']) > 0 && 
                    isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    
                    $reply = $data['candidates'][0]['content']['parts'][0]['text'];
                    return response()->json(['reply' => $reply]);
                } else {
                    return response()->json(['reply' => 'لم أتمكن من فهم الطلب، يرجى إعادة المحاولة.']);
                }
            } else {
                Log::error('Gemini API Error:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                return response()->json(['reply' => 'حدث خطأ في الاتصال بالخدمة، يرجى المحاولة مرة أخرى.']);
            }

        } catch (\Exception $e) {
            Log::error('Gemini API Exception:', ['error' => $e->getMessage()]);
            
            return response()->json(['reply' => 'حدث خطأ غير متوقع، يرجى المحاولة لاحقاً.']);
        }
    }
}