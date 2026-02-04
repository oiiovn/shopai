<?php
/**
 * Script lấy danh sách dịch vụ từ VIOTP API
 * Để xác định đúng viotp_id cho Shopee và Google
 */

require('bootloader.php');
require_once('includes/class-otp.php');

$otp = new OTPRental();

// Lấy danh sách dịch vụ từ API VIOTP
$country = $_GET['country'] ?? 'vn';
$response = $otp->getServicesFromAPI($country);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Lấy danh sách dịch vụ từ VIOTP API</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1400px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 3px solid #2196F3; padding-bottom: 10px; }
        h2 { color: #555; margin-top: 30px; }
        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #2196F3; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .highlight { background-color: #fff3cd !important; font-weight: bold; }
        .success { color: green; padding: 15px; background: #e8f5e9; border: 2px solid green; margin: 15px 0; border-radius: 4px; }
        .error { color: red; padding: 15px; background: #ffebee; border: 2px solid red; margin: 15px 0; border-radius: 4px; }
        .info-box { background: #e3f2fd; padding: 20px; border-left: 4px solid #2196F3; margin: 20px 0; border-radius: 4px; }
        .code { background: #f5f5f5; padding: 15px; border-radius: 4px; font-family: monospace; margin: 15px 0; overflow-x: auto; }
        .tabs { display: flex; gap: 10px; margin: 20px 0; }
        .tab { padding: 10px 20px; background: #e0e0e0; border: none; border-radius: 4px; cursor: pointer; }
        .tab.active { background: #2196F3; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📡 Lấy danh sách dịch vụ từ VIOTP API</h1>
        
        <div class="tabs">
            <a href="?country=vn" class="tab <?php echo $country === 'vn' ? 'active' : ''; ?>">🇻🇳 Việt Nam</a>
            <a href="?country=la" class="tab <?php echo $country === 'la' ? 'active' : ''; ?>">🇱🇦 Lào</a>
        </div>
        
        <?php if (!isset($response['status_code']) || $response['status_code'] != 200): ?>
            <div class="error">
                <strong>✗ Lỗi khi gọi API VIOTP</strong><br>
                Status Code: <?php echo $response['status_code'] ?? 'N/A'; ?><br>
                Message: <?php echo htmlspecialchars($response['message'] ?? 'Unknown error'); ?><br>
                <?php if (isset($response['raw'])): ?>
                    <details>
                        <summary>Raw Response</summary>
                        <pre><?php echo htmlspecialchars($response['raw']); ?></pre>
                    </details>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?php
            $services = $response['data'] ?? [];
            
            // Tìm Shopee và Google
            $shopee = null;
            $google = null;
            $gmail = null;
            
            foreach ($services as $service) {
                $name = strtolower($service['name'] ?? '');
                if (strpos($name, 'shopee') !== false) {
                    $shopee = $service;
                }
                if (strpos($name, 'google') !== false && strpos($name, 'gmail') === false) {
                    $google = $service;
                }
                if (strpos($name, 'gmail') !== false) {
                    $gmail = $service;
                }
            }
            ?>
            
            <div class="success">
                <strong>✓ Thành công!</strong> Đã lấy được <?php echo count($services); ?> dịch vụ từ VIOTP API (country: <?php echo $country; ?>)
            </div>
            
            <?php if ($shopee || $google || $gmail): ?>
                <div class="info-box">
                    <h3>🎯 Dịch vụ quan trọng được tìm thấy:</h3>
                    <ul>
                        <?php if ($shopee): ?>
                            <li><strong>Shopee:</strong> viotp_id = <code><?php echo $shopee['id']; ?></code>, name = "<?php echo htmlspecialchars($shopee['name']); ?>"</li>
                        <?php else: ?>
                            <li><strong>Shopee:</strong> Không tìm thấy</li>
                        <?php endif; ?>
                        
                        <?php if ($google): ?>
                            <li><strong>Google:</strong> viotp_id = <code><?php echo $google['id']; ?></code>, name = "<?php echo htmlspecialchars($google['name']); ?>"</li>
                        <?php else: ?>
                            <li><strong>Google:</strong> Không tìm thấy</li>
                        <?php endif; ?>
                        
                        <?php if ($gmail): ?>
                            <li><strong>Gmail:</strong> viotp_id = <code><?php echo $gmail['id']; ?></code>, name = "<?php echo htmlspecialchars($gmail['name']); ?>"</li>
                        <?php else: ?>
                            <li><strong>Gmail:</strong> Không tìm thấy</li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <?php if ($shopee || $google || $gmail): ?>
                    <div class="code">
                        <strong>SQL để cập nhật database:</strong><br>
                        <?php if ($shopee): ?>
                            -- Shopee<br>
                            UPDATE otp_services SET viotp_id = <?php echo $shopee['id']; ?> WHERE name LIKE '%shopee%' AND country = '<?php echo $country; ?>';<br><br>
                        <?php endif; ?>
                        <?php if ($google): ?>
                            -- Google<br>
                            UPDATE otp_services SET viotp_id = <?php echo $google['id']; ?> WHERE name LIKE '%google%' AND country = '<?php echo $country; ?>';<br><br>
                        <?php endif; ?>
                        <?php if ($gmail): ?>
                            -- Gmail<br>
                            UPDATE otp_services SET viotp_id = <?php echo $gmail['id']; ?> WHERE name LIKE '%gmail%' AND country = '<?php echo $country; ?>';<br><br>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            
            <h2>📋 Danh sách tất cả dịch vụ (<?php echo count($services); ?> dịch vụ)</h2>
            <table>
                <tr>
                    <th>viotp_id</th>
                    <th>Tên dịch vụ</th>
                    <th>Giá</th>
                    <th>Ghi chú</th>
                </tr>
                <?php foreach ($services as $service): 
                    $is_important = false;
                    $name_lower = strtolower($service['name'] ?? '');
                    if (strpos($name_lower, 'shopee') !== false || 
                        strpos($name_lower, 'google') !== false || 
                        strpos($name_lower, 'gmail') !== false) {
                        $is_important = true;
                    }
                ?>
                <tr class="<?php echo $is_important ? 'highlight' : ''; ?>">
                    <td><strong><?php echo $service['id'] ?? 'N/A'; ?></strong></td>
                    <td><?php echo htmlspecialchars($service['name'] ?? 'N/A'); ?></td>
                    <td><?php echo isset($service['price']) ? number_format($service['price'], 0, ',', '.') . 'đ' : 'N/A'; ?></td>
                    <td>
                        <?php if (strpos(strtolower($service['name'] ?? ''), 'shopee') !== false): ?>
                            🛒 Shopee
                        <?php elseif (strpos(strtolower($service['name'] ?? ''), 'google') !== false && strpos(strtolower($service['name'] ?? ''), 'gmail') === false): ?>
                            🔍 Google
                        <?php elseif (strpos(strtolower($service['name'] ?? ''), 'gmail') !== false): ?>
                            📧 Gmail
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            
            <h2>🔍 Tìm kiếm dịch vụ</h2>
            <div class="info-box">
                <p>Nhập tên dịch vụ để tìm:</p>
                <input type="text" id="searchInput" placeholder="Ví dụ: shopee, google, gmail..." style="width: 300px; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <button onclick="searchServices()" style="padding: 8px 16px; background: #2196F3; color: white; border: none; border-radius: 4px; cursor: pointer;">Tìm kiếm</button>
            </div>
            
            <div id="searchResults"></div>
            
            <h2>📄 Raw JSON Response</h2>
            <details>
                <summary>Xem raw response từ API</summary>
                <pre class="code"><?php echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>
            </details>
        <?php endif; ?>
    </div>
    
    <script>
        const services = <?php echo json_encode($services ?? []); ?>;
        
        function searchServices() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const results = services.filter(s => 
                (s.name || '').toLowerCase().includes(searchTerm)
            );
            
            const resultsDiv = document.getElementById('searchResults');
            if (results.length === 0) {
                resultsDiv.innerHTML = '<div class="error">Không tìm thấy dịch vụ nào</div>';
                return;
            }
            
            let html = '<table><tr><th>viotp_id</th><th>Tên dịch vụ</th><th>Giá</th></tr>';
            results.forEach(s => {
                html += `<tr>
                    <td><strong>${s.id || 'N/A'}</strong></td>
                    <td>${s.name || 'N/A'}</td>
                    <td>${s.price ? new Intl.NumberFormat('vi-VN').format(s.price) + 'đ' : 'N/A'}</td>
                </tr>`;
            });
            html += '</table>';
            resultsDiv.innerHTML = html;
        }
    </script>
</body>
</html>
