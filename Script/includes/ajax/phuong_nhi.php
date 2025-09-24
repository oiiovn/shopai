<?php
require_once('../../bootstrap.php');

try {
    // Get POST data
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) {
        throw new Exception('Invalid JSON input');
    }

    $action      = $input['action'] ?? '';
    // KHÔNG dùng 'bạn' làm mặc định để tránh sinh "bạn bạn"
    $user_name   = isset($input['user_name']) ? trim($input['user_name']) : '';
    $raw_gender  = getUserGenderFromDB($user_name); // male/female/unknown (từ DB)
    $user_gender = normaliseGender($raw_gender);    // Chuẩn hoá male|female|unknown

    switch ($action) {
        case 'generate_welcome': {
            // Thử suy luận giới tính nếu DB không có
            $api_key = getOpenAIAPIKey();
            if ($api_key && $user_gender === 'unknown' && $user_name !== '') {
                $infer = inferGenderWithGPT($api_key, $user_name, '', []); // welcome chưa có message
                if (in_array($infer, ['male','female','unknown'], true)) {
                    $user_gender = $infer;
                }
            }

            $welcome_message = generateWelcomeMessage($user_name, $user_gender);
            echo json_encode(['success' => true, 'message' => $welcome_message]);
            break;
        }

        case 'send_message': {
            $message     = $input['message'] ?? '';
            $chat_history= $input['chat_history'] ?? [];
            $session_id  = $input['session_id'] ?? uniqid();

            // Thử suy luận giới tính dựa trên tin nhắn + history nếu còn unknown
            $api_key = getOpenAIAPIKey();
            if ($api_key && $user_gender === 'unknown') {
                $user_gender_infer = inferGenderWithGPT($api_key, $user_name, $message, $chat_history);
                if (in_array($user_gender_infer, ['male','female','unknown'], true)) {
                    $user_gender = $user_gender_infer;
                }
            }

            $response = generateChatResponse($message, $user_name, $user_gender, $chat_history, $session_id);
            echo json_encode(['success' => true, 'message' => $response]);
            break;
        }

        case 'clear_history': {
            $session_id = $input['session_id'] ?? '';
            $result = clearChatHistory($user_name, $session_id);
            echo json_encode(['success' => $result, 'message' => $result ? 'Lịch sử đã được xóa thành công' : 'Có lỗi xảy ra khi xóa lịch sử']);
            break;
        }

        default:
            throw new Exception('Invalid action');
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

/* =========================
   Helpers: Gender & Address
   ========================= */

function normaliseGender($g) {
    $g = mb_strtolower(trim((string)$g), 'UTF-8');
    if (in_array($g, ['male','nam','m','man','anh'], true)) return 'male';
    if (in_array($g, ['female','nữ','nu','f','woman','chị','chi'], true)) return 'female';
    return 'unknown';
}

/**
 * Chuẩn hoá cách xưng hô:
 * - male  => "anh {tên}"
 * - female=> "chị {tên}"
 * - unknown:
 *      + có tên => dùng TÊN (không thêm "bạn")
 *      + không tên => "Quý khách"
 */
function resolveAddress(string $user_name = '', string $user_gender = 'unknown'): string {
    $name = trim($user_name);
    $g = normaliseGender($user_gender);

    if ($g === 'male'   && $name !== '') return "anh {$name}";
    if ($g === 'female' && $name !== '') return "chị {$name}";
    if ($name !== '') return $name;      // unknown + có tên => gọi thẳng tên
    return 'Quý khách';
}

/**
 * Loại bỏ hoàn toàn "bạn" và các cụm liên quan. Thay bằng $address (nếu address là tên trần).
 * Nếu address dạng "anh A"/"chị B" hoặc "Quý khách", thay word-boundary "bạn" => $address.
 */
function sanitizePronouns(string $text, string $address): string {
    $fixed = $text;

    // Map vài cụm hay gặp trước (để tự nhiên hơn)
    $map = [
        'bạn ơi' => $address.' ơi',
        'bạn nhé' => $address.' nhé',
        'bạn nha' => $address.' nha',
        'bạn à'  => $address.' à',
    ];
    foreach ($map as $k => $v) {
        $fixed = str_ireplace($k, $v, $fixed);
    }

    // Thay standalone "bạn" (whole word) -> $address
    $fixed = preg_replace('/\b[bB]ạn\b/u', $address, $fixed);

    // Dọn lặp vô tình: "anh anh", "chị chị", "Quý khách Quý khách"
    $fixed = preg_replace('/\b(anh|chị|Quý khách)\s+\1\b/iu', '$1', $fixed);

    return $fixed;
}

/* =========================
   DB & API
   ========================= */

function getUserGenderFromDB($user_name) {
    global $db;
    $name = trim((string)$user_name);
    if ($name === '') return 'unknown';

    try {
        // users
        $result = $db->query("SELECT user_gender FROM users WHERE user_name = '{$name}' LIMIT 1");
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['user_gender'] ?? 'unknown';
        }

        // shop_ai_user_ranks
        $result = $db->query("SELECT user_gender FROM shop_ai_user_ranks WHERE user_name = '{$name}' LIMIT 1");
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['user_gender'] ?? 'unknown';
        }

        return 'unknown';
    } catch (Exception $e) {
        error_log("Error getting user gender: " . $e->getMessage());
        return 'unknown';
    }
}

