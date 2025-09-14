{include file='_head.tpl'}
{include file='_header.tpl'}

<!-- page content -->
<div class="{if $system['fluid_design']}container-fluid{else}container{/if} mt20">
  <div class="row">

    <!-- content panel -->
    <div class="col-12">

      <!-- tabs -->
      <div class="content-tabs rounded-sm shadow-sm clearfix">
        <ul>
          <li {if $view == "" || $view == "check"}class="active" {/if}>
            <a href="{$system['system_url']}/shop-ai">
              {__("Check số")}
            </a>
          </li>
          <li {if $view == "recharge"}class="active" {/if}>
            <a href="{$system['system_url']}/shop-ai/recharge">
              {__("Nạp tiền")}
            </a>
          </li>
          <li {if $view == "transactions"}class="active" {/if}>
            <a href="{$system['system_url']}/shop-ai/transactions">
              {__("Giao dịch")}
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
            {if $view == "recharge"}
              <div class="card-header bg-transparent">
                <strong>{__("Nạp tiền")}</strong>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8 mx-auto">
                    <div class="text-center mb-4">
                      <i class="fa fa-credit-card fa-3x text-primary mb-3"></i>
                      <h4>{__("Nạp tiền vào tài khoản")}</h4>
                      <p class="text-muted">{__("Chọn số tiền bạn muốn nạp vào tài khoản")}</p>
                    </div>
                    
                    <!-- Số dư hiện tại -->
                    <div class="alert alert-info text-center">
                      <strong>{__("Số dư hiện tại")}: {number_format($current_balance, 0, ',', '.')} VNĐ</strong>
                    </div>
                    
                    <!-- Form nạp tiền -->
                    <form method="post" action="{$system['system_url']}/shop-ai/recharge" id="rechargeForm">
                      <div class="row justify-content-center">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label">{__("Số tiền nạp")}</label>
                            <div class="input-group">
                              <input type="number" 
                                     class="form-control" 
                                     id="amountInput" 
                                     name="amount" 
                                     placeholder="Nhập số tiền" 
                                     min="10000" 
                                     max="50000000" 
                                     step="1000"
                                     oninput="updateAmountPreview(this.value)"
                                     required>
                              <span class="input-group-text">VNĐ</span>
                            </div>
                            <small class="form-text text-muted mt-2">
                              Số tiền tối thiểu: 10,000 VNĐ - Tối đa: 50,000,000 VNĐ
                            </small>
                            
                            <!-- Quick amount buttons -->
                            <div class="mt-3">
                              <label class="form-label small">{__("Chọn nhanh")}:</label>
                              <div class="quick-select-container">
                                <div class="quick-select-scroll">
                                  <button type="button" class="btn btn-outline-primary quick-select-btn" onclick="setQuickAmount(50000)">50K</button>
                                  <button type="button" class="btn btn-outline-primary quick-select-btn" onclick="setQuickAmount(100000)">100K</button>
                                  <button type="button" class="btn btn-outline-primary quick-select-btn" onclick="setQuickAmount(200000)">200K</button>
                                  <button type="button" class="btn btn-outline-primary quick-select-btn" onclick="setQuickAmount(500000)">500K</button>
                                  <button type="button" class="btn btn-outline-primary quick-select-btn" onclick="setQuickAmount(1000000)">1M</button>
                                  <button type="button" class="btn btn-outline-primary quick-select-btn" onclick="setQuickAmount(2000000)">2M</button>
                                  <button type="button" class="btn btn-outline-primary quick-select-btn" onclick="setQuickAmount(5000000)">5M</button>
                                </div>
                              </div>
                            </div>
                            
                            <!-- Amount preview -->
                            <div class="mt-3" id="amountPreview" style="display: none;">
                              <div class="alert alert-success text-center">
                                <strong>Số tiền sẽ nạp: <span id="previewAmount">0</span> VNĐ</strong>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                    <div class="text-center">
                      <button type="button" 
                              class="btn btn-primary btn-lg" 
                              data-bs-toggle="modal" 
                              data-bs-target="#rechargeModal" 
                              onclick="openRechargeModal()"
                              id="rechargeBtn">
                        <i class="fa fa-qrcode mr5"></i>{__("Nạp tiền ngay")}
                      </button>
                    </div>
                    </form>
                    
                    <!-- QR Code Display -->
                    {if $qr_data}
                    <div class="mt-4" id="qrSection">
                      <div class="card">
                        <div class="card-body text-center">
                          <div class="mb-3">
                            <img src="{$qr_data}" alt="QR Code" class="img-fluid" style="max-width: 300px;">
                          </div>
                          
                          <div class="row">
                            <div class="col-md-6">
                              <div class="alert alert-info">
                                <strong>{__("Số tiền")}:</strong><br>
                                <span class="h5 text-success">{$amount|number_format} VNĐ</span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="alert alert-info">
                                <strong>{__("Nội dung")}:</strong><br>
                                <code>{$qr_content}</code>
                              </div>
                            </div>
                          </div>
                          
                          <div class="alert alert-warning">
                            <strong>{__("Thông tin chuyển khoản")}:</strong><br>
                            <strong>{__("Ngân hàng")}:</strong> ACB<br>
                            <strong>{__("STK")}:</strong> PHATLOC46241987<br>
                            <strong>{__("Nội dung")}:</strong> {$qr_content}<br>
                            <strong>{__("Người dùng")}:</strong> Guest<br>
                            <strong>{__("Thời gian")}:</strong> {$smarty.now|date_format:"%d/%m/%Y %H:%M:%S"}
                          </div>
                          
                          <div class="mt-3">
                            <button type="button" class="btn btn-success mr-2" onclick="saveQRCode()">
                              <i class="fa fa-download mr5"></i>{__("Lưu QR Code")}
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="closeQR()">
                              {__("Đóng")}
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    {/if}
                    
                    <!-- Thông tin bổ sung -->
                    <div class="mt-4">
                      <div class="alert alert-warning">
                        <h6><i class="fa fa-info-circle mr5"></i>{__("Lưu ý")}</h6>
                        <ul class="mb-0">
                          <li>{__("Giao dịch sẽ được xử lý trong vòng 5-10 phút")}</li>
                          <li>{__("Liên hệ hỗ trợ nếu có vấn đề")}</li>
                          <li>{__("Số tiền tối thiểu: 10,000 VNĐ")}</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- JavaScript for QR functions -->
              <script>
              function saveQRCode() {
                // Tạo link download cho QR code
                var qrImg = document.querySelector('#qrSection img');
                if (qrImg) {
                  var link = document.createElement('a');
                  link.download = 'qr-code-' + Date.now() + '.png';
                  link.href = qrImg.src;
                  link.click();
                }
              }
              
              function closeQR() {
                // Ẩn phần QR code
                var qrSection = document.getElementById('qrSection');
                if (qrSection) {
                  qrSection.style.display = 'none';
                }
              }
              </script>
            {elseif $view == "transactions"}
              <div class="card-header bg-transparent">
                <strong>{__("Lịch sử giao dịch")}</strong>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <!-- Số dư hiện tại -->
                    <div class="row mb-4">
                      <div class="col-12">
                        <div class="balance-card">
                          <div class="balance-info">
                            <div class="balance-icon">
                              <i class="fa fa-wallet"></i>
                            </div>
                <div class="balance-details">
                  <div class="balance-label">Số dư hiện tại</div>
                  <div class="balance-amount" id="currentBalance">{number_format($current_balance, 0, ',', '.')} VNĐ</div>
                  <button class="btn btn-sm btn-outline-light" onclick="refreshBalance()" style="margin-top: 5px;">
                    <i class="fa fa-refresh"></i> Làm mới
                  </button>
                </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Filter và tìm kiếm -->
                    <div class="row mb-4">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>{__("Tìm kiếm")}</label>
                          <input type="text" class="form-control" id="searchTransaction" placeholder="{__('Nhập từ khóa tìm kiếm')}">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>{__("Từ ngày")}</label>
                          <input type="date" class="form-control" id="fromDate">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>{__("Đến ngày")}</label>
                          <input type="date" class="form-control" id="toDate">
                        </div>
                      </div>
                    </div>
                    
                    <!-- Danh sách giao dịch -->
                    
                    <!-- Desktop: Bảng -->
                    <div class="table-responsive d-none d-md-block">
                      <table class="table table-striped" id="transactionsTable">
                        <thead class="thead-dark">
                          <tr>
                            <th>{__("Ngày")}</th>
                            <th>{__("Loại")}</th>
                            <th>{__("Số tiền")}</th>
                            <th>{__("Số dư sau")}</th>
                            <th>{__("Nội dung")}</th>
                            <th>{__("Trạng thái")}</th>
                          </tr>
                        </thead>
                        <tbody id="transactionsList">
                          <!-- Dữ liệu sẽ được load bằng AJAX -->
                          <tr>
                            <td colspan="6" class="text-center">
                              <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">{__("Đang tải...")}</span>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    
                    <!-- Mobile: Card -->
                    <div class="d-block d-md-none" id="transactionsCardList">
                      <!-- Dữ liệu sẽ được load bằng AJAX -->
                      <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                          <span class="sr-only">{__("Đang tải...")}</span>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Pagination -->
                    <nav aria-label="Transaction pagination">
                      <ul class="pagination justify-content-center" id="transactionPagination">
                        <!-- Pagination sẽ được tạo bằng JavaScript -->
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
              
              <!-- JavaScript cho tab giao dịch -->
              <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
              <script>
              // Wait for jQuery to be ready
              if (typeof jQuery === 'undefined') {
                console.error('jQuery not loaded!');
                // Fallback: load balance without jQuery
                setTimeout(function() {
                  loadBalanceFallback();
                }, 1000);
              } else {
                console.log('jQuery loaded successfully');
              }
              
              function loadBalanceFallback() {
                console.log('Loading balance with fallback method...');
                fetch('/TCSN/Script/includes/ajax/bank-transaction-simple.php', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                  },
                  body: 'action=get_balance&_t=' + new Date().getTime()
                })
                .then(response => response.json())
                .then(data => {
                  console.log('Fallback balance response:', data);
                  if (data.success) {
                    var formattedBalance = parseInt(data.balance).toLocaleString('vi-VN') + ' VNĐ';
                    document.getElementById('currentBalance').textContent = formattedBalance;
                  }
                })
                .catch(error => {
                  console.log('Fallback balance error:', error);
                  document.getElementById('currentBalance').textContent = '0 VNĐ';
                });
              }
              
              function refreshBalance() {
                console.log('Manual refresh balance...');
                document.getElementById('currentBalance').textContent = 'Đang tải...';
                
                if (typeof jQuery !== 'undefined' && jQuery) {
                  loadCurrentBalance();
                } else {
                  loadBalanceFallback();
                }
              }
              
              $(document).ready(function() {
                console.log('Document ready, loading balance and transactions...');
                loadCurrentBalance();
                loadTransactions();
                
                // Retry load balance after 2 seconds if still showing "Đang tải..."
                setTimeout(function() {
                  if ($('#currentBalance').text() === 'Đang tải...') {
                    console.log('Retrying balance load...');
                    loadCurrentBalance();
                  }
                }, 2000);
                
                // Tìm kiếm
                $('#searchTransaction').on('keyup', function() {
                  loadTransactions();
                });
                
                // Lọc theo ngày
                $('#fromDate, #toDate').on('change', function() {
                  loadTransactions();
                });
              });
              
              function loadCurrentBalance() {
                console.log('Loading current balance...');
                $.ajax({
                  url: '/TCSN/Script/includes/ajax/bank-transaction-simple.php',
                  method: 'POST',
                  data: {
                    action: 'get_balance',
                    user_id: 1,
                    _t: new Date().getTime() // Cache busting
                  },
                  cache: false,
                  success: function(response) {
                    console.log('Balance response:', response);
                    if (response.success) {
                      var formattedBalance = formatMoney(response.balance) + ' VNĐ';
                      console.log('Setting balance to:', formattedBalance);
                      $('#currentBalance').text(formattedBalance);
                    } else {
                      console.log('Balance response failed:', response);
                      $('#currentBalance').text('0 VNĐ');
                    }
                  },
                  error: function(xhr, status, error) {
                    console.log('Balance AJAX error:', status, error);
                    $('#currentBalance').text('0 VNĐ');
                  }
                });
              }
              
              function loadTransactions(page = 1) {
                console.log('Loading transactions...');
                var search = $('#searchTransaction').val();
                var fromDate = $('#fromDate').val();
                var toDate = $('#toDate').val();
                
                console.log('Search:', search, 'From:', fromDate, 'To:', toDate);
                
                $.ajax({
                  url: '/TCSN/Script/includes/ajax/bank-transaction-simple.php',
                  method: 'POST',
                  data: {
                    action: 'get_transactions',
                    user_id: 1,
                    search: search,
                    from_date: fromDate,
                    to_date: toDate,
                    page: page
                  },
                  success: function(response) {
                    console.log('AJAX Success:', response);
                    if (response.success) {
                      displayTransactions(response.data.transactions);
                      displayTransactionsCards(response.data.transactions);
                      displayPagination(response.data.pagination);
                    } else {
                      console.log('Response error:', response.message);
                      $('#transactionsList').html('<tr><td colspan="6" class="text-center text-danger">' + response.message + '</td></tr>');
                      $('#transactionsCardList').html('<div class="text-center text-danger p-3">' + response.message + '</div>');
                    }
                  },
                  error: function(xhr, status, error) {
                    console.log('AJAX Error:', error);
                    console.log('Status:', status);
                    console.log('Response:', xhr.responseText);
                    $('#transactionsList').html('<tr><td colspan="6" class="text-center text-danger">Lỗi: ' + error + '</td></tr>');
                    $('#transactionsCardList').html('<div class="text-center text-danger p-3">Lỗi: ' + error + '</div>');
                  }
                });
              }
              
              function displayTransactions(transactions) {
                var html = '';
                if (transactions.length > 0) {
                  transactions.forEach(function(transaction) {
                    var statusClass = transaction.status === 'completed' ? 'success' : 
                                    transaction.status === 'pending' ? 'warning' : 'danger';
                    var statusText = transaction.status === 'completed' ? '{__("Hoàn thành")}' :
                                   transaction.status === 'pending' ? '{__("Đang xử lý")}' : '{__("Thất bại")}';
                    
                    html += '<tr>';
                    html += '<td>' + transaction.created_at + '</td>';
                    html += '<td><span class="badge badge-' + (transaction.type === 'credit' ? 'success' : 'danger') + '">' + 
                           (transaction.type === 'credit' ? '{__("Nạp tiền")}' : '{__("Rút tiền")}') + '</span></td>';
                    html += '<td class="text-right">' + formatMoney(transaction.amount) + ' VNĐ</td>';
                    html += '<td class="text-right"><strong>' + formatMoney(transaction.balance_after) + ' VNĐ</strong></td>';
                    html += '<td>' + transaction.description + '</td>';
                    html += '<td><span class="badge badge-' + statusClass + '">' + statusText + '</span></td>';
                    html += '</tr>';
                  });
                } else {
                  html = '<tr><td colspan="6" class="text-center text-muted">{__("Không có giao dịch nào")}</td></tr>';
                }
                $('#transactionsList').html(html);
              }
              
              function displayTransactionsCards(transactions) {
                var html = '';
                if (transactions.length > 0) {
                  transactions.forEach(function(transaction) {
                    var statusClass = transaction.status === 'completed' ? 'success' : 
                                    transaction.status === 'pending' ? 'warning' : 'danger';
                    var statusText = transaction.status === 'completed' ? '{__("Hoàn thành")}' :
                                   transaction.status === 'pending' ? '{__("Đang xử lý")}' : '{__("Thất bại")}';
                    
                    var typeClass = transaction.type === 'credit' ? 'success' : 'danger';
                    var typeText = transaction.type === 'credit' ? '{__("Nạp tiền")}' : '{__("Rút tiền")}';
                    var amountClass = transaction.type === 'credit' ? 'text-success' : 'text-danger';
                    var amountPrefix = transaction.type === 'credit' ? '+' : '-';
                    
                    html += '<div class="card mb-3 transaction-card">';
                    html += '  <div class="card-body p-3">';
                    html += '    <div class="d-flex justify-content-between align-items-start mb-2">';
                    html += '      <div>';
                    html += '        <span class="badge badge-' + typeClass + ' mb-1">' + typeText + '</span>';
                    html += '        <div class="text-muted small">' + transaction.created_at + '</div>';
                    html += '      </div>';
                    html += '      <span class="badge badge-' + statusClass + '">' + statusText + '</span>';
                    html += '    </div>';
                    html += '    <div class="row">';
                    html += '      <div class="col-6">';
                    html += '        <div class="small text-muted">Số tiền</div>';
                    html += '        <div class="' + amountClass + ' font-weight-bold">' + amountPrefix + formatMoney(transaction.amount) + ' VNĐ</div>';
                    html += '      </div>';
                    html += '      <div class="col-6">';
                    html += '        <div class="small text-muted">Số dư sau</div>';
                    html += '        <div class="text-primary font-weight-bold">' + formatMoney(transaction.balance_after) + ' VNĐ</div>';
                    html += '      </div>';
                    html += '    </div>';
                    html += '    <div class="mt-2">';
                    html += '      <div class="small text-muted">Nội dung</div>';
                    html += '      <div class="text-truncate">' + transaction.description + '</div>';
                    html += '    </div>';
                    html += '  </div>';
                    html += '</div>';
                  });
                } else {
                  html = '<div class="text-center text-muted p-4">{__("Không có giao dịch nào")}</div>';
                }
                $('#transactionsCardList').html(html);
              }
              
              function displayPagination(pagination) {
                var html = '';
                if (pagination.total_pages > 1) {
                  for (var i = 1; i <= pagination.total_pages; i++) {
                    var activeClass = i === pagination.current_page ? 'active' : '';
                    html += '<li class="page-item ' + activeClass + '">';
                    html += '<a class="page-link" href="#" onclick="loadTransactions(' + i + ')">' + i + '</a>';
                    html += '</li>';
                  }
                }
                $('#transactionPagination').html(html);
              }
              
              function formatMoney(amount) {
                return parseInt(amount).toLocaleString('vi-VN');
              }
              </script>
              
              <!-- CSS cho tab giao dịch -->
              <style>
              /* Transaction Cards - Mobile */
              .transaction-card {
                border: 1px solid #e9ecef;
                border-radius: 12px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                transition: all 0.3s ease;
                background: #fff;
                margin-bottom: 16px;
              }
              
              .transaction-card:hover {
                box-shadow: 0 4px 8px rgba(0,0,0,0.15);
                transform: translateY(-2px);
              }
              
              .transaction-card .card-body {
                padding: 16px;
              }
              
              .transaction-card .badge {
                font-size: 11px;
                padding: 4px 8px;
                border-radius: 6px;
              }
              
              .transaction-card .font-weight-bold {
                font-weight: 600 !important;
              }
              
              .transaction-card .text-truncate {
                max-width: 100%;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
              }
              
              /* Transaction Table - Desktop */
              #transactionsTable {
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
              }
              
              #transactionsTable thead th {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                font-weight: 600;
                border: none;
                padding: 15px 12px;
                font-size: 14px;
              }
              
              #transactionsTable tbody tr {
                transition: all 0.3s ease;
              }
              
              #transactionsTable tbody tr:hover {
                background-color: #f8f9fa;
                transform: scale(1.01);
              }
              
              #transactionsTable tbody td {
                padding: 12px;
                vertical-align: middle;
                border-bottom: 1px solid #e9ecef;
              }
              
              /* Badge Styles */
              .badge-success {
                background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                color: white;
              }
              
              .badge-danger {
                background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
                color: white;
              }
              
              .badge-warning {
                background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
                color: #212529;
              }
              
              .badge-primary {
                background: linear-gradient(135deg, #007bff 0%, #6f42c1 100%);
                color: white;
              }
              
              /* Filter Section */
              .form-group label {
                font-weight: 600;
                color: #495057;
                margin-bottom: 8px;
              }
              
              .form-control {
                border-radius: 8px;
                border: 2px solid #e9ecef;
                padding: 10px 15px;
                transition: all 0.3s ease;
              }
              
              .form-control:focus {
                border-color: #667eea;
                box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
              }
              
              /* Pagination */
              .pagination .page-link {
                border-radius: 8px;
                margin: 0 2px;
                border: 2px solid #e9ecef;
                color: #667eea;
                font-weight: 600;
                transition: all 0.3s ease;
              }
              
              .pagination .page-item.active .page-link {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border-color: #667eea;
                color: white;
              }
              
              .pagination .page-link:hover {
                background-color: #f8f9fa;
                border-color: #667eea;
                transform: translateY(-2px);
              }
              
              /* Loading Spinner */
              .spinner-border {
                width: 2rem;
                height: 2rem;
                border-width: 0.2em;
              }
              
              /* Card Header */
              .card-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border-radius: 8px 8px 0 0;
                padding: 20px;
                font-size: 18px;
                font-weight: 600;
              }
              
              /* Balance Card */
              .balance-card {
                background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                border-radius: 12px;
                padding: 20px;
                color: white;
                box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
                margin-bottom: 20px;
              }
              
              .balance-info {
                display: flex;
                align-items: center;
                gap: 15px;
              }
              
              .balance-icon {
                font-size: 24px;
                opacity: 0.9;
              }
              
              .balance-details {
                flex: 1;
              }
              
              .balance-label {
                font-size: 14px;
                opacity: 0.9;
                margin-bottom: 5px;
                font-weight: 500;
              }
              
              .balance-amount {
                font-size: 24px;
                font-weight: 700;
                text-shadow: 0 2px 4px rgba(0,0,0,0.1);
              }
              
              @media (max-width: 767px) {
                .balance-card {
                  padding: 15px;
                }
                
                .balance-amount {
                  font-size: 20px;
                }
                
                .balance-icon {
                  font-size: 20px;
                }
              }
              
              /* Responsive Design */
              @media (max-width: 767px) {
                .transaction-card {
                  margin-bottom: 12px;
                }
                
                .transaction-card .card-body {
                  padding: 12px;
                }
                
                .form-group {
                  margin-bottom: 15px;
                }
                
                .card-header {
                  padding: 15px;
                  font-size: 16px;
                }
              }
              
              /* Dark mode support */
              body.night-mode .transaction-card {
                background: var(--card-dark-color, #2d3748);
                border-color: var(--card-dark-divider, #4a5568);
                color: var(--text-dark-color, #e2e8f0);
              }
              
              body.night-mode .transaction-card:hover {
                box-shadow: 0 4px 8px rgba(255,255,255,0.1);
              }
              
              body.night-mode #transactionsTable tbody tr:hover {
                background-color: var(--hover-dark-color, #4a5568);
              }
              
              body.night-mode .form-control {
                background-color: var(--input-dark-color, #4a5568);
                border-color: var(--border-dark-color, #718096);
                color: var(--text-dark-color, #e2e8f0);
              }
              </style>
            {else}
              <div class="card-header bg-transparent">
                <strong>{__("Check số")}</strong>
              </div>
              <div class="card-body">
                <div class="text-center">
                  <i class="fa fa-search fa-3x text-primary mb-3"></i>
                  <h4>{__("Tính năng Check số")}</h4>
                  <p class="text-muted">{__("Tính năng đang được phát triển")}</p>
                </div>
              </div>
            {/if}
          </div>
        </div>
        <!-- main content -->


      </div>
      <!-- content -->

    </div>
    <!-- content panel -->

  </div>
</div>
<!-- page content -->

<!-- Recharge Modal -->
<div class="modal fade" id="rechargeModal" tabindex="-1" aria-labelledby="rechargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rechargeModalLabel">
          <i class="fa fa-qrcode mr5"></i>{__("Nạp tiền")}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <!-- QR Code Display trong Modal -->
        <div id="modalQRSection" class="mt-4" style="display: none;">
          <div class="card">
            <div class="card-body text-center">
              <div class="mb-3">
                <img id="modalQRImage" src="" alt="QR Code" class="img-fluid" style="max-width: 300px;">
              </div>
              
              <!-- Thông tin thanh toán đẹp -->
              <div class="payment-info-card">
                <div class="row">
                  <div class="col-md-6">
                    <div class="info-item">
                      <div class="info-label">
                        <i class="fa fa-money-bill-wave text-success"></i>
                        {__("Số tiền")}
                      </div>
                      <div class="info-value" id="modalAmountDisplay">100.000 VNĐ</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-item">
                      <div class="info-label">
                        <i class="fa fa-qrcode text-primary"></i>
                        {__("Nội dung")}
                      </div>
                      <div class="info-value" id="modalContentDisplay">-</div>
                    </div>
                  </div>
                </div>
                
                <div class="row mt-3">
                  <div class="col-md-6">
                    <div class="info-item">
                      <div class="info-label">
                        <i class="fa fa-university text-info"></i>
                        {__("Ngân hàng")}
                      </div>
                      <div class="info-value">ACB - BUI QUOC VU</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-item">
                      <div class="info-label">
                        <i class="fa fa-credit-card text-warning"></i>
                        {__("Số tài khoản")}
                      </div>
                      <div class="info-value">PHATLOC46241987</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{__("Đóng")}</button>
        <button type="button" class="btn btn-success" id="saveQRBtn">
          <i class="fa fa-download mr5"></i>{__("Lưu QR")}
        </button>
      </div>
    </div>
  </div>
</div>

<style>
.payment-info-card {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 15px;
  padding: 25px;
  color: white;
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
  margin-top: 20px;
}

.info-item {
  text-align: center;
  margin-bottom: 15px;
}

.info-label {
  font-size: 14px;
  font-weight: 600;
  margin-bottom: 8px;
  opacity: 0.9;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.info-value {
  font-size: 16px;
  font-weight: 700;
  background: rgba(255,255,255,0.2);
  padding: 8px 12px;
  border-radius: 8px;
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255,255,255,0.3);
  word-break: break-all;
}

.info-value:empty::before {
  content: "-";
  opacity: 0.7;
}

.modal-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 15px 15px 0 0;
}

.modal-content {
  border-radius: 15px;
  border: none;
  box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}

.modal-body {
  padding: 30px;
}

#modalQRImage {
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
  border: 3px solid #fff;
}

.btn-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border: none;
  border-radius: 25px;
  padding: 12px 30px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-primary:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
}

.btn-primary:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-info {
  background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
  border: none;
  border-radius: 25px;
  padding: 12px 30px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-info:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(23, 162, 184, 0.4);
}

.form-control {
  border-radius: 10px;
  border: 2px solid #e9ecef;
  padding: 12px 15px;
  font-size: 16px;
  transition: all 0.3s ease;
}

.form-control:focus {
  border-color: #667eea;
  box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.input-group-text {
  border-radius: 0 10px 10px 0;
  border: 2px solid #e9ecef;
  border-left: none;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  font-weight: 600;
}

.btn-group .btn {
  border-radius: 8px !important;
  margin-right: 5px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-group .btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

            .alert-info {
              border-radius: 10px;
              border: none;
              background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
              color: #0c5460;
              font-weight: 600;
            }

            /* Quick select horizontal scroll for mobile */
            .quick-select-container {
              overflow-x: auto;
              overflow-y: hidden;
              -webkit-overflow-scrolling: touch;
              scrollbar-width: none; /* Firefox */
              -ms-overflow-style: none; /* IE and Edge */
            }

            .quick-select-container::-webkit-scrollbar {
              display: none; /* Chrome, Safari, Opera */
            }

            .quick-select-scroll {
              display: flex;
              gap: 8px;
              padding: 5px 0;
              min-width: max-content;
            }

            .quick-select-btn {
              flex-shrink: 0;
              min-width: 60px;
              white-space: nowrap;
              border-radius: 20px;
              font-weight: 600;
              transition: all 0.3s ease;
            }

            .quick-select-btn:hover {
              transform: translateY(-2px);
              box-shadow: 0 4px 12px rgba(0,123,255,0.3);
            }

            .quick-select-btn:active {
              transform: translateY(0);
            }

            /* Desktop: show all buttons in a row */
            @media (min-width: 768px) {
              .quick-select-scroll {
                flex-wrap: wrap;
                justify-content: center;
              }
              
              .quick-select-btn {
                flex: 1;
                max-width: 120px;
              }
            }

            /* Mobile: horizontal scroll */
            @media (max-width: 767px) {
              .quick-select-scroll {
                flex-wrap: nowrap;
                padding-bottom: 10px;
              }
              
              .quick-select-btn {
                min-width: 70px;
                font-size: 14px;
              }
            }

</style>

<script>
// Function to open modal and auto-generate QR
function openRechargeModal() {
  // Get amount from input field
  var amount = document.getElementById('amountInput').value;
  
  // Validate amount
  if (!amount || amount < 10000) {
    alert('Vui lòng nhập số tiền tối thiểu 10,000 VNĐ');
    document.getElementById('amountInput').focus();
    return;
  }
  
  if (amount > 50000000) {
    alert('Số tiền tối đa là 50,000,000 VNĐ');
    document.getElementById('amountInput').focus();
    return;
  }
  
  // Auto-generate QR code with entered amount
  updateQRCode(amount);
}

// Function to update QR code when amount changes
function updateQRCode(amount) {
  if (!amount) {
    $('#modalQRSection').hide();
    return;
  }
  
  // Generate unique content (10 characters max) - UPPERCASE
        var user_id = 1;
  var timestamp = Math.floor(Date.now() / 1000);
  var random_string = Math.random().toString(36).substring(2, 8).toUpperCase(); // 6 characters UPPERCASE
  var qr_content = 'RZ' + random_string; // Total: 8 characters (RZ + 6 random) - UPPERCASE
  
  // Show loading
  $('#modalQRImage').attr('src', 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjMwMCIgZmlsbD0iI2Y4ZjlmYSIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTQiIGZpbGw9IiM2Yzc1N2QiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5U4bqjIG3hu5kgUVIuLi48L3RleHQ+PC9zdmc+');
  $('#modalAmountDisplay').text(parseInt(amount).toLocaleString() + ' VNĐ');
  $('#modalContentDisplay').text(qr_content);
  
  // Show QR section and buttons
  $('#modalQRSection').show();
  $('#saveQRBtn').show();
  
  // Generate QR using VietQR API
  generateVietQR(amount, qr_content);
}

// Function to generate QR using VietQR
function generateVietQR(amount, content) {
  // VietQR configuration
  var accountNo = 'PHATLOC46241987';
  var accountName = 'BUI QUOC VU';
  var bankCode = '970416'; // ACB Bank code for VietQR
  var bankName = 'ACB';
  
  // Method 1: Try VietQR API with proper EMV format
  var vietqr_api_url = 'https://api.vietqr.io/v2/generate';
  var vietqr_data = {
    accountNo: accountNo,
    accountName: accountName,
    acqId: bankCode,
    amount: parseInt(amount),
    addInfo: content,
    format: 'text',
    template: 'compact'
  };
  
  // Method 2: VietQR image service with proper format
  var timestamp = Date.now();
  var qr_image_url = 'https://img.vietqr.io/image/' + bankCode + '-' + accountNo + '-' + amount + '-' + encodeURIComponent(content) + '.jpg?t=' + timestamp;
  
  // Method 3: Create VietQR dynamic URL for fallback
  var qr_url = 'https://vietqr.net/transfer/' + bankCode + '-' + accountNo + '?amount=' + amount + '&addInfo=' + encodeURIComponent(content);
  var fallback_url = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' + encodeURIComponent(qr_url);
  
  // Try VietQR API first (most reliable for dynamic QR)
  $.ajax({
    url: vietqr_api_url,
    method: 'POST',
    data: JSON.stringify(vietqr_data),
    contentType: 'application/json',
    success: function(response) {
      if (response.data && response.data.qrDataURL) {
        $('#modalQRImage').attr('src', response.data.qrDataURL);
      } else {
        // Fallback to VietQR image service
        tryVietQRImageService();
      }
    },
    error: function() {
      // Fallback to VietQR image service
      tryVietQRImageService();
    }
  });
  
  function tryVietQRImageService() {
    var img = new Image();
    
    img.onload = function() {
      $('#modalQRImage').attr('src', img.src);
    };
    
    img.onerror = function() {
      // Final fallback to QR Server with VietQR URL
      $('#modalQRImage').attr('src', fallback_url);
    };
    
    img.src = qr_image_url;
  }
}


            // Save QR Code function
            function saveQRCode() {
              var qrImg = document.getElementById('modalQRImage');
              if (qrImg) {
                var link = document.createElement('a');
                link.download = 'qr-code-' + Date.now() + '.png';
                link.href = qrImg.src;
                link.click();
              }
            }


            // Function to update amount preview
            function updateAmountPreview(amount) {
              if (amount && amount >= 10000) {
                document.getElementById('previewAmount').textContent = parseInt(amount).toLocaleString();
                document.getElementById('amountPreview').style.display = 'block';
              } else {
                document.getElementById('amountPreview').style.display = 'none';
              }
            }
            
            // Function to set quick amount
            function setQuickAmount(amount) {
              document.getElementById('amountInput').value = amount;
              updateAmountPreview(amount);
              
              // Update button state
              $('#rechargeBtn').prop('disabled', false);
              
              // Auto-generate QR if modal is open
              if ($('#rechargeModal').hasClass('show')) {
                updateQRCode(amount);
              }
            }
            
            // Initialize when document is ready
            $(document).ready(function() {
              // Save QR Code
              $('#saveQRBtn').click(saveQRCode);
              
              // Reset modal when closed
              $('#rechargeModal').on('hidden.bs.modal', function() {
                $('#modalQRSection').hide();
                $('#saveQRBtn').hide();
              });
              
              // Auto-generate QR when amount changes (if modal is open)
              $('#amountInput').on('input', function() {
                var amount = $(this).val();
                if (amount && amount >= 10000 && $('#rechargeModal').hasClass('show')) {
                  updateQRCode(amount);
                }
                
                // Update button state
                var isValid = amount && amount >= 10000 && amount <= 50000000;
                $('#rechargeBtn').prop('disabled', !isValid);
              });
              
              // Initial button state
              $('#rechargeBtn').prop('disabled', true);
            });
</script>

{include file='_footer.tpl'}
