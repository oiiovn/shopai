<?php
/**
 * PHUONG_NHI AJAX — HARDENED JSON ENDPOINT
 * - Luôn trả JSON (kể cả khi fatal)
 * - Loại BOM/whitespace
 * - Đường dẫn tuyệt đối
 */

ob_start();
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', '0');
error_reporting(E_ALL);

register_shutdown_function(function () {
    $e = error_get_last();
    if ($e && in_array($e['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
        while (ob_get_level() > 0) { ob_end_clean(); }
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error'   => 'PHP_FATAL',
            'detail'  => $e['message']
        ], JSON_UNESCAPED_UNICODE);
    }
});

require_once __DIR__ . '/../../bootstrap.php'; // tuyệt đối

// ===== Utilities nhỏ =====
function json_out(array $payload, int $code = 200): void {
    while (ob_get_level() > 0) { ob_end_clean(); }
    http_response_code($code);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}
function ok($msg, $extra = []) { json_out(['success'=>true,'message'=>$msg] + $extra); }
function fail($msg, $extra = [], $code = 500) { json_out(['success'=>false,'error'=>$msg] + $extra, $code); }

// ====== BẮT & PARSE INPUT ======
$raw = file_get_contents('php://input') ?: '';
$input = json_decode($raw, true);
if (!is_array($input)) {
    fail('Invalid JSON input', ['raw'=>substr($raw,0,400)]);
}

$action     = (string)(isset($input['action']) ? $input['action'] : '');
$user_name  = isset($input['user_name']) ? trim((string)$input['user_name']) : '';
$raw_gender = getUserGenderFromDB($user_name);
$user_gender= normaliseGender($raw_gender);

// ====== ROUTER ======
try {
    switch ($action) {

        case 'generate_welcome': {
            $api_key = getOpenAIAPIKey();
            if ($api_key && $user_gender === 'unknown' && $user_name !== '') {
                $infer = inferGenderWithGPT($api_key, $user_name, '', []);
                if (in_array($infer, ['male','female','unknown'], true)) {
                    $user_gender = $infer;
                }
            }
            $welcome = generateWelcomeMessage($user_name, $user_gender);
            ok($welcome);
        }

        case 'send_message': {
            $message     = (string)(isset($input['message']) ? $input['message'] : '');
            $chat_history= is_array(isset($input['chat_history']) ? $input['chat_history'] : null) ? $input['chat_history'] : [];
            $session_id  = (string)(isset($input['session_id']) ? $input['session_id'] : uniqid('sess_', true));

            $api_key = getOpenAIAPIKey();
            if ($api_key && $user_gender === 'unknown') {
                $infer = inferGenderWithGPT($api_key, $user_name, $message, $chat_history);
                if (in_array($infer, ['male','female','unknown'], true)) {
                    $user_gender = $infer;
                }
            }

            $resp = generateChatResponse($message, $user_name, $user_gender, $chat_history, $session_id);
            ok($resp, ['conversation_id' => $session_id]);
        }

        case 'clear_history': {
            $session_id = (string)(isset($input['session_id']) ? $input['session_id'] : '');
            $res = clearChatHistory($user_name, $session_id);
            json_out(['success'=>$res, 'message'=>$res ? 'Lịch sử đã được xóa thành công' : 'Có lỗi xảy ra khi xóa lịch sử']);
        }

        case 'get_avatar': {
            $avatar = getPhuongNhiAvatar();
            ok('Avatar loaded', ['avatar' => $avatar]);
        }

        default:
            fail('Invalid action', ['got'=>$action], 400);
    }
} catch (Exception $e) {
    fail('SERVER_EXCEPTION', ['detail'=>$e->getMessage()]);
}

/* =========================
   Helpers: Gender & Address
   ========================= */