function getOpenAIAPIKey() {
    global $db;
    $q = $db->query("SELECT config_value FROM phuong_nhi_config WHERE config_key = 'openai_api_key'") or _error('SQL_ERROR');
    if ($q && $q->num_rows > 0) {
        $row = $q->fetch_assoc();
        return $row['config_value'];
    }
    return null;
}

/**
 * Suy luận giới tính bằng GPT (male|female|unknown) dựa trên tên + nội dung chat
 * Trả về: 'male' | 'female' | 'unknown'
 */
function inferGenderWithGPT($api_key, $user_name, $message, $chat_history = []) {
    $url = 'https://api.openai.com/v1/chat/completions';

    // Lấy 3-5 message gần nhất
    $hist = '';
    if (!empty($chat_history)) {
        foreach (array_slice($chat_history, -5) as $msg) {
            $sender = $msg['sender'] === 'user' ? 'User' : 'Bot';
            $hist  .= "{$sender}: {$msg['text']}\n";
        }
    }

    $prompt = [
        [
            'role' => 'system',
            'content' => "You are a VN assistant that ONLY outputs a single JSON object with a 'gender' field: 'male' | 'female' | 'unknown'. Infer from Vietnamese context (pronouns like 'anh/chị/em/mình' etc.), name heuristics if helpful, and chat content. If uncertain, output 'unknown'. No extra text."
        ],
        [
            'role' => 'user',
            'content' =>
"INPUT:
- name: {$user_name}
- message: {$message}
- history:
{$hist}

OUTPUT JSON EXAMPLE:
{\"gender\":\"male\"}"
        ]
    ];

    $data = [
        'model' => 'gpt-4o-mini',
        'messages' => $prompt,
        'temperature' => 0,
        'max_tokens' => 20,
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $api_key
        ],
        CURLOPT_TIMEOUT => 20
    ]);
    $resp = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($code === 200 && $resp) {
        $json = json_decode($resp, true);
        $content = $json['choices'][0]['message']['content'] ?? '';
        // Parse JSON cố gắng
        $out = @json_decode(trim($content), true);
        $g = isset($out['gender']) ? normaliseGender($out['gender']) : 'unknown';
        return in_array($g, ['male','female','unknown'], true) ? $g : 'unknown';
    }
    return 'unknown';
}

/* =========================
   Business functions
   ========================= */

