{include file='_head.tpl'}
{include file='_header.tpl'}

<!-- page content -->
        <div class="{if $system['fluid_design']}container-fluid{else}container{/if} mt20 sg-offcanvas">
          <div class="row">

            <!-- side panel (mobile only) -->
            <div class="col-12 d-block d-md-none sg-offcanvas-sidebar">
              {include file='_sidebar.tpl'}
            </div>
            <!-- side panel -->

            <!-- OTP Rental Sidebar (desktop only) -->
            <div class="col-md-4 col-lg-3 sg-offcanvas-sidebar js_sticky-sidebar otp-rental-sidebar d-none d-md-block">
              <div class="card main-side-nav-card">
                <div class="card-body with-nav">
                  <ul class="main-side-nav">
                    <li {if $view == "" || $view == "rental"}class="active" {/if}>
                      <a href="{$system['system_url']}/otp-rental">
                        <i class="fa fa-mobile-alt main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                        {__("Thuê OTP")}
                      </a>
                    </li>
                    <li {if $view == "history"}class="active" {/if}>
                      <a href="{$system['system_url']}/otp-rental/history">
                        <i class="fa fa-history main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                        {__("Lịch sử thuê")}
                      </a>
                    </li>
                    <li>
                      <a href="{$system['system_url']}/wallet">
                        <i class="fa fa-credit-card main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                        {__("Nạp tiền")}
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
                  <li {if $view == "" || $view == "rental"}class="active" {/if}>
                    <a href="{$system['system_url']}/otp-rental">
                      {__("Thuê OTP")}
                    </a>
                  </li>
                  <li {if $view == "history"}class="active" {/if}>
                    <a href="{$system['system_url']}/otp-rental/history">
                      {__("Lịch sử")}
                    </a>
                  </li>
                  <li>
                    <a href="{$system['system_url']}/wallet">
                      {__("Nạp tiền")}
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
                  {if $user->_data['user_wallet_balance']}
                    {$user->_data['user_wallet_balance']|number_format} VND
                  {else}
                    0 VND
                  {/if}
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
                  {if isset($services) && $services}
                    {foreach $services as $service}
                      <option value="{$service.id}" data-price="{$service.price}" data-original-price="{$service.original_price}">
                        {$service.name} - {$service.price|number_format:0:',':'.'} VND
                      </option>
                    {/foreach}
                  {/if}
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


          <!-- Rental History -->
          <div class="row justify-content-center mt-4">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                      <i class="fa fa-history mr-2 text-info"></i>
                      Lịch sử thuê OTP
                    </h5>
                    <a href="{$system['system_url']}/otp-rental/history" class="btn btn-sm btn-outline-primary">
                      <i class="fa fa-eye mr-1"></i>Xem tất cả
                    </a>
                  </div>
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
                        {if $recent_rentals}
                          {foreach $recent_rentals as $rental}
                            <tr>
                              <td>{$rental.request_id}</td>
                              <td>
                                <span class="badge bg-info">{$rental.service_name|default:$rental.service_name}</span>
                              </td>
                              <td>
                                <span class="badge bg-primary">{$rental.phone_number}</span>
                              </td>
                              <td>
                                {if $rental.otp_code}
                                  <span class="badge bg-success clickable-otp" data-otp="{$rental.otp_code}" style="cursor: pointer;" title="Click để copy">{$rental.otp_code}</span>
                                {else}
                                  <span class="text-muted">-</span>
                                {/if}
                              </td>
                              <td>
                                {if $rental.status == 'pending'}
                                  <span class="badge bg-warning">Đợi tin nhắn</span>
                                {elseif $rental.status == 'completed'}
                                  <span class="badge bg-success">Hoàn thành</span>
                                {elseif $rental.status == 'expired'}
                                  <span class="badge bg-danger">Hết hạn</span>
                                {elseif $rental.status == 'failed'}
                                  <span class="badge bg-danger">Thất bại</span>
                                {else}
                                  <span class="badge bg-secondary">Không xác định</span>
                                {/if}
                              </td>
                              <td>
                                <small class="text-muted">
                                  {$rental.created_at|date_format:"%d/%m/%Y %H:%M"}
                                </small>
                              </td>
                              <td>
                                <strong class="text-success">
                                  {$rental.price|number_format} VND
                                </strong>
                              </td>
                            </tr>
                          {/foreach}
                        {else}
                          <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                              <i class="fa fa-inbox fa-2x mb-2"></i><br>
                              Chưa có lịch sử thuê nào
                            </td>
                          </tr>
                        {/if}
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

{include file='_footer.tpl'}

<script>
$(document).ready(function() {
    
    // Load rental history with URL parameters (only if no data from server)
    if ($('#rentalHistoryTable tr').length <= 1) {
        loadRentalHistory();
    }
    
    
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
    
    // Handle service selection
    $('#rentalService').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var price = selectedOption.data('price');
        var originalPrice = selectedOption.data('original-price');
        
        if (price) {
            // Remove existing price info
            $('.price-info').remove();
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
        console.log('Submitting rental request with service_id:', serviceId);
        $.ajax({
            url: '{$system['system_url']}/otp-rental',
            method: 'POST',
            data: {
                action: 'rent_otp',
                service_id: serviceId
            },
            success: function(response) {
                console.log('API Response:', response);
                if (response.success) {
                    // Success - no UI updates needed, data is in history
                    
                    // Update user balance display
                    updateUserBalance();
                    
                    // Reload rental history to show new rental immediately
                    loadRentalHistory();
                    
                    // OTP checking is handled automatically by cron job
                    
                    // Success - no alert needed, data is in history
                } else {
                    // Handle different error types
                    if (response.error === 'Số dư không đủ') {
                        var shortage = response.shortage || 0;
                        var current = response.current || 0;
                        var required = response.required || 0;
                        
                        var errorMsg = 'Số dư không đủ để thuê OTP!\n\n';
                        errorMsg += 'Số dư hiện tại: ' + formatPrice(current) + ' VND\n';
                        errorMsg += 'Cần: ' + formatPrice(required) + ' VND\n';
                        errorMsg += 'Thiếu: ' + formatPrice(shortage) + ' VND\n\n';
                        errorMsg += 'Vui lòng nạp thêm tiền vào ví để tiếp tục.';
                        
                        alert(errorMsg);
                    } else {
                        alert('Lỗi: ' + (response.error || 'Có lỗi xảy ra'));
                    }
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error:', xhr, status, error);
                alert('Có lỗi xảy ra khi thuê OTP: ' + error);
            },
            complete: function() {
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });
});


function loadRentalHistory() {
    console.log('Loading rental history...');
    
    $.ajax({
        url: '{$system['system_url']}/otp-rental',
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
        url: '{$system['system_url']}/otp-rental',
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

function updateUserBalance() {
    // Simply reload page to get updated balance
    location.reload();
}
</script>