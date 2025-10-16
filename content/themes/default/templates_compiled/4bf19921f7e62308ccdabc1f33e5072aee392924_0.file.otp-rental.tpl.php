<?php
/* Smarty version 4.3.4, created on 2025-10-02 11:51:29
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/otp-rental.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68de6741428722_84774138',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4bf19921f7e62308ccdabc1f33e5072aee392924' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/otp-rental.tpl',
      1 => 1759405430,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_head.tpl' => 1,
    'file:_header.tpl' => 1,
    'file:_sidebar.tpl' => 1,
    'file:_footer.tpl' => 1,
  ),
),false)) {
function content_68de6741428722_84774138 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),));
$_smarty_tpl->_subTemplateRender('file:_head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender('file:_header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<!-- page content -->
        <div class="<?php if ($_smarty_tpl->tpl_vars['system']->value['fluid_design']) {?>container-fluid<?php } else { ?>container<?php }?> mt20 sg-offcanvas">
          <div class="row">

            <!-- side panel (mobile only) -->
            <div class="col-12 d-block d-md-none sg-offcanvas-sidebar">
              <?php $_smarty_tpl->_subTemplateRender('file:_sidebar.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
            </div>
            <!-- side panel -->

            <!-- OTP Rental Sidebar (desktop only) -->
            <div class="col-md-4 col-lg-3 sg-offcanvas-sidebar js_sticky-sidebar otp-rental-sidebar d-none d-md-block">
              <div class="card main-side-nav-card">
                <div class="card-body with-nav">
                  <ul class="main-side-nav">
                    <li <?php if ($_smarty_tpl->tpl_vars['view']->value == '' || $_smarty_tpl->tpl_vars['view']->value == "rental") {?>class="active" <?php }?>>
                      <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/otp-rental">
                        <i class="fa fa-mobile-alt main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                        <?php echo __("Thuê OTP");?>

                      </a>
                    </li>
                    <li <?php if ($_smarty_tpl->tpl_vars['view']->value == "history") {?>class="active" <?php }?>>
                      <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/otp-rental/history">
                        <i class="fa fa-history main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                        <?php echo __("Lịch sử thuê");?>

                      </a>
                    </li>
                    <li>
                      <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/wallet">
                        <i class="fa fa-credit-card main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                        <?php echo __("Nạp tiền");?>

                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <!-- OTP Rental Sidebar -->

            <!-- content panel -->
            <div class="col-12 col-md-8 col-lg-9 sg-offcanvas-mainbar otp-rental-mainbar">

              <!-- tabs (mobile only) -->
              <div class="content-tabs rounded-sm shadow-sm clearfix d-block d-md-none">
                <ul>
                  <li <?php if ($_smarty_tpl->tpl_vars['view']->value == '' || $_smarty_tpl->tpl_vars['view']->value == "rental") {?>class="active" <?php }?>>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/otp-rental">
                      <?php echo __("Thuê OTP");?>

                    </a>
                  </li>
                  <li <?php if ($_smarty_tpl->tpl_vars['view']->value == "history") {?>class="active" <?php }?>>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/otp-rental/history">
                      <?php echo __("Lịch sử");?>

                    </a>
                  </li>
                  <li>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/wallet">
                      <?php echo __("Nạp tiền");?>

                    </a>
                  </li>
                </ul>
              </div>
              <!-- tabs -->

              <!-- content -->
              <div class="row">
                <!-- main content -->
                <div class="col-12">
                  <div class="card">
        <div class="card-header bg-primary text-white">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h1 class="page-title mb-1">
                <i class="fa fa-mobile-alt mr-2"></i>
                Thuê OTP
              </h1>
              <p class="page-description mb-0">Dịch vụ thuê số điện thoại nhận OTP từ SHOP-AI</p>
            </div>
            <div class="col-md-4 text-end">
              <div class="d-flex align-items-center justify-content-end">
                <i class="fa fa-wallet mr-2"></i>
                <span class="me-2">Số dư:</span>
                <span class="badge bg-light text-dark fs-6" id="userBalance">
                  <?php if ($_smarty_tpl->tpl_vars['user']->value->_data['user_wallet_balance']) {?>
                    <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['user']->value->_data['user_wallet_balance']);?>
 VND
                  <?php } else { ?>
                    0 VND
                  <?php }?>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          
          <!-- Rental Form -->
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                  <form id="rentalForm">
                    <div class="row align-items-end g-3">
                      <div class="col-md-8">
                        <label class="form-label fw-bold">Dịch vụ</label>
                <select class="form-select form-select-lg" name="service" id="rentalService" required>
                  <option value="">Chọn dịch vụ...</option>
                  <?php if ((isset($_smarty_tpl->tpl_vars['services']->value)) && $_smarty_tpl->tpl_vars['services']->value) {?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['services']->value, 'service');
$_smarty_tpl->tpl_vars['service']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['service']->value) {
$_smarty_tpl->tpl_vars['service']->do_else = false;
?>
                      <option value="<?php echo $_smarty_tpl->tpl_vars['service']->value['id'];?>
" data-price="<?php echo $_smarty_tpl->tpl_vars['service']->value['price'];?>
" data-original-price="<?php echo $_smarty_tpl->tpl_vars['service']->value['original_price'];?>
">
                        <?php echo $_smarty_tpl->tpl_vars['service']->value['name'];?>
 - <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['service']->value['price'],0,',','.');?>
 VND
                      </option>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                  <?php }?>
                </select>
                      </div>
                      <div class="col-md-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                          <i class="fa fa-mobile-alt mr-2"></i>Thuê OTP
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Rental Status -->
          <div class="row justify-content-center mt-4" id="rentalStatus" style="display: none;">
            <div class="col-lg-8">
              <div class="card border-success">
                <div class="card-header bg-success text-white">
                  <h5 class="card-title mb-0">
                    <i class="fa fa-check-circle mr-2"></i>
                    Trạng thái thuê
                  </h5>
                </div>
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <div class="d-flex align-items-center">
                        <i class="fa fa-phone text-primary me-2"></i>
                        <strong class="me-2">Số điện thoại:</strong>
                        <span class="badge bg-primary" id="phoneNumber">-</span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="d-flex align-items-center">
                        <i class="fa fa-key text-success me-2"></i>
                        <strong class="me-2">Mã OTP:</strong>
                        <span class="badge bg-success fs-6" id="otpCode">-</span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="d-flex align-items-center">
                        <i class="fa fa-tag text-info me-2"></i>
                        <strong class="me-2">Dịch vụ:</strong>
                        <span class="badge bg-info" id="serviceName">-</span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="d-flex align-items-center">
                        <i class="fa fa-info-circle text-warning me-2"></i>
                        <strong class="me-2">Trạng thái:</strong>
                        <span class="badge bg-warning" id="status">-</span>
                      </div>
                    </div>
                  </div>
                  <div class="text-center mt-4">
                    <button class="btn btn-success btn-lg" id="checkOtpBtn">
                      <i class="fa fa-refresh mr-2"></i>Kiểm tra OTP
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Rental History -->
          <div class="row justify-content-center mt-4">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title mb-0">
                    <i class="fa fa-history mr-2 text-info"></i>
                    Lịch sử thuê OTP
                  </h5>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead class="table-light">
                        <tr>
                          <th>#</th>
                          <th>Dịch vụ</th>
                          <th>Số điện thoại</th>
                          <th>Mã OTP</th>
                          <th>Trạng thái</th>
                          <th>Thời gian</th>
                          <th>Giá</th>
                        </tr>
                      </thead>
                      <tbody id="rentalHistoryTable">
                        <tr>
                          <td colspan="7" class="text-center text-muted py-4">
                            <i class="fa fa-inbox fa-2x mb-2"></i><br>
                            Chưa có lịch sử thuê nào
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- content panel -->

  </div>
</div>

<?php $_smarty_tpl->_subTemplateRender('file:_footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
>
$(document).ready(function() {
    
    // Load rental history with URL parameters
    loadRentalHistory();
    
    
    // Handle OTP copy click
    $(document).on('click', '.clickable-otp', function() {
        var otpCode = $(this).data('otp');
        navigator.clipboard.writeText(otpCode).then(function() {
            // Show success message
            var originalText = $(this).text();
            $(this).text('Đã copy!').addClass('bg-info');
            setTimeout(function() {
                $(this).text(originalText).removeClass('bg-info');
            }.bind(this), 1000);
        }.bind(this));
    });
});
    
    // Handle service selection
    $('#rentalService').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var price = selectedOption.data('price');
        var originalPrice = selectedOption.data('original-price');
        
        if (price) {
            // Show price info
            var priceInfo = '<div class="mt-2"><small class="text-success fw-bold">Giá: ' + 
                formatPrice(price) + ' VND</small>';
            if (originalPrice && originalPrice != price) {
                priceInfo += ' <small class="text-muted">(Gốc: ' + formatPrice(originalPrice) + ' VND)</small>';
            }
            priceInfo += '</div>';
            
            // Remove existing price info
            $('.price-info').remove();
            // Add new price info
            $(this).parent().append('<div class="price-info">' + priceInfo + '</div>');
        } else {
            $('.price-info').remove();
        }
    });
    
    // Handle form submission
    $('#rentalForm').on('submit', function(e) {
        e.preventDefault();
        
        var serviceId = $('#rentalService').val();
        if (!serviceId) {
            alert('Vui lòng chọn dịch vụ');
            return;
        }
        
        // Show loading
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.html();
        submitBtn.html('<i class="fa fa-spinner fa-spin mr-2"></i>Đang xử lý...').prop('disabled', true);
        
        // Submit rental request
        $.ajax({
            url: '<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/otp-rental',
            method: 'POST',
            data: {
                action: 'rent_otp',
                service_id: serviceId
            },
            success: function(response) {
                if (response.success) {
                    // Show success message and update UI
                    $('#phoneNumber').text(response.data.phone_number);
                    $('#serviceName').text($('#rentalService option:selected').text());
                    $('#status').text('Đang chờ OTP...');
                    $('#rentalStatus').show();
                    
                    // Store request_id for checking OTP
                    $('#rentalStatus').data('request-id', response.data.request_id);
                    
                    // Reload rental history to show new rental immediately
                    loadRentalHistory();
                    
                    // Start checking for OTP every 5 seconds
                    startOTPChecking(response.data.request_id);
                    
                    alert('Thuê OTP thành công! Số điện thoại: ' + response.data.phone_number);
                } else {
                    alert('Lỗi: ' + (response.error || 'Có lỗi xảy ra'));
                }
            },
            error: function() {
                alert('Có lỗi xảy ra khi thuê OTP');
            },
            complete: function() {
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });
});

function startOTPChecking(requestId) {
    var checkInterval = setInterval(function() {
        $.ajax({
            url: '<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/otp-rental',
            method: 'POST',
            data: {
                action: 'check_otp',
                request_id: requestId
            },
            success: function(response) {
                if (response.success && response.data && response.data.status === 'completed') {
                    // OTP received, stop checking and update UI
                    clearInterval(checkInterval);
                    $('#status').text('Đã nhận OTP: ' + response.data.code);
                    $('#status').removeClass('text-warning').addClass('text-success');
                    
                    // Reload history to show updated status
                    loadRentalHistory();
                    
                    alert('Đã nhận OTP: ' + response.data.code);
                } else if (response.success && response.data && response.data.status === 'expired') {
                    // OTP expired, stop checking
                    clearInterval(checkInterval);
                    $('#status').text('OTP đã hết hạn');
                    $('#status').removeClass('text-warning').addClass('text-danger');
                    
                    // Reload history to show updated status
                    loadRentalHistory();
                }
            },
            error: function() {
                console.log('Error checking OTP status');
            }
        });
    }, 5000); // Check every 5 seconds
    
    // Stop checking after 5 minutes
    setTimeout(function() {
        clearInterval(checkInterval);
    }, 300000);
}

function loadRentalHistory() {
    console.log('Loading rental history...');
    
    $.ajax({
        url: '<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/otp-rental',
        method: 'POST',
        data: {
            action: 'get_rental_history',
            limit: 10
        },
        success: function(response) {
            console.log('Rental history response:', response);
            if (response.success && response.data) {
                console.log('Updating table with data:', response.data);
                updateRentalHistoryTable(response.data);
            } else {
                console.log('No data or success=false');
            }
        },
        error: function(xhr, status, error) {
            console.log('Error loading rental history:', error);
        }
    });
}



function updateRentalHistoryTable(rentals) {
    console.log('updateRentalHistoryTable called with:', rentals);
    var tbody = $('#rentalHistoryTable');
    console.log('Found tbody element:', tbody.length);
    tbody.empty();
    
    if (rentals.length === 0) {
        console.log('No rentals, showing empty message');
        tbody.append('<tr><td colspan="8" class="text-center">Chưa có lịch sử thuê OTP</td></tr>');
        return;
    }
    
    console.log('Processing ' + rentals.length + ' rentals');
    
    rentals.forEach(function(rental, index) {
        var statusClass = rental.status === 'completed' ? 'success' : 
                         rental.status === 'pending' ? 'warning' : 'danger';
        var statusText = rental.status === 'completed' ? 'Hoàn thành' :
                        rental.status === 'pending' ? 'Đang chờ' : 'Hết hạn';
        
        // Show OTP code if available
        var otpCode = rental.otp_code || '-';
        if (rental.status === 'completed' && rental.otp_code) {
            otpCode = '<span class="badge bg-success clickable-otp" data-otp="' + rental.otp_code + '" style="cursor: pointer;" title="Click để copy">' + rental.otp_code + '</span>';
        }
        
        var row = '<tr>' +
            '<td>' + (index + 1) + '</td>' +
            '<td>' + rental.service_name + '</td>' +
            '<td>' + rental.phone_number + '</td>' +
            '<td>' + otpCode + '</td>' +
            '<td><span class="badge bg-' + statusClass + '">' + statusText + '</span></td>' +
            '<td>' + rental.created_at + '</td>' +
            '<td>' + rental.price.toLocaleString() + ' VND</td>' +
            '<td>' + rental.request_id + '</td>' +
            '</tr>';
        
        console.log('Adding row for rental:', rental.service_name);
        tbody.append(row);
    });
}



function loadServices() {
    
    $.ajax({
        url: '<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/otp-rental',
        method: 'POST',
        data: {
            action: 'get_services'
        },
        success: function(response) {
            
            if (response && response.success && response.data) {
                var select = $('#rentalService');
                select.empty().append('<option value="">Chọn dịch vụ...</option>');
                
                response.data.forEach(function(service, index) {
                    var option = $('<option></option>')
                        .attr('value', service.id)
                        .attr('data-price', service.price)
                        .attr('data-original-price', service.original_price)
                        .text(service.name + ' - ' + formatPrice(service.price) + ' VND');
                    select.append(option);
                });
                
            }
        },
        error: function(xhr, status, error) {
            console.log('Error loading services:', error);
        }
    });
}

function formatPrice(price) {
    return parseInt(price).toLocaleString('vi-VN');
}
<?php echo '</script'; ?>
><?php }
}
