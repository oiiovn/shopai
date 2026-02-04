<?php

/**
 * Account Importer
 * 
 * Class để import tài khoản từ file Excel/CSV
 * 
 * @package Sngine
 * @author ShopAI Team
 */

class AccountImporter {
    
    private $db;
    
    public function __construct() {
        global $db;
        $this->db = $db;
    }
    
    /**
     * Import accounts from uploaded file
     * 
     * @param array $file $_FILES array
     * @param int|null $category_id Danh mục gán cho tài khoản (ưu tiên hơn CategoryID trong file)
     * @return array
     */
    public function importFromFile($file, $category_id = null) {
        try {
            // Kiểm tra file upload
            if (!$file || !isset($file['tmp_name'])) {
                return ['success' => false, 'message' => 'Không có file được upload'];
            }
            
            // Kiểm tra lỗi upload
            if ($file['error'] != UPLOAD_ERR_OK) {
                $errorMessages = [
                    UPLOAD_ERR_INI_SIZE => 'File vượt quá kích thước cho phép (upload_max_filesize)',
                    UPLOAD_ERR_FORM_SIZE => 'File vượt quá kích thước form cho phép',
                    UPLOAD_ERR_PARTIAL => 'File chỉ được upload một phần',
                    UPLOAD_ERR_NO_FILE => 'Không có file được upload',
                    UPLOAD_ERR_NO_TMP_DIR => 'Thiếu thư mục tạm',
                    UPLOAD_ERR_CANT_WRITE => 'Không thể ghi file',
                    UPLOAD_ERR_EXTENSION => 'Upload bị dừng bởi extension'
                ];
                $errorMsg = isset($errorMessages[$file['error']]) ? $errorMessages[$file['error']] : 'Lỗi upload không xác định (code: ' . $file['error'] . ')';
                return ['success' => false, 'message' => $errorMsg];
            }
            
            // Kiểm tra file có tồn tại không
            if (!file_exists($file['tmp_name'])) {
                return ['success' => false, 'message' => 'File tạm không tồn tại'];
            }
            
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            
            // Kiểm tra định dạng file
            if (!in_array($extension, ['xlsx', 'xls', 'csv'])) {
                return ['success' => false, 'message' => 'Chỉ chấp nhận file Excel (.xlsx, .xls) hoặc CSV (.csv). File của bạn: .' . $extension];
            }
            
            // Kiểm tra kích thước file (10MB)
            if ($file['size'] > 10 * 1024 * 1024) {
                return ['success' => false, 'message' => 'File quá lớn. Kích thước tối đa: 10MB'];
            }
            
            // Đọc file
            $data = [];
            if ($extension == 'csv') {
                $data = $this->readCSV($file['tmp_name']);
            } else {
                $data = $this->readExcel($file['tmp_name'], $file['name']);
            }
            
            // Kiểm tra kết quả đọc file
            if (isset($data['success']) && !$data['success']) {
                return $data; // Trả về lỗi từ readExcel
            }
            
            if (empty($data) || !is_array($data)) {
                return ['success' => false, 'message' => 'Không thể đọc dữ liệu từ file. Vui lòng kiểm tra định dạng file và đảm bảo file có dữ liệu hợp lệ.'];
            }
            
            // Import vào database
            return $this->importToDatabase($data, $category_id);
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
        }
    }
    
