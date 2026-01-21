<?php
/**
 * Sync giá dịch vụ OTP từ VIOTP API
 * Chạy file này để cập nhật giá mới nhất từ VIOTP
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

require('bootloader.php');
require_once('includes/class-otp.php');

echo "<h2>Sync giá OTP từ VIOTP API</h2>";

// Lấy config
$otp = new OTPRental();
$config = $otp->getConfig();
$token = $config['viotp_token'];
$base_url = $config['viotp_base_url'];

echo "Token: " . substr($token, 0, 10) . "...<br>";
echo "Base URL: $base_url<br><br>";

// Gọi API lấy danh sách dịch vụ
$url = $base_url . "/service/getv2?token=" . $token;
echo "Calling: $url<br><br>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if (!isset($data['data']) || !is_array($data['data'])) {
    echo "Lỗi: Không lấy được dữ liệu từ VIOTP<br>";
    echo "<pre>" . print_r($data, true) . "</pre>";
    exit;
}

echo "<h3>Danh sách dịch vụ từ VIOTP:</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Tên</th><th>Giá VIOTP</th><th>Giá x2</th></tr>";

// Các dịch vụ cần lấy
$allowed_services = ['Shopee', 'Gmail', 'Google', 'Facebook', 'Tiktok', 'TikTok', 'Zalo', 'Instagram', 'Momo', 'Telegram'];

$services_to_update = [];

foreach ($data['data'] as $service) {
    $name = $service['name'] ?? '';
    $id = $service['id'] ?? 0;
    $price = $service['price'] ?? 0;
    
    // Kiểm tra xem có phải dịch vụ cần lấy không
    $is_allowed = false;
    foreach ($allowed_services as $allowed) {
        if (stripos($name, $allowed) !== false) {
            $is_allowed = true;
            break;
        }
    }
    
    if ($is_allowed) {
        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$name</td>";
        echo "<td>" . number_format($price, 0, ',', '.') . "đ</td>";
        echo "<td><strong>" . number_format($price * 2, 0, ',', '.') . "đ</strong></td>";
        echo "</tr>";
        
        $services_to_update[] = [
            'viotp_id' => $id,
            'name' => $name,
            'price' => $price
        ];
    }
}

echo "</table><br>";

// Cập nhật vào database
echo "<h3>Cập nhật database:</h3>";

$pdo = new PDO(
    "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4",
    DB_USER,
    DB_PASSWORD
);

foreach ($services_to_update as $service) {
    $stmt = $pdo->prepare("UPDATE otp_services SET price = ? WHERE viotp_id = ?");
    $stmt->execute([$service['price'], $service['viotp_id']]);
    
    $affected = $stmt->rowCount();
    echo "- {$service['name']} (ID: {$service['viotp_id']}): giá = {$service['price']}đ";
    if ($affected > 0) {
        echo " ✓ Đã cập nhật";
    } else {
        echo " (không thay đổi hoặc không tồn tại)";
    }
    echo "<br>";
}

echo "<br><strong>Hoàn tất!</strong> Giá hiển thị cho user = Giá VIOTP × 2 (price_multiplier)";
