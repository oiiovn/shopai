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
?>
