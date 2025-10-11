USE sho73359_shopqi;

ALTER TABLE qr_code_mapping 
ADD COLUMN transaction_type ENUM('deposit', 'withdrawal') DEFAULT 'deposit' AFTER status;

ALTER TABLE qr_code_mapping 
ADD COLUMN withdrawal_bank_code VARCHAR(20) DEFAULT NULL AFTER transaction_type;

ALTER TABLE qr_code_mapping 
ADD COLUMN withdrawal_bank_name VARCHAR(100) DEFAULT NULL AFTER withdrawal_bank_code;

ALTER TABLE qr_code_mapping 
ADD COLUMN withdrawal_account_number VARCHAR(50) DEFAULT NULL AFTER withdrawal_bank_name;

ALTER TABLE qr_code_mapping 
ADD COLUMN withdrawal_account_holder VARCHAR(255) DEFAULT NULL AFTER withdrawal_account_number;

ALTER TABLE qr_code_mapping 
ADD COLUMN fee DECIMAL(15,2) DEFAULT 0 AFTER amount;

ALTER TABLE qr_code_mapping 
ADD COLUMN qr_image_url TEXT DEFAULT NULL AFTER transfer_content;

ALTER TABLE qr_code_mapping 
ADD INDEX idx_transaction_type (transaction_type);