function generateWelcomeMessage($user_name, $user_gender) {
    $api_key = getOpenAIAPIKey();

    $time_of_day = (int)date('H');
    $greeting = ($time_of_day < 12) ? 'Chào buổi sáng' : (($time_of_day < 18) ? 'Chào buổi chiều' : 'Chào buổi tối');

    $address = resolveAddress($user_name, $user_gender);

    // Không có API -> fallback an toàn, KHÔNG dùng từ "bạn"
    if (!$api_key) {
        return "{$greeting} {$address}! 😊 Em là Phương Nhi, hỗ trợ Shop-AI. Em có thể giúp {$address} về check số Shopee, nạp tiền, bảng giá theo rank… {$address} cần gì em hỗ trợ liền ạ 💕";
    }

    // GPT trả lời ngắn, KHÔNG dùng 'bạn'
    $messages = [
        [
            'role' => 'system',
            'content' =>
"Bạn là Phương Nhi (22t), nhân viên mới Shop-AI. Xưng 'em'.
QUY TẮC XƯNG HÔ:
- Nam => 'anh + tên'
- Nữ => 'chị + tên'
- Unknown => dùng 'tên' nếu có, nếu không có tên thì dùng 'Quý khách'.
TUYỆT ĐỐI KHÔNG dùng từ 'bạn'.

PHONG CÁCH TRẢ LỜI:
- Ngắn gọn, 1-2 câu
- Tự nhiên như người thật
- Không formal, dùng từ lóng nhẹ
- Có emoji nhưng ít (1-2 emoji)
- Hỏi lại để tiếp tục hội thoại
- Không lặp lại thông tin đã nói"
        ],
        [
            'role' => 'user',
            'content' => "{$greeting}. Khách: tên='{$user_name}', gender='{$user_gender}'. Hãy chào theo quy tắc."
        ]
    ];

    $response = callOpenAIDirect($api_key, $messages);
    if ($response) {
        // Loại từ "bạn" nếu lỡ sinh ra
        $response = sanitizePronouns($response, $address);
        return $response;
    }

    // Fallback
    return "{$greeting} {$address}! 😊 Em là Phương Nhi, hỗ trợ Shop-AI. Em có thể giúp {$address} về check số Shopee, nạp tiền, bảng giá theo rank… {$address} cần gì em hỗ trợ liền ạ 💕";
}