function normaliseGender($g) {
    $g = strtolower(trim((string)$g));
    if (in_array($g, ['male','nam','m','man','anh'], true)) return 'male';
    if (in_array($g, ['female','nữ','nu','f','woman','chị','chi'], true)) return 'female';
    return 'unknown';
}
function resolveAddress(string $user_name = '', string $user_gender = 'unknown'): string {
    $name = trim($user_name);
    $g = normaliseGender($user_gender);
    
    // Lấy tên đầu tiên (theo cấu trúc hệ thống: Tên + Họ)
    if ($name !== '') {
        $name_parts = explode(' ', $name);
        $first_name = trim($name_parts[0]); // Lấy từ đầu tiên (tên)
        
        if ($g === 'male' && $first_name !== '') return "anh {$first_name}";
        if ($g === 'female' && $first_name !== '') return "chị {$first_name}";
        // Luôn trả về tên đầu tiên, không phải cả họ tên
        if ($first_name !== '') return $first_name;
    }
    
    return 'Quý khách';
}
function sanitizePronouns(string $text, string $address): string {
    $fixed = $text;
    $map = [
        'bạn ơi' => $address.' ơi',
        'bạn nhé' => $address.' nhé',
        'bạn nha' => $address.' nha',
        'bạn à'  => $address.' à',
    ];
    foreach ($map as $k => $v) { $fixed = str_ireplace($k, $v, $fixed); }
    $fixed = preg_replace('/\b[bB]ạn\b/u', $address, $fixed);
    $fixed = preg_replace('/\b(anh|chị|Quý khách)\s+\1\b/iu', '$1', $fixed);
    return $fixed;
}

/* =========================
   DB & API (AN TOÀN)
   ========================= */

function getPhuongNhiAvatar() {
    global $db;
    try {
        // Lấy avatar của user_id = 4 (Phương Nhi)
        $result = $db->query("SELECT user_picture FROM users WHERE user_id = 4 LIMIT 1");
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['user_picture'] ?? '';
        }
        
        return '';
    } catch (Throwable $e) {
        error_log("Error getting Phương Nhi avatar: " . $e->getMessage());
        return '';
    }
}

function getUserGenderFromDB($user_name) {
    global $db;
    $name = trim((string)$user_name);
    if ($name === '') return 'unknown';
    try {
        // PHP 5.x/7.0 compatible - không dùng get_result()
        $stmt = $db->prepare("SELECT user_gender FROM users WHERE user_name = ? LIMIT 1");
        if (!$stmt) return 'unknown';
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->bind_result($gender);
        if ($stmt->fetch()) {
            $stmt->close();
            return (string)($gender ?: 'unknown');
        }
        $stmt->close();

        $stmt = $db->prepare("SELECT user_gender FROM shop_ai_user_ranks WHERE user_name = ? LIMIT 1");
        if (!$stmt) return 'unknown';
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->bind_result($gender);
        if ($stmt->fetch()) {
            $stmt->close();
            return (string)($gender ?: 'unknown');
        }
        $stmt->close();

        return 'unknown';
    } catch (Exception $e) {
        error_log("getUserGenderFromDB: ".$e->getMessage());
        return 'unknown';
    }
}

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

function inferGenderWithGPT($api_key, $user_name, $message, $chat_history = []) {
    $url = 'https://api.openai.com/v1/chat/completions';

    $hist = '';
    if (!empty($chat_history)) {
        foreach (array_slice($chat_history, -5) as $msg) {
            $sender = ($msg['sender'] ?? '') === 'user' ? 'User' : 'Bot';
            $text = $msg['text'] ?? '';
            $hist .= "{$sender}: {$text}\n";
        }
    }

    $payload = [
        'model' => 'gpt-4o-mini',
        'messages' => [
            [
                'role' => 'system',
                'content' => "Only output JSON: {\"gender\":\"male|female|unknown\"} based on Vietnamese context. If uncertain -> \"unknown\"."
            ],
            [
                'role' => 'user',
                'content' =>
"INPUT:
- name: {$user_name}
- message: {$message}
- history:
{$hist}

OUTPUT JSON ONLY."
            ]
        ],
        'temperature' => 0,
        'max_tokens' => 20
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: ' . 'Bearer ' . $api_key
        ],
        CURLOPT_TIMEOUT => 20
    ]);
    $resp = curl_exec($ch);
    $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err  = curl_error($ch);
    curl_close($ch);

    if ($code === 200 && $resp) {
        $json = json_decode($resp, true);
        $content = $json['choices'][0]['message']['content'] ?? '';
        $out = json_decode(trim($content), true);
        $g = normaliseGender($out['gender'] ?? 'unknown');
        return in_array($g, ['male','female','unknown'], true) ? $g : 'unknown';
    }
    error_log("inferGenderWithGPT HTTP:$code ERR:$err RESP:".mb_substr((string)$resp,0,300));
    return 'unknown';
}

