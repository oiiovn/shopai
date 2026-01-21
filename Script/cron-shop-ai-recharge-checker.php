<?php
/**
 * Cron Job: Shop-AI Recharge Checker
 * Kiểm tra giao dịch Pay2S cho chức năng nạp tiền Shop-AI mỗi phút
 */

// Thiết lập timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Load database config
require_once __DIR__ . '/includes/config.php';

// Log file
$logFile = __DIR__ . '/logs/shop-ai-recharge-checker.log';

// Tạo thư mục logs nếu chưa có
if (!is_dir(__DIR__ . '/logs')) {
    mkdir(__DIR__ . '/logs', 0755, true);
}

// Hàm ghi log
function writeLog($message) {
    global $logFile;
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND | LOCK_EX);
}

// Kết nối database
function getDBConnection() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("SET NAMES utf8mb4");
        return $pdo;
    } catch (PDOException $e) {
        writeLog("❌ Lỗi kết nối database: " . $e->getMessage());
        return null;
    }
}

// Hàm lấy giao dịch từ Pay2S API
function fetchPay2STransactions() {
    try {
        // Load Pay2S configuration
        $config = include __DIR__ . '/pay2s-config.php';
        
        $url = $config['api_url'] . '/transactions';
        
        // Tham số API theo tài liệu chính thức
        $params = [
            'bankAccounts' => $config['account_number'], // 46241987
            'begin' => date('d/m/Y', strtotime('-1 day')), // Hôm qua
            'end' => date('d/m/Y') // Hôm nay
        ];
        
        // Headers theo tài liệu - sử dụng base64 của secret key
        // Thử dùng pay2s_token từ config trước, nếu không có thì encode lại từ secret_key
        $pay2sToken = $config['pay2s_token'] ?? '';
        if (empty($pay2sToken) && isset($config['secret_key'])) {
            $pay2sToken = base64_encode($config['secret_key']);
        }
        if (empty($pay2sToken) && isset($config['webhook_secret'])) {
            $pay2sToken = base64_encode($config['webhook_secret']);
        }
        
        $headers = [
            'Content-Type: application/json',
            'pay2s-token: ' . $pay2sToken,
            'Accept: application/json'
        ];
        
        writeLog("🔄 Gọi Pay2S API: $url");
        writeLog("📋 Request Params: " . json_encode($params));
        writeLog("🔑 Token (first 50 chars): " . substr($pay2sToken, 0, 50) . "...");
        
        // CURL request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Shop-AI-Recharge/1.0');
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        writeLog("📡 HTTP Code: " . $httpCode);
        writeLog("📥 Response (first 500 chars): " . substr($response, 0, 500));
        
        if ($error) {
            writeLog("❌ CURL Error: " . $error);
            return [];
        }
        
        if ($httpCode !== 200) {
            writeLog("❌ HTTP Error: " . $httpCode . " - Full Response: " . $response);
            return [];
        }
        
        $data = json_decode($response, true);
        
        if (!$data) {
            writeLog("❌ JSON Decode Error - Response: " . $response);
            return [];
        }
        
        if (!isset($data['status']) || !$data['status']) {
            $errorMsg = isset($data['messages']) ? (is_array($data['messages']) ? json_encode($data['messages']) : $data['messages']) : 'Unknown error';
            writeLog("❌ Pay2S API Error: " . $errorMsg);
            writeLog("📋 Full API Response: " . json_encode($data));
            
            // Nếu lỗi là "No active plan or plan expired", báo rõ ràng
            if (strpos(strtolower($errorMsg), 'no active plan') !== false || strpos(strtolower($errorMsg), 'plan expired') !== false) {
                writeLog("⚠️ CẢNH BÁO: Tài khoản Pay2S chưa có gói dịch vụ đang hoạt động hoặc đã hết hạn!");
                writeLog("⚠️ Vui lòng đăng nhập vào https://my.pay2s.vn để kích hoạt gói dịch vụ!");
            }
            
            return [];
        }
        
        $transactions = $data['transactions'] ?? [];
        writeLog("✅ Nhận được " . count($transactions) . " giao dịch từ Pay2S API");
        
        return $transactions;
        
    } catch (Exception $e) {
        writeLog("❌ Lỗi khi lấy giao dịch từ Pay2S: " . $e->getMessage());
        return [];
    }
}

