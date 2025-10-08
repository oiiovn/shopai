<?php
/**
 * OpenAI Functions - chỉ chứa functions, không execute code
 */

function getOpenAIAPIKey() {
    global $db;
    try {
        $q = $db->query("SELECT config_value FROM phuong_nhi_config WHERE config_key='openai_api_key' LIMIT 1");
        if ($q && $q->num_rows) {
            $row = $q->fetch_assoc();
            $key = trim((string)$row['config_value']);
            return $key ?: null;
        }
    } catch (Throwable $e) {
        error_log("getOpenAIAPIKey error: ".$e->getMessage());
    }
    return null;
}

function callOpenAIVisionAPI($api_key, $image_base64, $image_mime, $prompt) {
    $url = 'https://api.openai.com/v1/chat/completions';
    
    $data = [
        "model" => "gpt-4o",
        "messages" => [
            [
                "role" => "user",
                "content" => [
                    ["type" => "text", "text" => $prompt],
                    ["type" => "image_url", "image_url" => ["url" => "data:{$image_mime};base64,{$image_base64}"]]
                ]
            ]
        ],
        "max_tokens" => 500
    ];
    
    $headers = [
        'Authorization: Bearer ' . $api_key,
        'Content-Type: application/json'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'http_code' => $http_code,
        'response' => $response
    ];
}

/**
 * Generate unique review content based on template using GPT
 * 
 * @param string $api_key OpenAI API key
 * @param string $place_name Tên địa điểm
 * @param string $place_address Địa chỉ địa điểm
 * @param string $review_template Mẫu đánh giá gợi ý từ user
 * @return array ['success' => bool, 'content' => string, 'error' => string]
 */
function generateReviewContent($api_key, $place_name, $place_address, $review_template) {
    $url = 'https://api.openai.com/v1/chat/completions';
    
    // Tạo prompt cho GPT
    $prompt = "Bạn là một người dùng thật đang viết đánh giá trên Google Maps cho địa điểm: \"{$place_name}\" tại {$place_address}.\n\n";
    
    if (!empty($review_template)) {
        $prompt .= "Dựa trên gợi ý sau: \"{$review_template}\"\n\n";
    }
    
    $prompt .= "Hãy viết một đánh giá chân thực, tự nhiên với yêu cầu:\n";
    $prompt .= "- Độ dài: 200-300 ký tự (bắt buộc)\n";
    $prompt .= "- Phong cách: người Việt thật, tự nhiên, không quá hoa mỹ\n";
    $prompt .= "- Nội dung: cân bằng giữa kỹ thuật và cảm xúc cá nhân\n";
    $prompt .= "- Ngôn ngữ: tiếng Việt có dấu\n";
    $prompt .= "- Tránh: sao chép template, lặp từ ngữ, quá chung chung\n";
    $prompt .= "- Mỗi lần generate phải khác nhau, thay đổi cách diễn đạt\n\n";
    $prompt .= "CHỈ TRẢ VỀ NỘI DUNG ĐÁNH GIÁ, KHÔNG CÓ THÊM BẤT KỲ GIẢI THÍCH NÀO KHÁC.";
    
    $data = [
        "model" => "gpt-4o-mini",  // Dùng mini để tiết kiệm chi phí
        "messages" => [
            [
                "role" => "system",
                "content" => "Bạn là một người dùng thật viết đánh giá trên Google Maps. Viết tự nhiên, ngắn gọn, chân thực."
            ],
            [
                "role" => "user",
                "content" => $prompt
            ]
        ],
        "max_tokens" => 200,
        "temperature" => 1.0,  // Tăng độ ngẫu nhiên để mỗi lần khác nhau
        "top_p" => 0.95,
        "frequency_penalty" => 0.5,  // Giảm lặp từ
        "presence_penalty" => 0.3    // Khuyến khích nội dung mới
    ];
    
    $headers = [
        'Authorization: Bearer ' . $api_key,
        'Content-Type: application/json'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);
    
    if ($curl_error) {
        return [
            'success' => false,
            'content' => '',
            'error' => "CURL Error: {$curl_error}"
        ];
    }
    
    if ($http_code !== 200) {
        return [
            'success' => false,
            'content' => '',
            'error' => "HTTP {$http_code}: {$response}"
        ];
    }
    
    $result = json_decode($response, true);
    
    if (isset($result['choices'][0]['message']['content'])) {
        $content = trim($result['choices'][0]['message']['content']);
        
        // Kiểm tra độ dài
        $length = mb_strlen($content, 'UTF-8');
        if ($length < 150 || $length > 350) {
            error_log("GPT Review length out of range: {$length} chars");
        }
        
        return [
            'success' => true,
            'content' => $content,
            'error' => ''
        ];
    }
    
    return [
        'success' => false,
        'content' => '',
        'error' => 'Invalid GPT response format'
    ];
}
?>