/* =========================
   Business functions
   ========================= */

function callOpenAIDirect($api_key, $messages) {
    $url = 'https://api.openai.com/v1/chat/completions';
    $data = [
        'model' => 'gpt-4o-mini',
        'messages' => $messages,
        'temperature' => 0.7,
        'max_tokens' => 200
    ];
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization:' . ' Bearer ' . $api_key
        ],
        CURLOPT_TIMEOUT => 30
    ]);
    $resp = curl_exec($ch);
    $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err  = curl_error($ch);
    curl_close($ch);

    if ($code === 200 && $resp) {
        $result = json_decode($resp, true);
        return trim((string)($result['choices'][0]['message']['content'] ?? ''));
    }
    error_log("callOpenAIDirect HTTP:$code ERR:$err RESP:".mb_substr((string)$resp,0,300));
    return '';
}

function generateWelcomeMessage($user_name, $user_gender) {
    $api_key = getOpenAIAPIKey();
    
    // Sử dụng giờ HCM (UTC+7)
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $h = (int)date('H');
    $current_time = date('H:i');
    $current_date = date('d/m/Y');
    $greeting = ($h < 12) ? 'Chào buổi sáng' : (($h < 18) ? 'Chào buổi chiều' : 'Chào buổi tối');
    $address = resolveAddress($user_name, $user_gender);

    if (!$api_key) {
        return "{$greeting} {$address}! 😊 Em là Phương Nhi, hỗ trợ Shop-AI. {$address} cần gì em xử lý liền ạ 💕";
    }
    $messages = [
        [
            'role' => 'system',
            'content' =>
"Bạn là Phương Nhi (22t), xưng 'em'.  
Quy tắc xưng hô: nam='anh + tên', nữ='chị + tên', unknown=có tên thì gọi tên, không thì 'Quý khách'.  
QUAN TRỌNG: Chỉ lấy TÊN (từ đầu tiên), KHÔNG lấy họ. Ví dụ: 'Bùi Vũ' → chỉ gọi 'Vũ', 'Nga Nguyễn Phương' → chỉ gọi 'Nga'.  
CẤM dùng 'bạn'. Trả lời 1-2 câu, tự nhiên, ít emoji."
        ],
        [
            'role' => 'user',
            'content' => "{$greeting}. Khách: tên='{$user_name}', gender='{$user_gender}'. 
THÔNG TIN THỜI GIAN: Hiện tại là {$current_time} ngày {$current_date} (giờ HCM). 
Hãy chào đúng quy tắc và sử dụng thông tin thời gian này nếu cần."
        ]
    ];
    $out = callOpenAIDirect($api_key, $messages);
    $out = $out !== '' ? $out : "{$greeting} {$address}! 😊 Em là Phương Nhi, hỗ trợ Shop-AI.";
    return sanitizePronouns($out, $address);
}

