<?php
/*=====================
    OTP Rental Service - Simple Version
=====================*/

// Set page variables
$page = 'otp-rental';
$title = 'Thuê OTP';

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="inner">
                        <h1 class="page-title">Thuê OTP</h1>
                        <p class="page-description">Dịch vụ thuê số điện thoại nhận OTP từ ViOTP</p>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="row">
                    <!-- Left Column - Service Selection -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fa fa-mobile-alt mr-2"></i>
                                    Chọn Dịch Vụ
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Country Selection -->
                                <div class="form-group mb-4">
                                    <label class="form-label">Quốc gia</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="country-option active" data-country="vn">
                                                <div class="country-flag">🇻🇳</div>
                                                <div class="country-name">Việt Nam</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="country-option" data-country="la">
                                                <div class="country-flag">🇱🇦</div>
                                                <div class="country-name">Lào</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Service Selection -->
                                <div class="form-group mb-4">
                                    <label class="form-label">Dịch vụ</label>
                                    <select class="form-control" id="service-select">
                                        <option value="">Chọn dịch vụ...</option>
                                        <option value="1">Facebook - 800 VND</option>
                                        <option value="2">Shopee - 600 VND</option>
                                        <option value="3">Momo - 350 VND</option>
                                        <option value="4">Zalo - 500 VND</option>
                                        <option value="5">TikTok - 400 VND</option>
                                    </select>
                                </div>

                                <!-- Network Selection -->
                                <div class="form-group mb-4">
                                    <label class="form-label">Nhà mạng</label>
                                    <select class="form-control" id="network-select">
                                        <option value="">Chọn nhà mạng...</option>
                                        <option value="MOBIFONE">Mobifone</option>
                                        <option value="VINAPHONE">Vinaphone</option>
                                        <option value="VIETTEL">Viettel</option>
                                        <option value="VIETNAMOBILE">Vietnamobile</option>
                                        <option value="ITELECOM">Itelecom</option>
                                    </select>
                                </div>

                                <!-- Advanced Options -->
                                <div class="advanced-options">
                                    <h6 class="mb-3">Tùy chọn nâng cao</h6>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Đầu số muốn lấy</label>
                                                <input type="text" class="form-control" id="prefix-input" placeholder="VD: 90,91,92">
                                                <small class="form-text text-muted">Các đầu số cách nhau bằng dấu phẩy</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Đầu số không muốn lấy</label>
                                                <input type="text" class="form-control" id="except-prefix-input" placeholder="VD: 94,96,97">
                                                <small class="form-text text-muted">Các đầu số cách nhau bằng dấu phẩy</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Thuê lại số cũ</label>
                                        <input type="text" class="form-control" id="old-number-input" placeholder="Nhập số điện thoại cũ">
                                        <small class="form-text text-muted">Sử dụng số đã thuê trước đó</small>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-center mt-4">
                                    <button class="btn btn-primary btn-lg" id="rent-otp-btn">
                                        <i class="fa fa-mobile-alt mr-2"></i>
                                        Thuê OTP
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Status & Info -->
                    <div class="col-lg-4">
                        <!-- Balance Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title">
                                    <i class="fa fa-wallet mr-2"></i>
                                    Số dư tài khoản
                                </h6>
                            </div>
                            <div class="card-body text-center">
                                <div class="balance-amount">50,000 VND</div>
                                <small class="text-muted">Số dư hiện tại</small>
                            </div>
                        </div>

                        <!-- Rental Status -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title">
                                    <i class="fa fa-clock mr-2"></i>
                                    Trạng thái thuê
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="rental-status" id="rental-status">
                                    <div class="text-center text-muted">
                                        <i class="fa fa-mobile-alt fa-2x mb-2"></i>
                                        <p>Chưa có yêu cầu thuê</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Instructions -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title">
                                    <i class="fa fa-info-circle mr-2"></i>
                                    Hướng dẫn sử dụng
                                </h6>
                            </div>
                            <div class="card-body">
                                <ol class="instruction-list">
                                    <li>Chọn quốc gia và dịch vụ</li>
                                    <li>Chọn nhà mạng (tùy chọn)</li>
                                    <li>Nhấn "Thuê OTP"</li>
                                    <li>Chờ nhận số điện thoại</li>
                                    <li>Nhập OTP khi có tin nhắn</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    /* Custom Styles for OTP Rental */
    .country-option {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 10px;
    }

    .country-option:hover {
        border-color: #007bff;
        background-color: #f8f9fa;
    }

    .country-option.active {
        border-color: #007bff;
        background-color: #e3f2fd;
    }

    .country-flag {
        font-size: 24px;
        margin-bottom: 8px;
    }

    .country-name {
        font-weight: 500;
        color: #333;
    }

    .advanced-options {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-top: 20px;
    }

    .balance-amount {
        font-size: 24px;
        font-weight: bold;
        color: #28a745;
    }

    .rental-status {
        min-height: 100px;
    }

    .instruction-list {
        margin: 0;
        padding-left: 20px;
    }

    .instruction-list li {
        margin-bottom: 8px;
        color: #666;
    }

    .btn-lg {
        padding: 12px 30px;
        font-size: 16px;
    }

    .card {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border: none;
        margin-bottom: 20px;
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }

    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px 0;
        margin-bottom: 30px;
        border-radius: 8px;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .page-description {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }
        
        .country-option {
            padding: 10px;
        }
        
        .btn-lg {
            padding: 10px 20px;
            font-size: 14px;
        }
    }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Country selection
        $('.country-option').click(function() {
            $('.country-option').removeClass('active');
            $(this).addClass('active');
        });

        // Rent OTP button
        $('#rent-otp-btn').click(function() {
            var service = $('#service-select').val();
            var network = $('#network-select').val();
            var country = $('.country-option.active').data('country');
            
            if (!service) {
                alert('Vui lòng chọn dịch vụ');
                return;
            }
            
            // Simulate rental process
            $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-2"></i>Đang xử lý...');
            
            setTimeout(function() {
                $('#rental-status').html(`
                    <div class="alert alert-success">
                        <h6><i class="fa fa-check-circle mr-2"></i>Thuê thành công!</h6>
                        <p><strong>Số điện thoại:</strong> 0987654321</p>
                        <p><strong>Dịch vụ:</strong> Facebook</p>
                        <p><strong>Trạng thái:</strong> Đang chờ OTP</p>
                    </div>
                `);
                
                $('#rent-otp-btn').prop('disabled', false).html('<i class="fa fa-mobile-alt mr-2"></i>Thuê OTP');
            }, 2000);
        });
    });
    </script>
</body>
</html>
