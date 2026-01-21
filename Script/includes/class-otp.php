<?php

/**
 * class -> OTP Rental
 * 
 * Tích hợp với VIOTP API để cho thuê số điện thoại nhận OTP
 * 
 * @package Sngine
 * @author ShopAI Team
 */

class OTPRental
{
    private $pdo;
    private $config = [];
    private $base_url;
    private $api_token;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // Khởi tạo PDO connection - hỗ trợ cả socket cho macOS/Linux
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        
        // Thêm socket nếu là localhost trên XAMPP macOS
        if (DB_HOST === 'localhost' && file_exists('/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock')) {
            $dsn = "mysql:unix_socket=/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock;dbname=" . DB_NAME . ";charset=utf8mb4";
        }
        
        $this->pdo = new PDO(
            $dsn,
            DB_USER,
            DB_PASSWORD,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
        
        // Load config từ database
        $this->loadConfig();
    }
    
    /**
     * Load cấu hình từ database
     */
    private function loadConfig()
    {
        $stmt = $this->pdo->query("SELECT config_key, config_value FROM otp_config");
        while ($row = $stmt->fetch()) {
            $this->config[$row['config_key']] = $row['config_value'];
        }
        
        $this->base_url = $this->config['viotp_base_url'] ?? 'https://api.viotp.com';
        $this->api_token = $this->config['viotp_token'] ?? '';
    }
    
