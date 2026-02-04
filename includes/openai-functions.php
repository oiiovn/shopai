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
    
    // Tạo random style để mỗi review khác nhau hẳn
    $styles = [
        "cực kỳ ngắn gọn, súc tích, đi thẳng vào vấn đề",
        "tự nhiên, như người bình thường kể lại trải nghiệm",
        "nhiệt tình, hào hứng nhưng vẫn chân thực",
        "bình tĩnh, khách quan, đánh giá cân bằng",
        "trẻ trung, năng động, dùng từ ngắn gọn",
        "trưởng thành hơn, có kinh nghiệm, đánh giá chi tiết"
    ];
    $random_style = $styles[array_rand($styles)];
    
    // Tạo random variation hints
    $variations = [
        "Bắt đầu bằng ấn tượng đầu tiên",
        "Nhấn mạnh điểm nổi bật nhất",
        "Kể lại trải nghiệm theo thứ tự thời gian",
        "So sánh với kỳ vọng ban đầu",
        "Tập trung vào cảm nhận cá nhân"
    ];
    $random_variation = $variations[array_rand($variations)];
    
    // Random natural elements để reviews tự nhiên hơn
    $natural_elements = [
        "có thể thêm 1-2 emoji (👍😊❤️🔥💯) nếu phù hợp",
        "dùng viết tắt tiếng Việt tự nhiên (oke, k, dc, vs, ...)",
        "có thể có 1-2 lỗi chính tả nhỏ (thật → thât, được → đc)",
        "dùng từ lóng Gen Z nhẹ (ổn áp, xịn sò, ngon lành)",
        "thêm dấu ... hoặc !!! để thể hiện cảm xúc"
    ];
    $random_element = $natural_elements[array_rand($natural_elements)];
    
    // Tạo prompt cho GPT - CHỈ dựa trên review_template, KHÔNG dùng tên địa điểm
    $prompt = "Bạn là người dùng thật viết đánh giá Google Maps.\n\n";
    
    if (!empty($review_template)) {
        // CÓ TEMPLATE: Dựa trên hướng dẫn của người dùng
        $prompt .= "Dựa trên ý chính: \"{$review_template}\"\n\n";
    } else {
        // KHÔNG CÓ TEMPLATE: Tự do sáng tạo dựa trên phong cách và variation đã random
        $prompt .= "Hãy viết một đánh giá tự nhiên về trải nghiệm của bạn.\n\n";
    }
    
    $prompt .= "YÊU CẦU:\n";
    $prompt .= "- Độ dài: 200-300 ký tự (BẮT BUỘC)\n";
    $prompt .= "- Phong cách: {$random_style}\n";
    $prompt .= "- Cách viết: {$random_variation}\n";
    $prompt .= "- Tự nhiên hơn: {$random_element}\n";
    $prompt .= "- TUYỆT ĐỐI KHÔNG dùng tên địa điểm cụ thể\n";
    $prompt .= "- Giữ ý chính nhưng diễn đạt HOÀN TOÀN KHÁC BIỆT\n";
    $prompt .= "- Thay đổi cấu trúc câu, từ ngữ, thứ tự ý\n";
    $prompt .= "- Viết như người Việt thật, không formal quá\n";
    $prompt .= "- Mỗi lần phải khác nhau HOÀN TOÀN, không lặp lại pattern\n\n";
    $prompt .= "TRÁNH TUYỆT ĐỐI các từ AI thường dùng:\n";
    $prompt .= "- wow, amazing, awesome, fantastic, incredible\n";
    $prompt .= "- xuất sắc, tuyệt vời, hoàn hảo, tuyệt hảo\n";
    $prompt .= "- không thể tin được, đáng kinh ngạc\n";
    $prompt .= "- chắc chắn sẽ quay lại, definitely recommend\n";
    $prompt .= "→ Dùng từ bình thường hơn: tốt, ổn, hay, ngon, ok, oke\n\n";
    $prompt .= "CHỈ TRẢ VỀ NỘI DUNG ĐÁNH GIÁ, KHÔNG GIẢI THÍCH.";
    
    $data = [
        "model" => "gpt-4o-mini",
        "messages" => [
            [
                "role" => "system",
                "content" => "Bạn là người viết review thật. Mỗi lần viết phải khác biệt hoàn toàn về phong cách và cách diễn đạt."
            ],
            [
                "role" => "user",
                "content" => $prompt
            ]
        ],
        "max_tokens" => 250,
        "temperature" => 1.3,  // Tăng cao để đa dạng hơn (từ 1.0 lên 1.3)
        "top_p" => 0.9,        // Giảm để tăng độ ngẫu nhiên (từ 0.95 xuống 0.9)
        "frequency_penalty" => 0.8,  // Tăng để tránh lặp từ (từ 0.5 lên 0.8)
        "presence_penalty" => 0.6,   // Tăng để khuyến khích từ mới (từ 0.3 lên 0.6)
        "seed" => rand(1, 999999)    // Random seed mỗi lần để kết quả khác nhau
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
