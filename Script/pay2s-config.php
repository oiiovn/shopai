<?php
/**
 * Pay2S API Configuration
 * Cấu hình API Pay2S để lấy giao dịch thật
 */

return [
    // Pay2S API Settings
    'api_url' => 'https://my.pay2s.vn/userapi',
    'api_key' => 'PAY2S23DW78K2CVCZFW9',  // API key thật
    'api_secret' => '88d3b56b2702dbf15a6648cc2eda93001f5c80ab9cdcc232393b4f368e9ec9c6',  // API secret thật
    'pay2s_token' => 'MWVjZTFmNTY4NTM5ZWViN2I5NzE1NzhjMzJhMzE3MzY5ZGVmYmYwZTY0YjgzMzYxMjRiZGM0NzM5OWEzNDFl',  // Base64 của Secret Key (như Google Apps Script)
    
    // Webhook Settings
    'webhook_url' => 'https://yourdomain.com/TCSN/Script/pay2s-api-handler.php?webhook=1',
    'webhook_secret' => '1ece1f568539eeb7b971578c32a317369defbf0e64b8336124bdc47399a3419e',  // Webhook secret thật
    
    // Bank Settings
    'account_number' => '46241987',
    'bank_code' => '970416',  // ACB Bank code
    'bank_name' => 'ACB',
    
    // Transaction Settings
    'auto_process' => true,  // Tự động xử lý giao dịch
    'process_interval' => 60,  // Kiểm tra mỗi 60 giây
    
    // Logging
    'log_level' => 'info',  // debug, info, warning, error
    'log_file' => __DIR__ . '/logs/pay2s-api.log',
    
    // Security
    'allowed_ips' => [
        '127.0.0.1',
        '::1',
        // Thêm IP của Pay2S server
    ],
    
    // Rate Limiting
    'rate_limit' => [
        'max_requests' => 100,
        'time_window' => 3600,  // 1 hour
    ]
];
?>