// Hàm tìm QR Code mapping bằng QR code
function findQRCodeMappingByQRCode($qrCode, $amount, $pdo) {
    try {
        // Tìm QR code mapping dựa trên QR code và số tiền
        $stmt = $pdo->prepare("
            SELECT qr_id, user_id, amount, qr_code, transfer_content 
            FROM qr_code_mapping 
            WHERE qr_code = ? 
            AND amount = ? 
            AND status = 'active' 
            AND expires_at > NOW() 
            ORDER BY created_at DESC 
            LIMIT 1
        ");
        $stmt->execute([$qrCode, $amount]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            writeLog("✅ Tìm thấy QR mapping: QR={$qrCode}, User={$result['user_id']}, Amount={$amount}");
            return $result;
        } else {
            writeLog("❌ Không tìm thấy QR mapping cho: QR={$qrCode}, Amount={$amount}");
            return null;
        }
        
    } catch (PDOException $e) {
        writeLog("❌ Lỗi tìm QR mapping: " . $e->getMessage());
        return null;
    }
}

// Hàm tìm QR Code mapping bằng partial QR code
function findQRCodeMappingByPartialQR($partialQR, $amount, $pdo) {
    try {
        // Tìm QR code mapping dựa trên partial QR code và số tiền
        $stmt = $pdo->prepare("
            SELECT qr_id, user_id, amount, qr_code, transfer_content 
            FROM qr_code_mapping 
            WHERE qr_code LIKE ? 
            AND amount = ? 
            AND status = 'active' 
            AND expires_at > NOW() 
            ORDER BY created_at DESC 
            LIMIT 1
        ");
        $likePattern = $partialQR . '%';
        $stmt->execute([$likePattern, $amount]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            writeLog("✅ Tìm thấy partial QR mapping: Partial={$partialQR}, Full={$result['qr_code']}, User={$result['user_id']}, Amount={$amount}");
            return $result;
        } else {
            writeLog("❌ Không tìm thấy partial QR mapping cho: Partial={$partialQR}, Amount={$amount}");
            return null;
        }
        
    } catch (PDOException $e) {
        writeLog("❌ Lỗi tìm partial QR mapping: " . $e->getMessage());
        return null;
    }
}

// Hàm tìm QR Code mapping bằng transfer content (backup method)
function findQRCodeMappingByTransferContent($transferDescription, $amount, $pdo) {
    try {
        // Tìm QR code mapping dựa trên nội dung chuyển khoản và số tiền
        $stmt = $pdo->prepare("
            SELECT qr_id, user_id, amount, qr_code, transfer_content 
            FROM qr_code_mapping 
            WHERE transfer_content = ? 
            AND amount = ? 
            AND status = 'active' 
            AND expires_at > NOW() 
            ORDER BY created_at DESC 
            LIMIT 1
        ");
        $stmt->execute([$transferDescription, $amount]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            writeLog("✅ Tìm thấy QR mapping: Content={$transferDescription}, User={$result['user_id']}, Amount={$amount}");
            return $result;
        } else {
            // Thử tìm bằng cách so sánh partial content (fallback)
            $stmt = $pdo->prepare("
                SELECT qr_id, user_id, amount, qr_code, transfer_content 
                FROM qr_code_mapping 
                WHERE ? LIKE CONCAT('%', qr_code, '%')
                AND amount = ? 
                AND status = 'active' 
                AND expires_at > NOW() 
                ORDER BY created_at DESC 
                LIMIT 1
            ");
            $stmt->execute([$transferDescription, $amount]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                writeLog("✅ Tìm thấy QR mapping (partial): Content={$transferDescription}, User={$result['user_id']}, Amount={$amount}");
                return $result;
            } else {
                writeLog("❌ Không tìm thấy QR mapping cho: Content={$transferDescription}, Amount={$amount}");
                return null;
            }
        }
        
    } catch (PDOException $e) {
        writeLog("❌ Lỗi tìm QR mapping: " . $e->getMessage());
        return null;
    }
}

// Hàm cập nhật số dư người dùng
function updateUserBalance($userId, $amount, $pdo) {
    try {
        // Lấy số dư hiện tại
        $stmt = $pdo->prepare("SELECT user_wallet_balance FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            writeLog("❌ Không tìm thấy user ID: $userId");
            return false;
        }
        
        $currentBalance = floatval($user['user_wallet_balance']);
        $newBalance = $currentBalance + $amount;
        
        // Cập nhật số dư mới
        $stmt = $pdo->prepare("UPDATE users SET user_wallet_balance = ? WHERE user_id = ?");
        $result = $stmt->execute([$newBalance, $userId]);
        
        if ($result) {
            writeLog("✅ Cập nhật số dư user $userId: {$currentBalance} -> {$newBalance} (+{$amount})");
            return ['old_balance' => $currentBalance, 'new_balance' => $newBalance];
        } else {
            writeLog("❌ Lỗi cập nhật số dư user $userId");
            return false;
        }
        
    } catch (PDOException $e) {
        writeLog("❌ Lỗi cập nhật số dư: " . $e->getMessage());
        return false;
    }
}

// Hàm tạo giao dịch wallet
function createWalletTransaction($userId, $amount, $description, $pdo) {
    try {
        // Tạo giao dịch wallet (giống như hệ thống có sẵn)
        $stmt = $pdo->prepare("
            INSERT INTO users_wallets_transactions 
            (user_id, type, amount, description, time) 
            VALUES (?, 'recharge', ?, ?, NOW())
        ");
        $result = $stmt->execute([$userId, $amount, $description]);
        
        if ($result) {
            writeLog("✅ Tạo wallet transaction cho user $userId: +{$amount}");
            return true;
        } else {
            writeLog("❌ Lỗi tạo wallet transaction cho user $userId");
            return false;
        }
        
    } catch (PDOException $e) {
        writeLog("❌ Lỗi tạo wallet transaction: " . $e->getMessage());
        return false;
    }
}

// Hàm đánh dấu QR code đã sử dụng
function markQRCodeAsUsed($qrId, $pdo) {
    try {
        $stmt = $pdo->prepare("UPDATE qr_code_mapping SET status = 'used', used_at = NOW() WHERE qr_id = ?");
        $result = $stmt->execute([$qrId]);
        
        if ($result) {
            writeLog("✅ Đánh dấu QR code ID $qrId đã sử dụng");
            return true;
        } else {
            writeLog("❌ Lỗi đánh dấu QR code ID $qrId");
            return false;
        }
        
    } catch (PDOException $e) {
        writeLog("❌ Lỗi đánh dấu QR code: " . $e->getMessage());
        return false;
    }
}

// Hàm kiểm tra giao dịch đã xử lý chưa - chỉ return true nếu status = completed
function isTransactionProcessed($transactionId, $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT status FROM bank_transactions WHERE transaction_id = ?");
        $stmt->execute([$transactionId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return $result['status'] === 'completed';  // Chỉ true nếu đã completed
        }
        return false;  // Không tìm thấy transaction
    } catch (PDOException $e) {
        writeLog("❌ Lỗi kiểm tra transaction: " . $e->getMessage());
        return false;
    }
}

// Hàm lưu bank transaction - chỉ cập nhật user_id và status
function saveBankTransaction($transaction, $userId, $pdo) {
    try {
        // Cập nhật user_id và status thay vì insert mới
        $stmt = $pdo->prepare("
            UPDATE bank_transactions 
            SET user_id = ?, status = 'completed' 
            WHERE transaction_id = ?
        ");
        
        $result = $stmt->execute([
            $userId,
            $transaction['transaction_id']
        ]);
        
        if ($result) {
            writeLog("✅ Lưu bank transaction: {$transaction['transaction_id']}");
            return true;
        } else {
            writeLog("❌ Lỗi lưu bank transaction");
            return false;
        }
        
    } catch (PDOException $e) {
        writeLog("❌ Lỗi lưu bank transaction: " . $e->getMessage());
        return false;
    }
}

// Main execution
writeLog("=== Bắt đầu kiểm tra giao dịch Shop-AI Recharge ===");

try {
    // Kết nối database
    $pdo = getDBConnection();
    if (!$pdo) {
        throw new Exception("Không thể kết nối database");
    }
    
    // Lấy giao dịch từ Pay2S API
    $transactions = fetchPay2STransactions();
    
    if (empty($transactions)) {
        writeLog("ℹ️ Không có giao dịch mới từ Pay2S API");
        exit(0);
    }
    
    writeLog("📥 Nhận được " . count($transactions) . " giao dịch từ Pay2S API");
    
    // Lưu tất cả giao dịch mới vào database trước
    $newTransactionsSaved = 0;
    foreach ($transactions as $transaction) {
        $transactionId = $transaction['transaction_id'] ?? '';
        
        if (empty($transactionId)) continue;
        
        // Kiểm tra đã tồn tại chưa
        $stmt = $pdo->prepare("SELECT id FROM bank_transactions WHERE transaction_id = ?");
        $stmt->execute([$transactionId]);
        
        if (!$stmt->fetch()) {
            // Lưu giao dịch mới - Sửa transaction_type theo Pay2S API
            $transactionType = 'deposit'; // Default
            if (isset($transaction['type'])) {
                switch (strtoupper($transaction['type'])) {
                    case 'IN':
                        $transactionType = 'deposit';
                        break;
                    case 'OUT':
                        $transactionType = 'withdraw';
                        break;
                    default:
                        $transactionType = 'transfer';
                        break;
                }
            }
            
            $stmt = $pdo->prepare("
                INSERT INTO bank_transactions 
                (transaction_id, user_id, amount, description, bank_code, account_number, transaction_type, status, transaction_date, created_at) 
                VALUES (?, 0, ?, ?, '970416', '46241987', ?, 'pending', ?, NOW())
            ");
            $stmt->execute([
                $transactionId,
                $transaction['amount'] ?? 0,
                $transaction['description'] ?? '',
                $transactionType,
                $transaction['transaction_date'] ?? date('Y-m-d H:i:s')
            ]);
            $newTransactionsSaved++;
            writeLog("💾 Lưu giao dịch mới: $transactionId");
        }
    }
    
    writeLog("📊 Đã lưu $newTransactionsSaved giao dịch mới vào database");
    
    // Bây giờ xử lý tất cả giao dịch pending trong database (bao gồm cả mới và cũ)
    $stmt = $pdo->prepare("SELECT * FROM bank_transactions WHERE status = 'pending' ORDER BY transaction_date ASC");
    $stmt->execute();
    $pendingTransactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    writeLog("🔄 Tìm thấy " . count($pendingTransactions) . " giao dịch pending để xử lý");
    
    $processed = 0;
    $skipped = 0;
    $failed = 0;
    
    foreach ($pendingTransactions as $transaction) {
        try {
            $transactionId = $transaction['transaction_id'] ?? '';
            $amount = floatval($transaction['amount'] ?? 0);
            $description = $transaction['description'] ?? '';
            
            writeLog("🔍 Xử lý giao dịch: ID={$transactionId}, Amount={$amount}, Desc={$description}");
            
            // Kiểm tra giao dịch đã xử lý chưa
            if (isTransactionProcessed($transactionId, $pdo)) {
                writeLog("⏭️ Giao dịch $transactionId đã được xử lý, bỏ qua");
                $skipped++;
                continue;
            }
            
            // Extract QR code từ description Pay2S - nâng cấp để handle các format phức tạp
            $extractedQR = '';
            
            // Method 1: Tìm QR code trong chuỗi phức tạp (MBVCB, VCB, etc.)
            if (preg_match('/RZ[A-Z0-9]+/', trim($description), $matches)) {
                $extractedQR = $matches[0];
                writeLog("🔍 Method 1 - Found QR in complex string: $extractedQR");
            }
            
            // Method 2: Nếu không tìm thấy, thử extract từ các pattern khác
            if (empty($extractedQR)) {
                // Pattern cho các ngân hàng khác nhau
                $patterns = [
                    '/RZ[A-Z0-9]+/',  // RZ + alphanumeric
                    '/RZ\d+[A-Z0-9]+/',  // RZ + numbers + alphanumeric
                    '/RZ[A-Z]\d+[A-Z0-9]+/',  // RZ + letter + numbers + alphanumeric
                ];
                
                foreach ($patterns as $pattern) {
                    if (preg_match($pattern, trim($description), $matches)) {
                        $extractedQR = $matches[0];
                        writeLog("🔍 Method 2 - Found QR with pattern $pattern: $extractedQR");
                        break;
                    }
                }
            }
            
            // Method 3: Nếu vẫn không tìm thấy, thử tìm bằng cách split và filter
            if (empty($extractedQR)) {
                // Split by common delimiters và tìm RZ codes
                $parts = preg_split('/[\.\s\-_]+/', trim($description));
                foreach ($parts as $part) {
                    if (preg_match('/^RZ[A-Z0-9]+$/', trim($part))) {
                        $extractedQR = trim($part);
                        writeLog("🔍 Method 3 - Found QR in split parts: $extractedQR");
                        break;
                    }
                }
            }
            
            writeLog("🔍 So sánh Pay2S description: $description");
            writeLog("🔍 Extracted QR code: $extractedQR");
            
            if (empty($extractedQR)) {
                writeLog("❌ Không extract được QR code từ: $description");
                $failed++;
                continue;
            }
            
            // Tìm QR code mapping bằng extracted QR code - nâng cấp với multiple methods
            $qrMapping = null;
            
            // Method 1: Tìm exact match
            $qrMapping = findQRCodeMappingByQRCode($extractedQR, $amount, $pdo);
            if ($qrMapping) {
                writeLog("✅ Method 1 - Exact match found for: $extractedQR");
            }
            
            // Method 2: Nếu không tìm thấy exact match, thử tìm với amount khác nhau (±10%)
            if (!$qrMapping) {
                $amountVariations = [
                    $amount * 0.9,  // -10%
                    $amount * 1.1,  // +10%
                    $amount * 0.95, // -5%
                    $amount * 1.05, // +5%
                ];
                
                foreach ($amountVariations as $variationAmount) {
                    $qrMapping = findQRCodeMappingByQRCode($extractedQR, $variationAmount, $pdo);
                    if ($qrMapping) {
                        writeLog("✅ Method 2 - Amount variation match found: $extractedQR (original: $amount, matched: $variationAmount)");
                        break;
                    }
                }
            }
            
            // Method 3: Tìm partial match (QR code có thể bị cắt ngắn)
            if (!$qrMapping) {
                // Thử tìm với các độ dài khác nhau của QR code
                $qrLengths = [strlen($extractedQR), strlen($extractedQR) - 1, strlen($extractedQR) + 1];
                foreach ($qrLengths as $length) {
                    if ($length > 10) { // Minimum QR code length
                        $partialQR = substr($extractedQR, 0, $length);
                        $qrMapping = findQRCodeMappingByPartialQR($partialQR, $amount, $pdo);
                        if ($qrMapping) {
                            writeLog("✅ Method 3 - Partial match found: $extractedQR -> $partialQR");
                            break;
                        }
                    }
                }
            }
            
            if (!$qrMapping) {
                writeLog("❌ Không tìm thấy QR mapping cho: $extractedQR (tried exact, amount variations, partial match)");
                $failed++;
                continue;
            }
            
            $userId = $qrMapping['user_id'];
            
            // Bắt đầu transaction
            $pdo->beginTransaction();
            
            // Cập nhật số dư người dùng
            $balanceUpdate = updateUserBalance($userId, $amount, $pdo);
            if (!$balanceUpdate) {
                $pdo->rollback();
                $failed++;
                continue;
            }
            
            // Tạo wallet transaction
            $walletDesc = $extractedQR;
            if (!createWalletTransaction($userId, $amount, $walletDesc, $pdo)) {
                $pdo->rollback();
                $failed++;
                continue;
            }
            
            // Lưu bank transaction
            if (!saveBankTransaction($transaction, $userId, $pdo)) {
                $pdo->rollback();
                $failed++;
                continue;
            }
            
            // Đánh dấu QR code đã sử dụng
            if (!markQRCodeAsUsed($qrMapping['qr_id'], $pdo)) {
                $pdo->rollback();
                $failed++;
                continue;
            }
            
            // Commit transaction
            $pdo->commit();
            
            $processed++;
            writeLog("✅ Hoàn thành xử lý giao dịch $transactionId cho user $userId: +{$amount} VNĐ");
            
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollback();
            }
            writeLog("❌ Lỗi xử lý giao dịch {$transactionId}: " . $e->getMessage());
            $failed++;
        }
    }
    
    writeLog("📊 Kết quả: Xử lý={$processed}, Bỏ qua={$skipped}, Lỗi={$failed}");
    writeLog("=== Hoàn thành kiểm tra giao dịch Shop-AI Recharge ===");
    
    echo "Processed: $processed, Skipped: $skipped, Failed: $failed\n";
    
} catch (Exception $e) {
    writeLog("❌ Lỗi chính: " . $e->getMessage());
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}

exit(0);
?>