    /**
     * Gọi VIOTP API
     * 
     * @param string $endpoint
     * @param array $params
     * @param string $method
     * @return array
     */
    private function callAPI($endpoint, $params = [], $method = 'GET')
    {
        $url = $this->base_url . $endpoint;
        
        // Thêm token vào params
        $params['token'] = $this->api_token;
        
        $ch = curl_init();
        
        if ($method === 'GET') {
            $url .= '?' . http_build_query($params);
            curl_setopt($ch, CURLOPT_HTTPGET, true);
        } else {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json'
        ]);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            return ['success' => false, 'message' => 'CURL Error: ' . $error];
        }
        
        $data = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['success' => false, 'message' => 'Invalid JSON response', 'raw' => $response];
        }
        
        return $data;
    }
    
    /**
     * Lọc bỏ nội dung nhạy cảm (URL viotp, audio links, etc.)
     * 
     * @param string $content
     * @return string
     */
    private function filterSensitiveContent($content)
    {
        if (empty($content)) {
            return '';
        }
        
        // Danh sách pattern cần lọc
        $patterns = [
            // URL viotp
            '/https?:\/\/[^\s]*viotp[^\s]*/i',
            // URL cdn-ns viotp
            '/https?:\/\/cdn[^\s]*viotp[^\s]*/i',
            // URL audio/wav/mp3
            '/https?:\/\/[^\s]*\.(wav|mp3|ogg|audio)[^\s]*/i',
            // Bất kỳ mention viotp
            '/viotp\.com/i',
            '/viotp/i',
        ];
        
        foreach ($patterns as $pattern) {
            $content = preg_replace($pattern, '[Nội dung đã được ẩn]', $content);
        }
        
        // Nếu nội dung chỉ là URL bị ẩn, trả về chuỗi rỗng
        if (trim($content) === '[Nội dung đã được ẩn]') {
            return '';
        }
        
        return trim($content);
    }
    
    /**
     * Lấy số dư tài khoản VIOTP
     * 
     * @return array
     */
    public function getBalance()
    {
        return $this->callAPI('/users/balance');
    }
    
    /**
     * Lấy danh sách nhà mạng từ VIOTP API
     * 
     * @return array
     */
    public function getNetworksFromAPI()
    {
        return $this->callAPI('/networks/get');
    }
    
    /**
     * Lấy danh sách dịch vụ từ VIOTP API
     * 
     * @param string $country vn hoặc la
     * @return array
     */
    public function getServicesFromAPI($country = 'vn')
    {
        return $this->callAPI('/service/getv2', ['country' => $country]);
    }
    
    /**
     * Lấy danh sách dịch vụ từ database
     * 
     * @param string $country
     * @return array
     */
    public function getServices($country = 'vn')
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM otp_services 
            WHERE country = ? AND is_active = 1 
            ORDER BY name ASC
        ");
        $stmt->execute([$country]);
        return $stmt->fetchAll();
    }
    
    /**
     * Lấy danh sách nhà mạng từ database
     * 
     * @param string $country
     * @return array
     */
    public function getNetworks($country = 'vn')
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM otp_networks 
            WHERE country = ? AND is_active = 1 
            ORDER BY name ASC
        ");
        $stmt->execute([$country]);
        return $stmt->fetchAll();
    }
    
    /**
     * Lấy giá dịch vụ (đã nhân hệ số)
     * 
     * @param int $service_id
     * @return float
     */
    public function getServicePrice($service_id)
    {
        $stmt = $this->pdo->prepare("SELECT price FROM otp_services WHERE service_id = ?");
        $stmt->execute([$service_id]);
        $service = $stmt->fetch();
        
        if (!$service) {
            return 0;
        }
        
        $multiplier = floatval($this->config['price_multiplier'] ?? 1);
        return $service['price'] * $multiplier;
    }
    
    /**
     * Thuê số điện thoại mới
     * 
     * @param int $user_id
     * @param int $service_id
     * @param int|null $network_id
     * @param string|null $prefix
     * @param string|null $except_prefix
     * @return array
     */
    public function rentNumber($user_id, $service_id, $network_id = null, $prefix = null, $except_prefix = null)
    {
        try {
            // Kiểm tra giới hạn request mỗi ngày
            $max_requests = intval($this->config['max_requests_per_user'] ?? 50);
            $today_requests = $this->getUserTodayRequests($user_id);
            
            if ($today_requests >= $max_requests) {
                return [
                    'success' => false,
                    'message' => 'Bạn đã đạt giới hạn ' . $max_requests . ' yêu cầu/ngày'
                ];
            }
            
            // Lấy thông tin dịch vụ
            $stmt = $this->pdo->prepare("SELECT * FROM otp_services WHERE service_id = ? AND is_active = 1");
            $stmt->execute([$service_id]);
            $service = $stmt->fetch();
            
            if (!$service) {
                return ['success' => false, 'message' => 'Dịch vụ không tồn tại hoặc đã bị tắt'];
            }
            
            // Tính giá
            $multiplier = floatval($this->config['price_multiplier'] ?? 1);
            $final_price = $service['price'] * $multiplier;
            
            // Kiểm tra số dư user
            $user_balance = $this->getUserBalance($user_id);
            if ($user_balance < $final_price) {
                return [
                    'success' => false,
                    'message' => 'Số dư không đủ. Cần: ' . number_format($final_price, 0, ',', '.') . 'đ, Hiện có: ' . number_format($user_balance, 0, ',', '.') . 'đ'
                ];
            }
            
            // Lấy thông tin nhà mạng nếu có
            $network_name = null;
            $network_viotp_id = null;
            if ($network_id) {
                $stmt = $this->pdo->prepare("SELECT * FROM otp_networks WHERE network_id = ?");
                $stmt->execute([$network_id]);
                $network = $stmt->fetch();
                if ($network) {
                    $network_name = $network['name'];
                    $network_viotp_id = $network['viotp_id'];
                }
            }
            
            // Gọi VIOTP API để thuê số - Sử dụng endpoint đúng: /request/getv2
            $api_params = [
                'serviceId' => $service['viotp_id']
            ];
            
            // Thêm country nếu là Lào
            if ($service['country'] === 'la') {
                $api_params['country'] = 'la';
            }
            
            // Thêm network name (không phải ID) - VD: MOBIFONE|VINAPHONE|
            if ($network_name) {
                $api_params['network'] = $network_name . '|';
            }
            if ($prefix) {
                // Format: 90|91|92|
                $api_params['prefix'] = rtrim($prefix, '|') . '|';
            }
            if ($except_prefix) {
                // Format: 94|96|97|
                $api_params['exceptPrefix'] = rtrim($except_prefix, '|') . '|';
            }
            
            // API endpoint đúng: /request/getv2 với method GET
            $api_response = $this->callAPI('/request/getv2', $api_params, 'GET');
            
            // Log API response for debugging
            error_log("VIOTP API Request: " . json_encode($api_params));
            error_log("VIOTP API Response: " . json_encode($api_response));
            
            if (!isset($api_response['status_code']) || $api_response['status_code'] != 200) {
                // Xử lý các mã lỗi cụ thể từ VIOTP
                $error_message = $api_response['message'] ?? 'Lỗi từ VIOTP API';
                if (isset($api_response['status_code'])) {
                    switch ($api_response['status_code']) {
                        case 401:
                            $error_message = 'Lỗi xác thực API token';
                            break;
                        case 429:
                            $error_message = 'Đã đạt giới hạn số chờ tin nhắn';
                            break;
                        case -2:
                            $error_message = 'Số dư tài khoản VIOTP không đủ';
                            break;
                        case -3:
                            $error_message = 'Kho số đang tạm hết, vui lòng thử lại sau';
                            break;
                        case -4:
                            $error_message = 'Dịch vụ không tồn tại hoặc đang tạm ngưng';
                            break;
                    }
                }
                return [
                    'success' => false,
                    'message' => $error_message
                ];
            }
            
            $api_data = $api_response['data'] ?? [];
            
            // Trừ tiền user
            $this->deductUserBalance($user_id, $final_price, 'Thuê số OTP: ' . $service['name']);
            
            // Tính thời gian hết hạn - sử dụng NOW() của MySQL để tránh lệch múi giờ
            $expiry_minutes = intval($this->config['otp_expiry_minutes'] ?? 5);
            
            // Lưu request vào database - dùng DATE_ADD(NOW(), INTERVAL x MINUTE) thay vì PHP date()
            $stmt = $this->pdo->prepare("
                INSERT INTO otp_requests 
                (user_id, viotp_request_id, service_id, service_name, network_id, network_name, 
                 phone_number, re_phone_number, country_iso, country_code, status, price, prefix, except_prefix, expires_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?, ?, ?, DATE_ADD(NOW(), INTERVAL {$expiry_minutes} MINUTE))
            ");
            
            $stmt->execute([
                $user_id,
                $api_data['request_id'] ?? uniqid('otp_'),
                $service_id,
                $service['name'],
                $network_id,
                $network_name,
                $api_data['phone_number'] ?? '',
                $api_data['re_phone_number'] ?? '',
                $api_data['countryISO'] ?? strtoupper($service['country']),
                $api_data['countryCode'] ?? '84',
                $final_price,
                $prefix,
                $except_prefix
            ]);
            
            $request_id = $this->pdo->lastInsertId();
            
            // Lấy số dư mới
            $new_balance = $this->getUserBalance($user_id);
            
            return [
                'success' => true,
                'message' => 'Thuê số thành công',
                'data' => [
                    'request_id' => $request_id,
                    'phone_number' => $api_data['re_phone_number'] ?? $api_data['phone_number'] ?? '',
                    're_phone_number' => $api_data['re_phone_number'] ?? '',
                    'service_name' => $service['name'],
                    'price' => $final_price,
                    'expiry_minutes' => $expiry_minutes,
                    'new_balance' => $new_balance
                ]
            ];
            
        } catch (Exception $e) {
            error_log("OTP Rental Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }
    
    /**
     * Thuê lại số điện thoại cũ (Re-rent)
     * Sử dụng VIOTP API: /request/getv2 với tham số numberphone
     * 
     * @param int $user_id
     * @param int $service_id
     * @param string $phone_number Số điện thoại muốn thuê lại
     * @return array
     */
    public function reRentNumber($user_id, $service_id, $phone_number)
    {
        try {
            // Kiểm tra giới hạn request mỗi ngày
            $max_requests = intval($this->config['max_requests_per_user'] ?? 50);
            $today_requests = $this->getUserTodayRequests($user_id);
            
            if ($today_requests >= $max_requests) {
                return [
                    'success' => false,
                    'message' => 'Bạn đã đạt giới hạn ' . $max_requests . ' yêu cầu/ngày'
                ];
            }
            
            // Lấy thông tin dịch vụ
            $stmt = $this->pdo->prepare("SELECT * FROM otp_services WHERE service_id = ? AND is_active = 1");
            $stmt->execute([$service_id]);
            $service = $stmt->fetch();
            
            if (!$service) {
                return ['success' => false, 'message' => 'Dịch vụ không tồn tại hoặc đã bị tắt'];
            }
            
            // Tính giá
            $multiplier = floatval($this->config['price_multiplier'] ?? 1);
            $final_price = $service['price'] * $multiplier;
            
            // Kiểm tra số dư user
            $user_balance = $this->getUserBalance($user_id);
            if ($user_balance < $final_price) {
                return [
                    'success' => false,
                    'message' => 'Số dư không đủ. Cần: ' . number_format($final_price, 0, ',', '.') . 'đ, Hiện có: ' . number_format($user_balance, 0, ',', '.') . 'đ'
                ];
            }
            
            // Chuẩn hóa số điện thoại (bỏ số 0 đầu nếu có)
            $phone_number = ltrim($phone_number, '0');
            
            // Gọi VIOTP API để thuê lại số - dùng tham số numberphone
            $api_params = [
                'serviceId' => $service['viotp_id'],
                'numberphone' => $phone_number  // Tham số để thuê lại số cũ
            ];
            
            // Thêm country nếu là Lào
            if ($service['country'] === 'la') {
                $api_params['country'] = 'la';
            }
            
            error_log("VIOTP Re-Rent Request: " . json_encode($api_params));
            
            $api_response = $this->callAPI('/request/getv2', $api_params, 'GET');
            
            error_log("VIOTP Re-Rent Response: " . json_encode($api_response));
            
            if (!isset($api_response['status_code']) || $api_response['status_code'] != 200) {
                $error_message = $api_response['message'] ?? 'Không thể thuê lại số này';
                
                // Xử lý các mã lỗi cụ thể
                if (isset($api_response['status_code'])) {
                    switch ($api_response['status_code']) {
                        case -3:
                            $error_message = 'Số điện thoại này hiện không khả dụng, vui lòng thử lại sau';
                            break;
                        case -5:
                            $error_message = 'Số điện thoại đang được sử dụng bởi người khác';
                            break;
                    }
                }
                
                return [
                    'success' => false,
                    'message' => $error_message
                ];
            }
            
            $api_data = $api_response['data'] ?? [];
            
            // Trừ tiền user
            $this->deductUserBalance($user_id, $final_price, 'Thuê lại số OTP: ' . $service['name'] . ' - ' . $phone_number);
            
            // Tính thời gian hết hạn
            $expiry_minutes = intval($this->config['otp_expiry_minutes'] ?? 5);
            
            // Lưu request vào database
            $stmt = $this->pdo->prepare("
                INSERT INTO otp_requests 
                (user_id, viotp_request_id, service_id, service_name, network_id, network_name, 
                 phone_number, re_phone_number, country_iso, country_code, status, price, prefix, except_prefix, expires_at)
                VALUES (?, ?, ?, ?, NULL, NULL, ?, ?, ?, ?, 'pending', ?, NULL, NULL, DATE_ADD(NOW(), INTERVAL {$expiry_minutes} MINUTE))
            ");
            
            $stmt->execute([
                $user_id,
                $api_data['request_id'] ?? uniqid('otp_'),
                $service_id,
                $service['name'],
                $api_data['phone_number'] ?? $phone_number,
                $api_data['re_phone_number'] ?? ('0' . $phone_number),
                $api_data['countryISO'] ?? strtoupper($service['country']),
                $api_data['countryCode'] ?? '84',
                $final_price
            ]);
            
            $request_id = $this->pdo->lastInsertId();
            
            // Lấy expires_at vừa tạo
            $stmt = $this->pdo->prepare("SELECT expires_at FROM otp_requests WHERE request_id = ?");
            $stmt->execute([$request_id]);
            $expires_at = $stmt->fetchColumn();
            
            // Lấy số dư mới
            $new_balance = $this->getUserBalance($user_id);
            
            return [
                'success' => true,
                'message' => 'Thuê lại số thành công',
                'data' => [
                    'request_id' => $request_id,
                    'phone_number' => $api_data['re_phone_number'] ?? ('0' . $phone_number),
                    're_phone_number' => $api_data['re_phone_number'] ?? ('0' . $phone_number),
                    'service_name' => $service['name'],
                    'price' => $final_price,
                    'expires_at' => $expires_at,
                    'expiry_minutes' => $expiry_minutes,
                    'new_balance' => $new_balance
                ]
            ];
            
        } catch (Exception $e) {
            error_log("OTP Re-Rent Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }
    
    /**
     * Kiểm tra và lấy mã OTP
     * 
     * @param int $request_id
     * @param int $user_id
     * @return array
     */
    public function checkOTP($request_id, $user_id)
    {
        try {
            // Lấy thông tin request kèm theo kiểm tra hết hạn bằng MySQL
            $stmt = $this->pdo->prepare("
                SELECT *, 
                       (expires_at < NOW()) as is_expired,
                       TIMESTAMPDIFF(SECOND, NOW(), expires_at) as time_remaining_seconds
                FROM otp_requests 
                WHERE request_id = ? AND user_id = ?
            ");
            $stmt->execute([$request_id, $user_id]);
            $request = $stmt->fetch();
            
            if (!$request) {
                return ['success' => false, 'message' => 'Không tìm thấy yêu cầu'];
            }
            
            // Kiểm tra đã hết hạn chưa - dùng kết quả từ MySQL
            if ($request['is_expired']) {
                // Cập nhật trạng thái expired
                if ($request['status'] === 'pending') {
                    $this->expireRequest($request_id);
                }
                return ['success' => false, 'message' => 'Yêu cầu đã hết hạn', 'expired' => true];
            }
            
            // Nếu đã có OTP, trả về luôn
            if ($request['status'] === 'completed') {
                $stmt = $this->pdo->prepare("
                    SELECT * FROM otp_codes WHERE request_id = ? ORDER BY code_id DESC LIMIT 1
                ");
                $stmt->execute([$request_id]);
                $code = $stmt->fetch();
                
                return [
                    'success' => true,
                    'status' => 'completed',
                    'data' => [
                        'phone_number' => $request['phone_number'],
                        'code' => $code['code'] ?? '',
                        'sms_content' => $code['sms_content'] ?? ''
                    ]
                ];
            }
            
            // Gọi API kiểm tra OTP - endpoint: /session/getv2?requestId=xxx
            $api_response = $this->callAPI('/session/getv2', ['requestId' => $request['viotp_request_id']]);
            
            error_log("VIOTP Check OTP Response: " . json_encode($api_response));
            
            if (isset($api_response['status_code']) && $api_response['status_code'] == 200) {
                $api_data = $api_response['data'] ?? [];
                
                // Kiểm tra Status: 1 = Hoàn thành, 0 = Đợi tin nhắn, 2 = Hết hạn
                $status = $api_data['Status'] ?? 0;
                
                // Nếu có SMS/OTP (Status = 1 hoặc có Code/SmsContent)
                if ($status == 1 || !empty($api_data['SmsContent']) || !empty($api_data['Code'])) {
                    // Lưu mã OTP
                    // Lọc nội dung SMS trước khi lưu vào database
                    $filtered_sms = $this->filterSensitiveContent($api_data['SmsContent'] ?? '');
                    
                    $stmt = $this->pdo->prepare("
                        INSERT INTO otp_codes 
                        (request_id, viotp_id, phone_number, service_name, status, price, 
                         sms_content, is_sound, code, phone_original, country_iso, country_code, received_at)
                        VALUES (?, ?, ?, ?, 'completed', ?, ?, ?, ?, ?, ?, ?, NOW())
                    ");
                    $stmt->execute([
                        $request_id,
                        $api_data['ID'] ?? $request['viotp_request_id'],
                        $api_data['Phone'] ?? $request['phone_number'],
                        $api_data['ServiceName'] ?? $request['service_name'],
                        $api_data['Price'] ?? $request['price'],
                        $filtered_sms, // Lưu nội dung đã lọc
                        ($api_data['IsSound'] ?? false) ? 1 : 0,
                        $api_data['Code'] ?? '',
                        $api_data['PhoneOriginal'] ?? $request['phone_number'],
                        $api_data['CountryISO'] ?? $request['country_iso'],
                        $api_data['CountryCode'] ?? $request['country_code']
                    ]);
                    
                    // Cập nhật trạng thái request
                    $stmt = $this->pdo->prepare("
                        UPDATE otp_requests SET status = 'completed', completed_at = NOW() 
                        WHERE request_id = ?
                    ");
                    $stmt->execute([$request_id]);
                    
                    // Lọc bỏ thông tin nhạy cảm (URL viotp, audio, etc.)
                    $sms_content = $api_data['SmsContent'] ?? '';
                    $sms_content = $this->filterSensitiveContent($sms_content);
                    
                    return [
                        'success' => true,
                        'status' => 'completed',
                        'data' => [
                            'phone_number' => $api_data['Phone'] ?? $request['phone_number'],
                            'code' => $api_data['Code'] ?? '',
                            'sms_content' => $sms_content,
                            'is_sound' => $api_data['IsSound'] ?? false
                        ]
                    ];
                }
            }
            
            // Chưa có OTP - dùng time_remaining_seconds từ MySQL
            return [
                'success' => true,
                'status' => 'pending',
                'message' => 'Đang chờ mã OTP...',
                'data' => [
                    'phone_number' => $request['re_phone_number'] ?: $request['phone_number'],
                    'expires_at' => $request['expires_at'],
                    'time_remaining' => max(0, intval($request['time_remaining_seconds']))
                ]
            ];
            
        } catch (Exception $e) {
            error_log("Check OTP Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Lỗi hệ thống'];
        }
    }
    
    /**
     * Hủy yêu cầu thuê số
     * 
     * @param int $request_id
     * @param int $user_id
     * @return array
     */
    public function cancelRequest($request_id, $user_id)
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM otp_requests 
                WHERE request_id = ? AND user_id = ? AND status = 'pending'
            ");
            $stmt->execute([$request_id, $user_id]);
            $request = $stmt->fetch();
            
            if (!$request) {
                return ['success' => false, 'message' => 'Không tìm thấy yêu cầu hoặc đã hoàn thành'];
            }
            
            // Gọi API hủy nếu cần
            // $this->callAPI('/api/cancel/' . $request['viotp_request_id'], [], 'POST');
            
            // Hoàn tiền
            $this->refundUserBalance($user_id, $request['price'], 'Hoàn tiền hủy thuê OTP: ' . $request['service_name']);
            
            // Cập nhật trạng thái
            $stmt = $this->pdo->prepare("
                UPDATE otp_requests SET status = 'failed' WHERE request_id = ?
            ");
            $stmt->execute([$request_id]);
            
            // Lấy số dư mới
            $new_balance = $this->getUserBalance($user_id);
            
            return [
                'success' => true,
                'message' => 'Đã hủy yêu cầu và hoàn tiền ' . number_format($request['price'], 0, ',', '.') . 'đ',
                'new_balance' => $new_balance
            ];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Lỗi hệ thống'];
        }
    }
    
    /**
     * Xử lý request hết hạn
     * 
     * @param int $request_id
     */
    private function expireRequest($request_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM otp_requests WHERE request_id = ? AND refunded = 0");
        $stmt->execute([$request_id]);
        $request = $stmt->fetch();
        
        if ($request && $request['status'] === 'pending') {
            // Cập nhật trạng thái và đánh dấu đã hoàn tiền
            $stmt = $this->pdo->prepare("UPDATE otp_requests SET status = 'expired', refunded = 1 WHERE request_id = ?");
            $stmt->execute([$request_id]);
            
            // Hoàn tiền nếu bật auto_refund
            if ($this->config['auto_refund_expired'] ?? true) {
                $this->refundUserBalance(
                    $request['user_id'], 
                    $request['price'], 
                    'Hoàn tiền OTP hết hạn: ' . $request['service_name'] . ' - ' . $request['phone_number']
                );
            }
        }
    }
    
    /**
     * Xử lý tất cả request hết hạn của một user (cập nhật status + hoàn tiền)
     * 
     * @param int $user_id
     */
    private function processExpiredRequestsForUser($user_id)
    {
        // Lấy tất cả request pending đã hết hạn và chưa hoàn tiền
        $stmt = $this->pdo->prepare("
            SELECT * FROM otp_requests 
            WHERE user_id = ? 
              AND status = 'pending' 
              AND expires_at < NOW()
              AND refunded = 0
        ");
        $stmt->execute([$user_id]);
        $expired_requests = $stmt->fetchAll();
        
        foreach ($expired_requests as $request) {
            // Cập nhật trạng thái và đánh dấu đã hoàn tiền
            $stmt = $this->pdo->prepare("UPDATE otp_requests SET status = 'expired', refunded = 1 WHERE request_id = ?");
            $stmt->execute([$request['request_id']]);
            
            // Hoàn tiền nếu bật auto_refund
            if ($this->config['auto_refund_expired'] ?? true) {
                $this->refundUserBalance(
                    $request['user_id'], 
                    $request['price'], 
                    'Hoàn tiền OTP hết hạn: ' . $request['service_name'] . ' - ' . $request['phone_number']
                );
            }
        }
    }
    
    /**
     * Xử lý tất cả request hết hạn trong hệ thống (dùng cho cron job)
     * 
     * @return array
     */
    public function processExpiredRequests()
    {
        // Lấy tất cả request pending đã hết hạn và chưa hoàn tiền
        $stmt = $this->pdo->query("
            SELECT * FROM otp_requests 
            WHERE status = 'pending' 
              AND expires_at < NOW()
              AND refunded = 0
        ");
        $expired_requests = $stmt->fetchAll();
        
        $processed = 0;
        $refunded = 0;
        
        foreach ($expired_requests as $request) {
            // Cập nhật trạng thái và đánh dấu đã hoàn tiền
            $stmt = $this->pdo->prepare("UPDATE otp_requests SET status = 'expired', refunded = 1 WHERE request_id = ?");
            $stmt->execute([$request['request_id']]);
            $processed++;
            
            // Hoàn tiền nếu bật auto_refund
            if ($this->config['auto_refund_expired'] ?? true) {
                $this->refundUserBalance(
                    $request['user_id'], 
                    $request['price'], 
                    'Hoàn tiền OTP hết hạn: ' . $request['service_name'] . ' - ' . $request['phone_number']
                );
                $refunded++;
            }
        }
        
        return [
            'processed' => $processed,
            'refunded' => $refunded
        ];
    }
    
    /**
     * Lấy các request đang pending hoặc đã hoàn thành trong vòng 30 phút
     * Dùng để hiển thị lại khi user reload trang
     * 
     * @param int $user_id
     * @return array
     */
    public function getPendingRequests($user_id)
    {
        // Tự động xử lý các request đã hết hạn trước
        $this->processExpiredRequestsForUser($user_id);
        
        // Lấy các request trong vòng 30 phút (kể cả completed)
        $stmt = $this->pdo->prepare("
            SELECT r.*, 
                   c.code, c.sms_content, c.received_at,
                   s.name as service_display_name,
                   CASE 
                       WHEN r.status = 'pending' AND r.expires_at > NOW() THEN TIMESTAMPDIFF(SECOND, NOW(), r.expires_at)
                       ELSE 0
                   END as time_remaining_seconds
            FROM otp_requests r
            LEFT JOIN otp_codes c ON r.request_id = c.request_id
            LEFT JOIN otp_services s ON r.service_id = s.service_id
            WHERE r.user_id = ? 
              AND r.created_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)
              AND r.status IN ('pending', 'completed', 'expired')
            ORDER BY r.created_at DESC
            LIMIT 10
        ");
        $stmt->execute([$user_id]);
        
        return $stmt->fetchAll();
    }
    
    /**
     * Xóa các request đã hết hạn của user
     * 
     * @param int $user_id
     * @return int Số lượng đã xóa
     */
    public function deleteExpiredRequests($user_id)
    {
        // Xóa otp_codes liên quan trước (nếu có)
        $stmt = $this->pdo->prepare("
            DELETE c FROM otp_codes c
            INNER JOIN otp_requests r ON c.request_id = r.request_id
            WHERE r.user_id = ? AND r.status = 'expired'
        ");
        $stmt->execute([$user_id]);
        
        // Xóa các request hết hạn
        $stmt = $this->pdo->prepare("
            DELETE FROM otp_requests 
            WHERE user_id = ? AND status = 'expired'
        ");
        $stmt->execute([$user_id]);
        
        return $stmt->rowCount();
    }
    
    /**
     * Lấy lịch sử thuê OTP của user
     * 
     * @param int $user_id
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getUserHistory($user_id, $limit = 20, $offset = 0)
    {
        $limit = intval($limit);
        $offset = intval($offset);
        
        // Tự động xử lý các request đã hết hạn (cập nhật status + hoàn tiền)
        $this->processExpiredRequestsForUser($user_id);
        
        $stmt = $this->pdo->prepare("
            SELECT r.*, 
                   c.code, c.sms_content, c.received_at,
                   CASE 
                       WHEN r.status = 'completed' AND r.completed_at > DATE_SUB(NOW(), INTERVAL 20 MINUTE) THEN 1
                       ELSE 0
                   END as can_rerent
            FROM otp_requests r
            LEFT JOIN otp_codes c ON r.request_id = c.request_id
            WHERE r.user_id = ?
            ORDER BY r.created_at DESC
            LIMIT {$limit} OFFSET {$offset}
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }
    
    /**
     * Đếm số request hôm nay của user
     * 
     * @param int $user_id
     * @return int
     */
    private function getUserTodayRequests($user_id)
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) as count FROM otp_requests 
            WHERE user_id = ? AND DATE(created_at) = CURDATE()
        ");
        $stmt->execute([$user_id]);
        $result = $stmt->fetch();
        return intval($result['count'] ?? 0);
    }
    
    /**
     * Lấy số dư user
     * 
     * @param int $user_id
     * @return float
     */
    private function getUserBalance($user_id)
    {
        $stmt = $this->pdo->prepare("SELECT user_wallet_balance FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();
        return floatval($user['user_wallet_balance'] ?? 0);
    }
    
    /**
     * Trừ tiền user
     * 
     * @param int $user_id
     * @param float $amount
     * @param string $description
     */
    private function deductUserBalance($user_id, $amount, $description)
    {
        $this->pdo->beginTransaction();
        
        try {
            // Trừ số dư
            $stmt = $this->pdo->prepare("
                UPDATE users SET user_wallet_balance = user_wallet_balance - ? 
                WHERE user_id = ? AND user_wallet_balance >= ?
            ");
            $stmt->execute([$amount, $user_id, $amount]);
            
            if ($stmt->rowCount() === 0) {
                throw new Exception("Không đủ số dư");
            }
            
            // Ghi log giao dịch
            $stmt = $this->pdo->prepare("
                INSERT INTO users_wallets_transactions 
                (user_id, amount, type, description, time)
                VALUES (?, ?, 'otp_rental', ?, NOW())
            ");
            $stmt->execute([$user_id, abs($amount), $description]);
            
            $this->pdo->commit();
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    
    /**
     * Hoàn tiền user
     * 
     * @param int $user_id
     * @param float $amount
     * @param string $description
     */
    private function refundUserBalance($user_id, $amount, $description)
    {
        $this->pdo->beginTransaction();
        
        try {
            // Cộng số dư
            $stmt = $this->pdo->prepare("
                UPDATE users SET user_wallet_balance = user_wallet_balance + ? 
                WHERE user_id = ?
            ");
            $stmt->execute([$amount, $user_id]);
            
            // Ghi log giao dịch - dùng type 'otp_refund' để hiển thị là cộng tiền
            $stmt = $this->pdo->prepare("
                INSERT INTO users_wallets_transactions 
                (user_id, amount, type, description, time)
                VALUES (?, ?, 'otp_refund', ?, NOW())
            ");
            $stmt->execute([$user_id, abs($amount), $description]);
            
            $this->pdo->commit();
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    
    /**
     * Lấy thống kê admin
     * 
     * @return array
     */
    public function getAdminStats()
    {
        $stats = [];
        
        // Tổng số request
        $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM otp_requests");
        $stats['total_requests'] = $stmt->fetch()['count'];
        
        // Request hôm nay
        $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM otp_requests WHERE DATE(created_at) = CURDATE()");
        $stats['today_requests'] = $stmt->fetch()['count'];
        
        // Theo trạng thái
        $stmt = $this->pdo->query("
            SELECT status, COUNT(*) as count FROM otp_requests GROUP BY status
        ");
        $stats['by_status'] = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        
        // Tổng doanh thu
        $stmt = $this->pdo->query("SELECT SUM(price) as total FROM otp_requests WHERE status = 'completed'");
        $stats['total_revenue'] = floatval($stmt->fetch()['total'] ?? 0);
        
        // Doanh thu hôm nay
        $stmt = $this->pdo->query("
            SELECT SUM(price) as total FROM otp_requests 
            WHERE status = 'completed' AND DATE(created_at) = CURDATE()
        ");
        $stats['today_revenue'] = floatval($stmt->fetch()['total'] ?? 0);
        
        return $stats;
    }
    
    /**
     * Cập nhật config
     * 
     * @param string $key
     * @param string $value
     */
    public function updateConfig($key, $value)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO otp_config (config_key, config_value) 
            VALUES (?, ?)
            ON DUPLICATE KEY UPDATE config_value = ?
        ");
        $stmt->execute([$key, $value, $value]);
        
        // Reload config
        $this->loadConfig();
    }
    
    /**
     * Lấy tất cả config
     * 
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }
    
    /**
     * Sync dịch vụ từ VIOTP API
     * 
     * @return array
     */
    public function syncServicesFromAPI($country = null)
    {
        $synced = 0;
        $countries = $country ? [$country] : ['vn', 'la'];
        
        foreach ($countries as $c) {
            // Endpoint đúng: /service/getv2?country=vn|la
            $response = $this->callAPI('/service/getv2', ['country' => $c]);
            
            if (!isset($response['status_code']) || $response['status_code'] != 200) {
                continue;
            }
            
            $services = $response['data'] ?? [];
            
            foreach ($services as $service) {
                $stmt = $this->pdo->prepare("
                    INSERT INTO otp_services (viotp_id, name, price, country, is_active)
                    VALUES (?, ?, ?, ?, 1)
                    ON DUPLICATE KEY UPDATE name = VALUES(name), price = VALUES(price)
                ");
                $stmt->execute([
                    $service['id'] ?? 0,
                    $service['name'] ?? '',
                    $service['price'] ?? 0,
                    $c
                ]);
                $synced++;
            }
        }
        
        return ['success' => true, 'message' => "Đã đồng bộ {$synced} dịch vụ"];
    }
    
    /**
     * Sync nhà mạng từ VIOTP API
     * 
     * @return array
     */
    public function syncNetworksFromAPI()
    {
        // Endpoint đúng: /networks/get
        $response = $this->callAPI('/networks/get');
        
        if (!isset($response['status_code']) || $response['status_code'] != 200) {
            return ['success' => false, 'message' => 'Không thể lấy danh sách nhà mạng từ VIOTP'];
        }
        
        $networks = $response['data'] ?? [];
        $synced = 0;
        
        // Nhà mạng VN: id 1-8, Lào: id 9-12
        $lao_networks = ['UNITEL', 'ETL', 'BEELINE', 'LAOTEL'];
        
        foreach ($networks as $network) {
            $name = $network['name'] ?? '';
            $country = in_array($name, $lao_networks) ? 'la' : 'vn';
            
            $stmt = $this->pdo->prepare("
                INSERT INTO otp_networks (viotp_id, name, country, is_active)
                VALUES (?, ?, ?, 1)
                ON DUPLICATE KEY UPDATE name = VALUES(name), country = VALUES(country)
            ");
            $stmt->execute([
                $network['id'] ?? 0,
                $name,
                $country
            ]);
            $synced++;
        }
        
        return ['success' => true, 'message' => "Đã đồng bộ {$synced} nhà mạng"];
    }
}