function generateChatResponse($message, $user_name, $user_gender = 'unknown', $chat_history = [], $session_id = '') {
    $api_key = getOpenAIAPIKey();
    $address = resolveAddress($user_name, $user_gender);

    if (!$api_key) {
        return "Xin lỗi {$address}, hệ thống đang bận. {$address} thử lại giúp em trong giây lát nhé!";
    }

    // Dữ liệu hệ thống & giá user (nếu hỏi giá)
    $system_data = getSystemData($message, $user_name);
    $user_price_info = '';
    if (strpos(mb_strtolower($message, 'UTF-8'), 'giá') !== false || strpos(mb_strtolower($message, 'UTF-8'), 'price') !== false) {
        $user_price = getUserPrice($user_name);
        if ($user_price) {
            $user_price_info = "Giá hiện tại của {$address}: {$user_price['rank']} – {$user_price['price']} VND";
        }
    }
    
    // Lấy knowledge base
    $knowledge_base = getKnowledgeBase();

    // Gộp 5 tin gần nhất làm context và tìm cách xưng hô đã dùng (chỉ cho Guest)
    $context = '';
    $previous_address = '';
    if (!empty($chat_history) && $user_name === 'Guest') {
        $context = "Lịch sử chat gần đây:\n";
        foreach (array_slice($chat_history, -5) as $msg) {
            $sender = $msg['sender'] === 'user' ? 'Khách' : 'Phương Nhi';
            $context .= "{$sender}: {$msg['text']}\n";
            
            // Tìm cách xưng hô trong tin nhắn bot gần nhất
            if ($msg['sender'] === 'bot' && empty($previous_address)) {
                // Tìm pattern "anh {tên}" hoặc "chị {tên}"
                if (preg_match('/\b(anh|chị)\s+(\w+)/', $msg['text'], $matches)) {
                    $previous_address = $matches[1] . ' ' . $matches[2];
                }
            }
        }
        
        // Ưu tiên cách xưng hô đã dùng trước đó (chỉ cho Guest)
        if (!empty($previous_address)) {
            $address = $previous_address;
        }
    } elseif (!empty($chat_history)) {
        // User đã đăng nhập - chỉ lấy context không thay đổi address
        $context = "Lịch sử chat gần đây:\n";
        foreach (array_slice($chat_history, -5) as $msg) {
            $sender = $msg['sender'] === 'user' ? 'Khách' : 'Phương Nhi';
            $context .= "{$sender}: {$msg['text']}\n";
        }
    }

    $messages = [
        [
            'role' => 'system',
            'content' =>
"Bạn là Phương Nhi (22t), nhân viên mới Shop-AI. Xưng 'em'.
QUY TẮC XƯNG HÔ:
- Nam => 'anh + tên'
- Nữ => 'chị + tên'
- Unknown => dùng 'tên' nếu có, nếu không có tên thì dùng 'Quý khách'.
TUYỆT ĐỐI KHÔNG dùng từ 'bạn'.

PHONG CÁCH TRẢ LỜI:
- Ngắn gọn, 1-2 câu
- Tự nhiên như người thật
- Không formal, dùng từ lóng nhẹ
- Có emoji nhưng ít (1-2 emoji)
- Hỏi lại để tiếp tục hội thoại
- Không lặp lại thông tin đã nói
- Trả lời chính xác theo dữ liệu hệ thống"
        ],
        [
            'role' => 'user',
            'content' =>
"Khách {$address} hỏi: '{$message}'

{$context}

{$system_data}

{$user_price_info}

KIẾN THỨC CỦA PHƯƠNG NHI:
{$knowledge_base}

Hãy trả lời ngắn gọn, tự nhiên như người thật. Dùng đúng cách xưng hô (cấm dùng 'bạn'). Sử dụng kiến thức trên để trả lời chính xác."
        ]
    ];

    $response = callOpenAIDirect($api_key, $messages);
    if ($response) {
        $response = sanitizePronouns($response, $address);
        saveMessageToDatabase($session_id, $user_name, $message, $response);
        return $response;
    }

    return "Xin lỗi {$address}, em chưa hiểu ý. {$address} có thể nói rõ hơn để em hỗ trợ chuẩn nhất ạ?";
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

    $get_knowledge = $db->query("SELECT category, question, answer FROM phuong_nhi_knowledge WHERE category != 'usage_stats' ORDER BY category, id DESC");
    if ($get_knowledge && $get_knowledge->num_rows > 0) {
        while ($row = $get_knowledge->fetch_assoc()) {
            $knowledge .= "Q: {$row['question']}\nA: {$row['answer']}\n\n";
        }
    }

    $get_recent_chats = $db->query("
        SELECT DISTINCT m1.message as question, m2.message as answer
        FROM phuong_nhi_messages m1
        JOIN phuong_nhi_messages m2 ON m1.conversation_id = m2.conversation_id
        WHERE m1.sender = 'user' AND m2.sender = 'bot'
        AND m2.id = m1.id + 1
        AND m1.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
        ORDER BY m1.created_at DESC
        LIMIT 10
    ");
    if ($get_recent_chats && $get_recent_chats->num_rows > 0) {
        $knowledge .= "THÔNG TIN TỪ CUỘC TRÒ CHUYỆN GẦN ĐÂY:\n";
        while ($row = $get_recent_chats->fetch_assoc()) {
            $knowledge .= "Q: {$row['question']}\nA: {$row['answer']}\n\n";
        }
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
        if (strpos($q, 'giá') !== false || strpos($q, 'price') !== false || strpos($q, 'rank') !== false) {
            $data .= "BẢNG GIÁ THEO RANK:\n- Bronze: 30k VND\n- Silver: 25k VND\n- Gold: 20k VND\n- Platinum: 15k VND\n- Diamond: 10k VND\n- Master: 8k VND\n- Grandmaster: 6k VND\n- Legend: 5k VND\n\n";
        }
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
        $stmt = $db->prepare("
            SELECT rank_name, price_per_check
            FROM shop_ai_user_ranks
            WHERE user_name = ?
            ORDER BY id DESC
            LIMIT 1
        ");
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            return ['rank' => $row['rank_name'], 'price' => $row['price_per_check']];
        }
        return null;
    } catch (Exception $e) {
        error_log("Error getting user price: " . $e->getMessage());
        return null;
    }
}

function saveMessageToDatabase($session_id, $user_name, $user_message, $bot_response) {
    global $db;
    try {
        $get_conv = $db->prepare("SELECT id FROM phuong_nhi_conversations WHERE session_id = ?");
        $get_conv->bind_param("s", $session_id);
        $get_conv->execute();
        $result = $get_conv->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $conversation_id = $row['id'];
        } else {
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
        if (containsNewInformation($user_message)) {
            createKnowledgeFromChat($user_message, $bot_response, $keywords);
        }
        updateUsageStats($keywords);
    } catch (Exception $e) {
        error_log("Error in analyzeAndLearn: " . $e->getMessage());
    }
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
        $check->bind_param("s", $question);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows == 0) {
            $ins = $db->prepare("INSERT INTO phuong_nhi_knowledge (category, question, answer, keywords) VALUES (?, ?, ?, ?)");
            $ins->bind_param("ssss", $category, $question, $bot_response, $keywords);
            $ins->execute();
            error_log("New knowledge created: " . $question);
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
        $stmt = $db->prepare("
            INSERT INTO phuong_nhi_knowledge (category, question, answer, keywords)
            VALUES ('usage_stats', 'keyword_usage', ?, ?)
            ON DUPLICATE KEY UPDATE keywords = CONCAT(keywords, ', ', ?)
        ");
        $stmt->bind_param("sss", $now, $keywords, $keywords);
        $stmt->execute();
    } catch (Exception $e) {
        error_log("Error updating usage stats: " . $e->getMessage());
    }
}

/* =========================
   OpenAI callers (kept)
   ========================= */

function callOpenAIDirect($api_key, $messages) {
    $url = 'https://api.openai.com/v1/chat/completions';
    $data = [
        'model' => 'gpt-4o-mini',
        'messages' => $messages,
        'temperature' => 0.7,
        'max_tokens' => 200,
        'top_p' => 1,
        'frequency_penalty' => 0,
        'presence_penalty' => 0,
    ];
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json','Authorization: Bearer ' . $api_key],
        CURLOPT_TIMEOUT => 30
    ]);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code === 200 && $response) {
        $result = json_decode($response, true);
        if (isset($result['choices'][0]['message']['content'])) {
            return trim($result['choices'][0]['message']['content']);
        }
    }
    return false;
}