function generateChatResponse($message, $user_name, $user_gender = 'unknown', $chat_history = [], $session_id = '') {
    $api_key = getOpenAIAPIKey();
    $address = resolveAddress($user_name, $user_gender);
    
    // Sử dụng giờ HCM (UTC+7) cho tất cả câu trả lời
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $current_time = date('H:i');
    $current_date = date('d/m/Y');
    
    if (!$api_key) {
        return "Xin lỗi {$address}, hệ thống đang bận. {$address} thử lại giúp em chút nhé!";
    }

    // Lấy dữ liệu từ knowledge base
    $knowledge_base = getKnowledgeBase();
    
    $system_data = getSystemData($message, $user_name);
    $user_price_info = '';
    
    // Xử lý logic giá check số - ĐƠN GIẢN HÓA
    if (preg_match('/\b(giá|price|rank|check số|checkso)\b/iu', $message)) {
        // Nếu user đã đăng nhập và có giá riêng
        if ($user_name !== 'Guest' && !empty($user_name)) {
            $user_price = getUserPrice($user_name);
            if ($user_price) {
                $user_price_info = "Giá check số hiện tại của {$address}: {$user_price['rank']} – {$user_price['price']} VND";
            } else {
                $user_price_info = "Giá check số: 30,000 VND (giá mặc định)";
            }
        } else {
            // Guest hoặc không đăng nhập - hiển thị bảng giá chung
            $general_pricing = getGeneralPricing();
            if (!empty($general_pricing)) {
                $user_price_info = "BẢNG GIÁ CHECK SỐ THEO RANK:\n";
                foreach ($general_pricing as $rank => $price) {
                    $user_price_info .= "- {$rank}: {$price} VND\n";
                }
            } else {
                $user_price_info = "Giá check số: 30,000 VND (giá mặc định)";
            }
        }
        
        // Debug log
        error_log("Price info for {$user_name}: " . $user_price_info);
    }

    $context = '';
    if (!empty($chat_history)) {
        $context = "Lịch sử gần đây:\n";
        foreach (array_slice($chat_history, -5) as $m) {
            $sender = ($m['sender'] ?? '') === 'user' ? 'Khách' : 'Phương Nhi';
            $text = $m['text'] ?? '';
            $context .= "{$sender}: {$text}\n";
        }
    }

    $messages = [
        [
            'role' => 'system',
            'content' =>
"Bạn là Phương Nhi (22t), xưng 'em'.  
CẤM dùng 'bạn'. Trả lời ngắn 1-2 câu, tự nhiên, chính xác theo dữ liệu kèm theo.
QUAN TRỌNG: Chỉ lấy TÊN (từ đầu tiên), KHÔNG lấy họ. Ví dụ: 'Bùi Vũ' → chỉ gọi 'Vũ', 'Nga Nguyễn Phương' → chỉ gọi 'Nga'.
THÔNG TIN THỜI GIAN: Hiện tại là {$current_time} ngày {$current_date} (giờ HCM). Sử dụng thông tin này khi trả lời về thời gian, giờ giấc, chào hỏi.
KHI TRẢ LỜI VỀ GIÁ: Nếu có thông tin giá riêng của user, trả lời về giá của họ. Nếu không có, trả lời về bảng giá chung.
TUYỆT ĐỐI KHÔNG hỏi thêm thông tin hay 'cần gì khác không'. Trả lời xong là xong, tự nhiên như người thật."
        ],
        [
            'role' => 'user',
            'content' =>
"Khách {$address} hỏi: '{$message}'

{$context}

KIẾN THỨC CỦA PHƯƠNG NHI:
{$knowledge_base}

{$system_data}

THÔNG TIN GIÁ CHECK SỐ (QUAN TRỌNG):
{$user_price_info}

QUAN TRỌNG VỀ GIÁ CHECK SỐ:
- Nếu có THÔNG TIN GIÁ CHECK SỐ ở trên, TRẢ LỜI THEO ĐÚNG THÔNG TIN ĐÓ
- Nếu hỏi chung chung về giá → trả lời 30,000 VND hoặc bảng giá rank
- Nếu hỏi giá của user cụ thể → trả lời giá riêng của họ
- TUYỆT ĐỐI KHÔNG hỏi thêm thông tin hay cần gì khác không. Trả lời xong là xong, tự nhiên như người thật."
        ]
    ];
    
    // Debug log
    error_log("Full prompt: " . json_encode($messages[1]['content']));
    
    $out = callOpenAIDirect($api_key, $messages);
    $out = $out !== '' ? $out : "Xin lỗi {$address}, em chưa hiểu ý. {$address} nói rõ hơn giúp em nhé?";
    $out = sanitizePronouns($out, $address);

    // Lưu lịch sử (best-effort)
    try { saveMessageToDatabase($session_id, $user_name, $message, $out); } catch (Throwable $e) { error_log($e->getMessage()); }
    return $out;
}

/* =========================
   Existing utilities (kept)
   ========================= */

