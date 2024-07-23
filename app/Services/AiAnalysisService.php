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
        $prompt = "Phân tích kết quả luyện tập TOEIC sau và 
                    xác định điểm mạnh dựa trên những câu hỏi có kết quả Is Correct là '1' (True) và 
                    điểm yếu dựa trên những câu hỏi có kết quả là '0' (False). 
                    Hãy cung cấp đánh giá chi tiết. 
                    Đặc biệt, lưu ý đến các kỹ năng ngôn ngữ cụ thể như từ vựng, ngữ pháp, và khả năng hiểu ngữ cảnh.
                    Dữ liệu kết quả bài kiểm tra bao gồm thông tin sau:
                    - Kết quả: {Is Correct}
                    - URL âm thanh: {Audio}
                    - Số thứ tự câu hỏi: {Number question}
                    - ID câu con: {QuestionChild}
                    - dịch nghĩa {Transcript}
                    - Giải thích {Explanation}
                    - Câu trả lời đã chọn: {Chosen Answer}
                    - URL hình ảnh: {Images}
                    Dưới đây là các kết quả chi tiết:";

        foreach ($results as $result) {
            $isCorrect = $result["Is Correct"];
            $url_audio = $result["Audio"] ?? "N/A";
            $numberQuestion = $result["Number question"];
            $questionChild = $result["QuestionChild"];
            $explanation = $result["Explanation"];
            $transcript = $result["Transcript"];
            $chosenAnswer = $result["Chosen Answer"];
            $imageUrls = $result["Images"];

            $prompt .= "
            File âm thanh: {$url_audio}\n
            Số thứ tự: {$numberQuestion}\n
            ID Câu con: {$questionChild}\n
            Câu trả lời: {$chosenAnswer}\n
            Kết quả: {$isCorrect}\n
            Giải thích: {$explanation}\n
            Dịch nghĩa: {$transcript}\n";

            foreach ($imageUrls as $imageUrl) {
                $prompt .= "URL hình ảnh: {$imageUrl}\n";
            }

            $prompt .= "\n";
        }

        $prompt .= "Cuối cùng, hãy đưa ra lời khuyên và phù hợp để cải thiện các kỹ năng còn yếu. Chúc bạn học tốt!\n\n";

        return $prompt;
    }
}