function callOpenAI($api_key, $prompt) {
    $url = 'https://api.openai.com/v1/chat/completions';
    $data = [
        'model' => 'gpt-4o-mini',
        'messages' => [
            [
                'role' => 'system',
                'content' =>
'Bạn là Phương Nhi (22t), nhân viên mới Shop-AI. Xưng "em".
QUY TẮC XƯNG HÔ:
- Nam => "anh + tên"
- Nữ => "chị + tên"
- Unknown => dùng "tên" nếu có; nếu không có tên thì dùng "Quý khách".
TUYỆT ĐỐI KHÔNG dùng từ "bạn".

PHONG CÁCH TRẢ LỜI:
- Ngắn gọn, 1-2 câu
- Tự nhiên như người thật
- Không formal, dùng từ lóng nhẹ
- Có emoji nhưng ít (1-2 emoji)
- Hỏi lại để tiếp tục hội thoại
- Không lặp lại thông tin đã nói
- Trả lời chính xác theo dữ liệu hệ thống'
            ],
            [
                'role' => 'user',
                'content' => $prompt
            ]
        ],
        'temperature' => 0.7,
        'max_tokens' => 200,
        'top_p' => 1,
        'frequency_penalty' => 0.1,
        'presence_penalty' => 0.1
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json','Authorization: Bearer ' . $api_key],
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => false
    ]);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);

    if ($curl_error) {
        error_log("OpenAI API cURL Error: " . $curl_error);
        return false;
    }
    if ($http_code === 200 && $response) {
        $result = json_decode($response, true);
        if (isset($result['choices'][0]['message']['content'])) {
            return trim($result['choices'][0]['message']['content']);
        }
    } else {
        error_log("OpenAI API HTTP Error: " . $http_code . " - " . $response);
    }
    return false;
}
?>
