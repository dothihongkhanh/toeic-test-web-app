<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AiAnalysisService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('API_AI_URL');
        $this->apiKey = env('GOOGLE_API_KEY');
    }

    public function analyzeResults($results)
    {
        dd($results);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])
            ->post($this->apiUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $this->generatePrompt($results)
                            ]
                        ]
                    ]
                ],
            ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception('API request failed: ' . $response->body());
        }
    }

    protected function generatePrompt($results)
    {
        $prompt = "Phân tích kết quả luyện tập TOEIC sau và xác định điểm mạnh dựa trên những câu hỏi có kết quả là 'True' và điểm yếu dựa trên những câu hỏi có kết quả là 'False'. Hãy cung cấp đánh giá chi tiết. Đặc biệt, lưu ý đến các kỹ năng ngôn ngữ cụ thể như từ vựng, ngữ pháp, và khả năng hiểu ngữ cảnh.
                    Dữ liệu kết quả bài kiểm tra bao gồm thông tin sau:
                    - URL âm thanh: {Audio}
                    - Số thứ tự câu hỏi: {Number question}
                    - ID câu con: {QuestionChild}
                    - Câu trả lời đã chọn: {Chosen Answer}
                    - Kết quả: {Is Correct}
                    - URL hình ảnh: {Images}
                    Dưới đây là các kết quả chi tiết:";

        foreach ($results as $result) {
            $url_audio = $result["Audio"] ?? 'N/A';
            $numberQuestion = $result["Number question"] ?? 'N/A';
            $questionChild = $result["QuestionChild"] ?? 'N/A';
            $chosenAnswer = $result["Chosen Answer"] ?? 'N/A';
            $isCorrect = $result["Is Correct"];
            $imageUrls = $result["Images"];

            $prompt .= "File âm thanh: {$url_audio}\nSố thứ tự: {$numberQuestion}\nID Câu con: {$questionChild}\nCâu trả lời: {$chosenAnswer}\nKết quả: {$isCorrect}\n";

            foreach ($imageUrls as $imageUrl) {
                $prompt .= "URL hình ảnh: {$imageUrl}\n";
            }

            $prompt .= "\n";
        }

        $prompt .= "Cuối cùng, hãy đưa ra lời khuyên và phù hợp để cải thiện các kỹ năng còn yếu. Chúc bạn học tốt!\n\n";

        return $prompt;
    }
}