    /**
     * Read CSV file
     * 
     * @param string $file_path
     * @return array
     */
    private function readCSV($file_path) {
        try {
            $data = [];
            $handle = fopen($file_path, 'r');
            
            if ($handle === false) {
                return ['success' => false, 'message' => 'Không thể mở file CSV'];
            }
            
            // Đọc dòng đầu để xác định delimiter (tab hoặc comma)
            $firstLine = fgets($handle);
            rewind($handle);
            $delimiter = (substr_count($firstLine, "\t") >= substr_count($firstLine, ',')) ? "\t" : ",";
            
            // Đọc header
            $headers = fgetcsv($handle, 0, $delimiter);
            if (!$headers || empty($headers)) {
                fclose($handle);
                return ['success' => false, 'message' => 'File CSV không có header (dòng đầu tiên)'];
            }
            
            $headerMap = $this->mapHeaders($headers);
            
            // Kiểm tra có cột bắt buộc không
            if (empty($headerMap) || !isset($headerMap['UserName']) || !isset($headerMap['Pass'])) {
                fclose($handle);
                return ['success' => false, 'message' => 'File CSV thiếu cột bắt buộc: UserName hoặc Pass. Các cột tìm thấy: ' . implode(', ', $headers)];
            }
            
            // Đọc từng dòng
            $rowNum = 1;
            while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                $rowNum++;
                if (empty(array_filter($row, function($val) { return $val !== null && $val !== ''; }))) {
                    continue; // Bỏ qua dòng trống
                }
                
                $account = $this->parseRow($row, $headerMap, $rowNum);
                if ($account) {
                    $data[] = $account;
                }
            }
            
            fclose($handle);
            
            if (empty($data)) {
                return ['success' => false, 'message' => 'Không tìm thấy dữ liệu hợp lệ trong file CSV. Vui lòng kiểm tra lại file.'];
            }
            
            return $data;
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Lỗi khi đọc file CSV: ' . $e->getMessage()];
        }
    }
    
    /**
     * Read Excel file (simple parser)
     * 
     * @param string $file_path
     * @param string $file_name
     * @return array
     */
    private function readExcel($file_path, $file_name = '') {
        try {
            // Load SimpleXLSX library trước
            $simpleXlsxPath = __DIR__ . '/SimpleXLSX.php';
            if (!class_exists('Shuchkin\SimpleXLSX') && !class_exists('SimpleXLSX')) {
                if (file_exists($simpleXlsxPath)) {
                    require_once($simpleXlsxPath);
                } else {
                    return ['success' => false, 'message' => 'Thư viện SimpleXLSX chưa được cài đặt. File không tồn tại: ' . $simpleXlsxPath];
                }
            }
            
            // Kiểm tra lại sau khi require (có thể là Shuchkin\SimpleXLSX hoặc SimpleXLSX)
            $simpleXlsxClass = class_exists('Shuchkin\SimpleXLSX') ? 'Shuchkin\SimpleXLSX' : (class_exists('SimpleXLSX') ? 'SimpleXLSX' : null);
            if (!$simpleXlsxClass) {
                return ['success' => false, 'message' => 'Không thể load thư viện SimpleXLSX. Vui lòng kiểm tra file: ' . $simpleXlsxPath];
            }
            
            // Thử sử dụng PhpSpreadsheet nếu có (ưu tiên)
            if (class_exists('\PhpOffice\PhpSpreadsheet\IOFactory')) {
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();
                
                if (empty($rows)) {
                    return ['success' => false, 'message' => 'File Excel không có dữ liệu'];
                }
                
                $headers = array_shift($rows);
                $headerMap = $this->mapHeaders($headers);
                
                if (empty($headerMap) || !isset($headerMap['UserName']) || !isset($headerMap['Pass'])) {
                    return ['success' => false, 'message' => 'File Excel thiếu cột bắt buộc: UserName hoặc Pass. Các cột tìm thấy: ' . implode(', ', $headers)];
                }
                
                $data = [];
                foreach ($rows as $rowNum => $row) {
                    if (empty(array_filter($row, function($val) { return $val !== null && $val !== ''; }))) {
                        continue;
                    }
                    $account = $this->parseRow($row, $headerMap, $rowNum + 2);
                    if ($account) {
                        $data[] = $account;
                    }
                }
                
                if (empty($data)) {
                    return ['success' => false, 'message' => 'Không tìm thấy dữ liệu hợp lệ trong file Excel. Vui lòng kiểm tra lại file.'];
                }
                
                return $data;
            }
            
            // Sử dụng SimpleXLSX (đã kiểm tra class_exists ở trên)
            try {
                // Sử dụng fully qualified class name hoặc alias
                if ($simpleXlsxClass === 'Shuchkin\SimpleXLSX') {
                    $xlsx = \Shuchkin\SimpleXLSX::parse($file_path);
                } else {
                    $xlsx = SimpleXLSX::parse($file_path);
                }
            } catch (Exception $e) {
                return ['success' => false, 'message' => 'Lỗi khi parse file Excel: ' . $e->getMessage()];
            } catch (Error $e) {
                return ['success' => false, 'message' => 'Lỗi khi parse file Excel: ' . $e->getMessage()];
            }
            
            if (!$xlsx || $xlsx === false) {
                $error = '';
                // Thử lấy lỗi từ SimpleXLSX
                if ($simpleXlsxClass === 'Shuchkin\SimpleXLSX') {
                    if (method_exists('\Shuchkin\SimpleXLSX', 'parseError')) {
                        $error = \Shuchkin\SimpleXLSX::parseError();
                    }
                } else {
                    if (method_exists('SimpleXLSX', 'parseError')) {
                        $error = SimpleXLSX::parseError();
                    }
                }
                // Nếu không có parseError, thử error()
                if (empty($error) && is_object($xlsx) && method_exists($xlsx, 'error')) {
                    $error = $xlsx->error();
                }
                // Nếu vẫn không có, kiểm tra file
                if (empty($error)) {
                    if (!file_exists($file_path)) {
                        $error = 'File không tồn tại';
                    } elseif (!is_readable($file_path)) {
                        $error = 'Không thể đọc file';
                    } else {
                        $error = 'Định dạng file không hợp lệ hoặc file bị hỏng';
                    }
                }
                return ['success' => false, 'message' => 'Không thể đọc file Excel. ' . $error];
            }
            
            $rows = $xlsx->rows();
            if (empty($rows)) {
                return ['success' => false, 'message' => 'File Excel không có dữ liệu'];
            }
            
            $headers = array_shift($rows);
            if (empty($headers)) {
                return ['success' => false, 'message' => 'File Excel không có header (dòng đầu tiên)'];
            }
            
            $headerMap = $this->mapHeaders($headers);
            
            if (empty($headerMap) || !isset($headerMap['UserName']) || !isset($headerMap['Pass'])) {
                return ['success' => false, 'message' => 'File Excel thiếu cột bắt buộc: UserName hoặc Pass. Các cột tìm thấy: ' . implode(', ', array_filter($headers))];
            }
            
            $data = [];
            foreach ($rows as $rowNum => $row) {
                // Bỏ qua dòng trống
                if (empty($row) || empty(array_filter($row, function($val) { 
                    return $val !== null && $val !== '' && trim($val) !== ''; 
                }))) {
                    continue;
                }
                
                $account = $this->parseRow($row, $headerMap, $rowNum + 2);
                if ($account) {
                    $data[] = $account;
                }
            }
            
            if (empty($data)) {
                return ['success' => false, 'message' => 'Không tìm thấy dữ liệu hợp lệ trong file Excel. Vui lòng kiểm tra lại file và đảm bảo có cột UserName và Pass.'];
            }
            
            return $data;
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Lỗi khi đọc file Excel: ' . $e->getMessage() . ' (File: ' . basename($file_name) . ')'];
        } catch (Error $e) {
            return ['success' => false, 'message' => 'Lỗi khi đọc file Excel: ' . $e->getMessage() . ' (File: ' . basename($file_name) . ')'];
        }
    }
    
    /**
     * Map headers to column indices
     * 
     * @param array $headers
     * @return array
     */
    private function mapHeaders($headers) {
        $map = [];
        $headerMap = [
            'accmarketid' => 'AccMarketID',
            'username' => 'UserName',
            'pass' => 'Pass',
            'password' => 'Pass',
            'email' => 'EmailPass',
            'emailpass' => 'EmailPass',
            'email|pass' => 'EmailPass',
            'dochomthu' => 'DocHomThu',
            'đọc hòm thư' => 'DocHomThu',
            'acctype' => 'AccType',
            'categoryid' => 'CategoryID',
            'category_id' => 'CategoryID',
            'cookieeditor' => 'CookieEditor',
            'cookie editer' => 'CookieEditor',
            'cookie' => 'Cookie',
            'fullcookie' => 'Cookie',
            'full cookie' => 'Cookie',
            'info' => 'Info',
            'spc_f' => 'Info',
            'info(spc_f)' => 'Info',
            'price' => 'Price'
        ];
        
        foreach ($headers as $index => $header) {
            $headerLower = strtolower(trim($header));
            if (isset($headerMap[$headerLower])) {
                $map[$headerMap[$headerLower]] = $index;
            }
        }
        
        return $map;
    }
    
    /**
     * Parse a row into account data
     * 
     * @param array $row
     * @param array $headerMap
     * @param int $rowNum
     * @return array|null
     */
    private function parseRow($row, $headerMap, $rowNum) {
        $account = [];
        
        // UserName và Pass là bắt buộc
        if (!isset($headerMap['UserName']) || !isset($headerMap['Pass'])) {
            return null;
        }
        
        $username = isset($row[$headerMap['UserName']]) ? trim($row[$headerMap['UserName']]) : '';
        $pass = isset($row[$headerMap['Pass']]) ? trim($row[$headerMap['Pass']]) : '';
        
        if (empty($username) || empty($pass)) {
            return null; // Bỏ qua dòng thiếu thông tin
        }
        
        $account['UserName'] = $username;
        $account['Pass'] = $pass;
        $account['EmailPass'] = isset($headerMap['EmailPass']) && isset($row[$headerMap['EmailPass']]) ? trim($row[$headerMap['EmailPass']]) : null;
        $account['DocHomThu'] = isset($headerMap['DocHomThu']) && isset($row[$headerMap['DocHomThu']]) ? (strtolower(trim($row[$headerMap['DocHomThu']])) == '1' || strtolower(trim($row[$headerMap['DocHomThu']])) == 'yes' ? '1' : '0') : '0';
        $account['AccType'] = isset($headerMap['AccType']) && isset($row[$headerMap['AccType']]) ? trim($row[$headerMap['AccType']]) : null;
                    $account['CategoryID'] = isset($headerMap['CategoryID']) && isset($row[$headerMap['CategoryID']]) && intval($row[$headerMap['CategoryID']]) > 0 ? intval($row[$headerMap['CategoryID']]) : null;
        $account['CookieEditor'] = isset($headerMap['CookieEditor']) && isset($row[$headerMap['CookieEditor']]) ? trim($row[$headerMap['CookieEditor']]) : null;
        $account['Cookie'] = isset($headerMap['Cookie']) && isset($row[$headerMap['Cookie']]) ? trim($row[$headerMap['Cookie']]) : null;
        $account['Info'] = isset($headerMap['Info']) && isset($row[$headerMap['Info']]) ? trim($row[$headerMap['Info']]) : null;
        $account['Price'] = isset($headerMap['Price']) && isset($row[$headerMap['Price']]) ? floatval($row[$headerMap['Price']]) : 0.00;
        
        return $account;
    }
    
    /**
     * Import accounts to database
     * 
     * @param array $accounts
     * @param int|null $default_category_id Danh mục mặc định nếu file không có CategoryID
     * @return array
     */
    private function importToDatabase($accounts, $default_category_id = null) {
        try {
            if (empty($accounts) || !is_array($accounts)) {
                return ['success' => false, 'message' => 'Không có dữ liệu để import'];
            }
            
            // Kiểm tra bảng có tồn tại không
            $checkTable = $this->db->query("SHOW TABLES LIKE 'market_accounts'");
            if ($checkTable->num_rows == 0) {
                return ['success' => false, 'message' => 'Bảng market_accounts chưa được tạo. Vui lòng chạy file SQL: create_market_accounts_table.sql'];
            }
            
            // Đảm bảo EmailPass đủ lớn (TEXT) - tránh lỗi "Data too long"
            $colCheck = $this->db->query("SHOW COLUMNS FROM market_accounts WHERE Field = 'EmailPass'");
            if ($colCheck && $row = $colCheck->fetch_assoc()) {
                $type = strtolower($row['Type']);
                if (strpos($type, 'varchar') !== false) {
                    @$this->db->query("ALTER TABLE market_accounts MODIFY COLUMN EmailPass TEXT DEFAULT NULL COMMENT 'Email|Pass'");
                }
            }
            
            $successCount = 0;
            $errorCount = 0;
            $errors = [];
            
            foreach ($accounts as $index => $account) {
                try {
                    if (!isset($account['UserName']) || !isset($account['Pass'])) {
                        $errorCount++;
                        $errors[] = "Dòng " . ($index + 1) . ": Thiếu UserName hoặc Pass";
                        continue;
                    }
                    
                    // Dùng category_id từ form nếu có, không thì từ file
                    $catId = !empty($default_category_id) ? intval($default_category_id) : (isset($account['CategoryID']) ? intval($account['CategoryID']) : null);
                    if ($catId) $account['CategoryID'] = $catId;
                    
                    // Kiểm tra xem tài khoản đã tồn tại chưa (dựa trên UserName)
                    $check = $this->db->query(sprintf(
                        "SELECT AccMarketID FROM market_accounts WHERE UserName = %s",
                        secure($account['UserName'])
                    ));
                    
                    if (!$check) {
                        $errorCount++;
                        $errors[] = "Dòng " . ($index + 1) . ": Lỗi SQL khi kiểm tra tài khoản";
                        continue;
                    }
                    
                    if ($check->num_rows > 0) {
                    // Update nếu đã tồn tại
                    $update = $this->db->query(sprintf(
                        "UPDATE market_accounts SET 
                            Pass = %s,
                            EmailPass = %s,
                            DocHomThu = %s,
                            AccType = %s,
                            category_id = %s,
                            CookieEditor = %s,
                            Cookie = %s,
                            Info = %s,
                            Price = %s,
                            UpdatedAt = NOW()
                        WHERE UserName = %s",
                        secure($account['Pass']),
                        secure($account['EmailPass']),
                        secure($account['DocHomThu']),
                        secure($account['AccType']),
                        secure($account['CategoryID'], 'int'),
                        secure($account['CookieEditor']),
                        secure($account['Cookie']),
                        secure($account['Info']),
                        secure($account['Price'], 'float'),
                        secure($account['UserName'])
                    ));
                        
                        if ($update) {
                            $successCount++;
                        } else {
                            $errorCount++;
                            $errors[] = "Dòng " . ($index + 1) . ": Lỗi khi cập nhật tài khoản " . $account['UserName'];
                        }
                } else {
                    // Insert mới
                    $insert = $this->db->query(sprintf(
                        "INSERT INTO market_accounts 
                        (UserName, Pass, EmailPass, DocHomThu, AccType, category_id, CookieEditor, Cookie, Info, Price, Status, CreatedAt, UpdatedAt)
                        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 'available', NOW(), NOW())",
                        secure($account['UserName']),
                        secure($account['Pass']),
                        secure($account['EmailPass']),
                        secure($account['DocHomThu']),
                        secure($account['AccType']),
                        secure($account['CategoryID'], 'int'),
                        secure($account['CookieEditor']),
                        secure($account['Cookie']),
                        secure($account['Info']),
                        secure($account['Price'], 'float')
                    ));
                        
                        if ($insert) {
                            $successCount++;
                        } else {
                            $errorCount++;
                            $errors[] = "Dòng " . ($index + 1) . ": Lỗi khi thêm tài khoản " . $account['UserName'] . " - " . $this->db->error;
                        }
                    }
                } catch (Exception $e) {
                    $errorCount++;
                    $errors[] = "Dòng " . ($index + 1) . ": " . $e->getMessage();
                }
            }
            
            $message = "Import thành công: {$successCount} tài khoản";
            if ($errorCount > 0) {
                $message .= ". Lỗi: {$errorCount}";
            }
            
            return [
                'success' => $successCount > 0,
                'message' => $message,
                'success_count' => $successCount,
                'error_count' => $errorCount,
                'errors' => $errors
            ];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Lỗi khi import vào database: ' . $e->getMessage()];
        }
    }
}