function getSystemInfo() {
    global $db;
    $info = [];
    $get_shop_ai = $db->query("SELECT COUNT(*) as total_users FROM shop_ai_user_ranks");
    if ($get_shop_ai && $get_shop_ai->num_rows > 0) {
        $row = $get_shop_ai->fetch_assoc();
        $info['total_shop_ai_users'] = $row['total_users'];
    }
    $get_config = $db->query("SHOW TABLES LIKE 'system_config'");
    if ($get_config && $get_config->num_rows > 0) {
        $get_config_data = $db->query("SELECT config_key, config_value FROM system_config");
        if ($get_config_data && $get_config_data->num_rows > 0) {
            while ($row = $get_config_data->fetch_assoc()) {
                $info[$row['config_key']] = $row['config_value'];
            }
        }
    }
    return $info;
}

function getKnowledgeBase() {
    global $db;
    $knowledge = '';
    
    try {
        // Lấy kiến thức từ knowledge base (loại trừ usage_stats)
        $get_knowledge = $db->query("
            SELECT category, question, answer, keywords 
            FROM phuong_nhi_knowledge 
            WHERE category != 'usage_stats' 
            ORDER BY 
                CASE category 
                    WHEN 'check_number' THEN 1 
                    WHEN 'recharge' THEN 2 
                    WHEN 'pricing' THEN 3 
                    WHEN 'support' THEN 4 
                    ELSE 5 
                END, 
                id DESC 
            LIMIT 50
        ");
        
        if ($get_knowledge && $get_knowledge->num_rows > 0) {
            $knowledge .= "=== KIẾN THỨC CỦA PHƯƠNG NHI ===\n\n";
            $current_category = '';
            
            while ($row = $get_knowledge->fetch_assoc()) {
                $category = $row['category'];
                $question = trim($row['question']);
                $answer = trim($row['answer']);
                
                // Nhóm theo category
                if ($current_category !== $category) {
                    $current_category = $category;
                    $names = [
                        'check_number' => 'CHECK SỐ SHOPEE',
                        'recharge'     => 'NẠP TIỀN',
                        'pricing'      => 'BẢNG GIÁ',
                        'support'      => 'HỖ TRỢ',
                        'general'      => 'THÔNG TIN CHUNG',
                    ];
                    $category_name = isset($names[$category]) ? $names[$category] : strtoupper($category);
                    $knowledge .= "📋 {$category_name}:\n";
                }
                
                $knowledge .= "❓ {$question}\n";
                $knowledge .= "💡 {$answer}\n\n";
            }
        }
        
        // Lấy cuộc trò chuyện gần đây (7 ngày)
        $get_recent_chats = $db->query("
            SELECT DISTINCT 
                m1.message as question, 
                m2.message as answer,
                m1.created_at
            FROM phuong_nhi_messages m1 
            JOIN phuong_nhi_messages m2 ON m1.conversation_id = m2.conversation_id 
            WHERE m1.sender = 'user' 
                AND m2.sender = 'bot' 
                AND m2.id = m1.id + 1 
                AND m1.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                AND CHAR_LENGTH(m1.message) > 10
                AND CHAR_LENGTH(m2.message) > 10
            ORDER BY m1.created_at DESC 
            LIMIT 15
        ");
        
        if ($get_recent_chats && $get_recent_chats->num_rows > 0) {
            $knowledge .= "=== CUỘC TRÒ CHUYỆN GẦN ĐÂY ===\n\n";
            while ($row = $get_recent_chats->fetch_assoc()) {
                $question = trim($row['question']);
                $answer = trim($row['answer']);
                $date = date('d/m H:i', strtotime($row['created_at']));
                
                $knowledge .= "🗣️ [{$date}] Khách: {$question}\n";
                $knowledge .= "💬 Phương Nhi: {$answer}\n\n";
            }
        }
        
        // Nếu không có kiến thức nào
        if (empty(trim($knowledge))) {
            $knowledge = "Chưa có kiến thức được lưu trữ.";
        }
        
    } catch (Throwable $e) {
        error_log("getKnowledgeBase error: " . $e->getMessage());
        $knowledge = "Không thể tải kiến thức từ database.";
    }
    
    return $knowledge;
}

function getSystemData($query_type = '', $user_name = '') {
    try {
        $q = mb_strtolower((string)$query_type, 'UTF-8');
        $data = "";
        if (strpos($q, 'shop-ai') !== false || strpos($q, 'dịch vụ') !== false) {
            $data .= "THÔNG TIN SHOP-AI:\n- Website: https://shop-ai.vn\n- Dịch vụ chính: Check số Shopee, nạp tiền, bảng giá theo rank\n- URL check số: /shop-ai\n- URL nạp tiền: /shop-ai (tab Nạp tiền)\n- URL bảng giá: /shop-ai/pricing\n\n";
        }
        // Bảng giá được xử lý riêng trong $user_price_info
        if (strpos($q, 'check') !== false || strpos($q, 'shopee') !== false) {
            $data .= "HƯỚNG DẪN CHECK SỐ SHOPEE:\n- Nhập username Shopee để tìm ra số điện thoại liên kết\n- KHÔNG nhập số điện thoại\n- Truy cập: https://shop-ai.vn/shop-ai\n\n";
        }
        if (strpos($q, 'nạp') !== false || strpos($q, 'recharge') !== false) {
            $data .= "HƯỚNG DẪN NẠP TIỀN:\n- Truy cập: https://shop-ai.vn/shop-ai\n- Chọn tab 'Nạp tiền'\n- Hỗ trợ nhiều phương thức thanh toán\n\n";
        }
        if (strpos($q, 'lịch sử') !== false || strpos($q, 'history') !== false) {
            $data .= "LỊCH SỬ GIAO DỊCH:\n- Truy cập: https://shop-ai.vn/shop-ai\n- Chọn tab 'Lịch sử giao dịch'\n- Xem tất cả giao dịch đã thực hiện\n\n";
        }
        return $data;
    } catch (Exception $e) {
        error_log("Error getting system data: " . $e->getMessage());
        return "";
    }
}

function getUserPrice($user_name) {
    global $db;
    try {
        // Nếu user_name là 'Guest' thì không lấy giá riêng
        if ($user_name === 'Guest' || empty($user_name)) {
            return null;
        }
        
        // Lấy user_id từ user_name - PHP 5.x/7.0 compatible
        $stmt = $db->prepare("SELECT user_id FROM users WHERE user_name = ? LIMIT 1");
        if (!$stmt) return null;
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $stmt->bind_result($user_id);
        
        if ($stmt->fetch()) {
            $stmt->close();
            
            // Lấy rank của user
            $stmt = $db->prepare("
                SELECT r.rank_name, r.check_price 
                FROM shop_ai_user_ranks u 
                JOIN shop_ai_ranks r ON u.current_rank_id = r.rank_id 
                WHERE u.user_id = ? 
                ORDER BY u.last_updated DESC 
                LIMIT 1
            ");
            if (!$stmt) return null;
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->bind_result($rank_name, $check_price);
            
            if ($stmt->fetch()) {
                $stmt->close();
                return ['rank' => $rank_name, 'price' => $check_price];
            }
            $stmt->close();
        } else {
            $stmt->close();
        }
        return null;
    } catch (Exception $e) {
        error_log("Error getting user price: " . $e->getMessage());
        return null;
    }
}

function getGeneralPricing() {
    global $db;
    try {
        // Lấy bảng giá chung từ bảng shop_ai_ranks - PHP 5.x/7.0 compatible
        $stmt = $db->prepare("SELECT rank_name, check_price FROM shop_ai_ranks WHERE is_active = 1 ORDER BY rank_order ASC");
        if (!$stmt) return [];
        $stmt->execute();
        $stmt->bind_result($rank_name, $check_price);
        
        $pricing = [];
        while ($stmt->fetch()) {
            $pricing[$rank_name] = $check_price;
        }
        $stmt->close();
        
        return $pricing;
    } catch (Exception $e) {
        error_log("Error getting general pricing: " . $e->getMessage());
        return [];
    }
}

function saveMessageToDatabase($session_id, $user_name, $user_message, $bot_response) {
    global $db;
    try {
        $get_conv = $db->prepare("SELECT id FROM phuong_nhi_conversations WHERE session_id = ?");
        if (!$get_conv) return;
        $get_conv->bind_param("s", $session_id);
        $get_conv->execute();
        $get_conv->bind_result($conversation_id);
        if ($get_conv->fetch()) {
            $get_conv->close();
        } else {
            $get_conv->close();
            $create_conv = $db->prepare("INSERT INTO phuong_nhi_conversations (session_id, user_name, status) VALUES (?, ?, 'active')");
            $create_conv->bind_param("ss", $session_id, $user_name);
            $create_conv->execute();
            $conversation_id = $db->insert_id;
        }
        $save_user_msg = $db->prepare("INSERT INTO phuong_nhi_messages (conversation_id, sender, message) VALUES (?, 'user', ?)");
        $save_user_msg->bind_param("is", $conversation_id, $user_message);
        $save_user_msg->execute();
        $save_bot_msg = $db->prepare("INSERT INTO phuong_nhi_messages (conversation_id, sender, message) VALUES (?, 'bot', ?)");
        $save_bot_msg->bind_param("is", $conversation_id, $bot_response);
        $save_bot_msg->execute();
        analyzeAndLearn($user_message, $bot_response);
    } catch (Exception $e) {
        error_log("Error saving message to database: " . $e->getMessage());
    }
}

function clearChatHistory($user_name, $session_id = '') {
    global $db;
    try {
        if ($session_id) {
            // Xóa lịch sử của session cụ thể
            $delete_messages = $db->prepare("DELETE FROM phuong_nhi_messages WHERE conversation_id IN (SELECT id FROM phuong_nhi_conversations WHERE session_id = ?)");
            $delete_messages->bind_param("s", $session_id);
            $delete_messages->execute();
            $delete_conversation = $db->prepare("DELETE FROM phuong_nhi_conversations WHERE session_id = ?");
            $delete_conversation->bind_param("s", $session_id);
            $delete_conversation->execute();
        } else {
            // Xóa tất cả lịch sử của user
            $delete_messages = $db->prepare("DELETE FROM phuong_nhi_messages WHERE conversation_id IN (SELECT id FROM phuong_nhi_conversations WHERE user_name = ?)");
            $delete_messages->bind_param("s", $user_name);
            $delete_messages->execute();
            $delete_conversation = $db->prepare("DELETE FROM phuong_nhi_conversations WHERE user_name = ?");
            $delete_conversation->bind_param("s", $user_name);
            $delete_conversation->execute();
        }
        return true;
    } catch (Exception $e) {
        error_log("Error clearing chat history: " . $e->getMessage());
        return false;
    }
}

function analyzeAndLearn($user_message, $bot_response) {
    global $db;
    try {
        $keywords = extractKeywords($user_message);
        
        // Kiểm tra nếu câu hỏi có giá trị học tập
        if (shouldLearnFromMessage($user_message, $bot_response)) {
            createKnowledgeFromChat($user_message, $bot_response, $keywords);
        }
        
        // Cập nhật thống kê sử dụng
        updateUsageStats($keywords);
        
        // Log việc học để debug
        error_log("Learning analysis: Message='{$user_message}', Response='{$bot_response}', Keywords='{$keywords}'");
        
    } catch (Exception $e) {
        error_log("Error in analyzeAndLearn: " . $e->getMessage());
    }
}

function shouldLearnFromMessage($user_message, $bot_response) {
    // Chỉ học nếu:
    // 1. Câu hỏi đủ dài (>10 ký tự)
    // 2. Câu trả lời đủ dài (>20 ký tự) 
    // 3. Không phải câu hỏi quá đơn giản
    // 4. Câu trả lời có thông tin hữu ích
    
    if (mb_strlen($user_message) < 10 || mb_strlen($bot_response) < 20) {
        return false;
    }
    
    // Loại bỏ các câu hỏi quá đơn giản
    $simple_patterns = [
        '/^(xin chào|hello|hi|chào|hey)$/i',
        '/^(cảm ơn|thanks|thank you)$/i',
        '/^(tạm biệt|bye|goodbye)$/i',
        '/^(ok|được|tốt|good)$/i'
    ];
    
    foreach ($simple_patterns as $pattern) {
        if (preg_match($pattern, trim($user_message))) {
            return false;
        }
    }
    
    // Loại bỏ câu trả lời không hữu ích
    $unhelpful_patterns = [
        '/^(xin lỗi|sorry|em chưa hiểu|không biết)/i',
        '/^(thử lại|vui lòng thử)/i'
    ];
    
    foreach ($unhelpful_patterns as $pattern) {
        if (preg_match($pattern, trim($bot_response))) {
            return false;
        }
    }
    
    // Kiểm tra nếu chứa thông tin hữu ích
    $useful_indicators = [
        'hướng dẫn', 'cách', 'làm sao', 'như thế nào', 'tại sao',
        'check số', 'shopee', 'nạp tiền', 'bảng giá', 'rank',
        'username', 'số điện thoại', 'tài khoản', 'website', 'url'
    ];
    
    $message_lower = mb_strtolower($user_message, 'UTF-8');
    foreach ($useful_indicators as $indicator) {
        if (mb_strpos($message_lower, $indicator, 0, 'UTF-8') !== false) {
            return true;
        }
    }
    
    return false;
}

function extractKeywords($message) {
    $keywords = [];
    $words = explode(' ', mb_strtolower((string)$message, 'UTF-8'));
    foreach ($words as $word) {
        $word = trim($word, '.,!?');
        if (mb_strlen($word, 'UTF-8') > 2) $keywords[] = $word;
    }
    return implode(', ', $keywords);
}

function containsNewInformation($message) {
    $indicators = ['hướng dẫn','cách','làm sao','như thế nào','tại sao','check số','shopee','nạp tiền','bảng giá','rank','username','số điện thoại','tài khoản'];
    $m = mb_strtolower((string)$message, 'UTF-8');
    foreach ($indicators as $x) {
        if (mb_strpos($m, $x, 0, 'UTF-8') !== false) return true;
    }
    return false;
}

function createKnowledgeFromChat($user_message, $bot_response, $keywords) {
    global $db;
    try {
        $category = determineCategory($user_message);
        $question = createQuestionFromMessage($user_message);
        $check = $db->prepare("SELECT id FROM phuong_nhi_knowledge WHERE question = ?");
        if (!$check) return;
        $check->bind_param("s", $question);
        $check->execute();
        $check->bind_result($id);
        if (!$check->fetch()) {
            $check->close();
            $ins = $db->prepare("INSERT INTO phuong_nhi_knowledge (category, question, answer, keywords) VALUES (?, ?, ?, ?)");
            $ins->bind_param("ssss", $category, $question, $bot_response, $keywords);
            $ins->execute();
            error_log("New knowledge created: " . $question);
        } else {
            $check->close();
        }
    } catch (Exception $e) {
        error_log("Error creating knowledge from chat: " . $e->getMessage());
    }
}

function determineCategory($message) {
    $m = mb_strtolower((string)$message, 'UTF-8');
    if (mb_strpos($m, 'check số', 0, 'UTF-8') !== false || mb_strpos($m, 'shopee', 0, 'UTF-8') !== false) return 'check_number';
    if (mb_strpos($m, 'nạp tiền', 0, 'UTF-8') !== false || mb_strpos($m, 'recharge', 0, 'UTF-8') !== false) return 'recharge';
    if (mb_strpos($m, 'bảng giá', 0, 'UTF-8') !== false || mb_strpos($m, 'pricing', 0, 'UTF-8') !== false) return 'pricing';
    if (mb_strpos($m, 'hỗ trợ', 0, 'UTF-8') !== false || mb_strpos($m, 'support', 0, 'UTF-8') !== false) return 'support';
    return 'general';
}

function createQuestionFromMessage($message) {
    $q = trim((string)$message);
    if (!preg_match('/[?！？]$/u', $q)) $q .= '?';
    return $q;
}

function updateUsageStats($keywords) {
    global $db;
    try {
        $now = date('Y-m-d H:i:s');
        // Giữ nguyên bảng cũ (chưa có UNIQUE KEY -> khuyến nghị tạo unique theo (category,question))
        $stmt = $db->prepare(" INSERT INTO phuong_nhi_knowledge (category, question, answer, keywords) VALUES ('usage_stats', 'keyword_usage', ?, ?) ON DUPLICATE KEY UPDATE keywords = CONCAT(keywords, ', ', ?) ");
        $stmt->bind_param("sss", $now, $keywords, $keywords);
        $stmt->execute();
    } catch (Exception $e) {
        error_log("Error updating usage stats: " . $e->getMessage());
    }
}