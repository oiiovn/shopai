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

              /* Dark mode for badges in history page */
              body.night-mode .badge-info {
                background: #1171ef !important;
                color: white !important;
              }

              body.night-mode .badge-success {
                background: #2dce89 !important;
                color: white !important;
              }

              body.night-mode .badge-secondary {
                background: #666 !important;
                color: #ccc !important;
              }

              body.night-mode .badge-danger {
                background: #f5365c !important;
                color: white !important;
              }

              body.night-mode .badge-warning {
                background: #fb6340 !important;
                color: white !important;
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

              /* Dark mode for main card */
              body.night-mode .card {
                background: var(--card-dark-color);
                border-color: var(--card-dark-divider);
                color: var(--body-color-dark);
              }

              body.night-mode .card-header {
                background: linear-gradient(135deg, #5e72e4 0%, #825ee4 100%);
                color: white;
                border-bottom-color: var(--card-dark-divider);
              }

              body.night-mode .card-body {
                background: var(--card-dark-color);
                color: var(--body-color-dark);
              }

              /* Dark mode for new sections */
              body.night-mode .combined-section {
                background: var(--card-dark-color) !important;
                border-color: var(--card-dark-divider) !important;
              }

              body.night-mode .check-form-part,
              body.night-mode .filter-form-part {
                background: var(--card-dark-color) !important;
                border-color: var(--card-dark-divider) !important;
                color: var(--body-color-dark) !important;
              }

              body.night-mode .section-title {
                color: var(--body-color-dark);
                border-bottom-color: var(--card-dark-divider);
              }

              body.night-mode .check-form-part .section-title {
                color: var(--link-color);
                border-bottom-color: var(--link-color);
              }

              body.night-mode .filter-form-part .section-title {
                color: #2dce89;
                border-bottom-color: #2dce89;
              }

              body.night-mode .combined-section .form-label {
                color: var(--body-color-dark);
              }

              body.night-mode .combined-section .form-control {
                background-color: var(--card-dark-input);
                border-color: var(--card-dark-divider);
                color: var(--card-dark-input-color);
              }

              body.night-mode .combined-section .form-text {
                color: #999;
              }

              body.night-mode .history-section {
                background: var(--card-dark-color) !important;
                border-color: var(--card-dark-divider) !important;
                color: var(--body-color-dark) !important;
              }

              body.night-mode .history-header {
                background: var(--card-dark-color) !important;
                border-bottom-color: var(--card-dark-divider) !important;
                color: var(--body-color-dark) !important;
              }

              body.night-mode .history-header h5 {
                color: var(--body-color-dark);
              }

              body.night-mode .table th {
                background: var(--card-dark-color) !important;
                color: var(--body-color-dark) !important;
                border-bottom-color: var(--card-dark-divider) !important;
                border-color: var(--card-dark-divider) !important;
              }

              body.night-mode .table td {
                background: var(--card-dark-color) !important;
                color: var(--body-color-dark) !important;
                border-bottom-color: var(--card-dark-divider) !important;
                border-color: var(--card-dark-divider) !important;
              }

              body.night-mode .table {
                background: var(--card-dark-color) !important;
                color: var(--body-color-dark) !important;
              }

              body.night-mode .table-responsive {
                background: var(--card-dark-color) !important;
              }

              body.night-mode .table tbody tr:hover {
                background-color: var(--card-dark-hover);
              }

              body.night-mode .history-card {
                background: var(--card-dark-color);
                border-color: var(--card-dark-divider);
                color: var(--body-color-dark);
              }

              body.night-mode .history-card:hover {
                background-color: var(--card-dark-hover);
                box-shadow: 0 2px 12px rgba(0,0,0,0.3);
              }

              body.night-mode .history-card-header {
                border-bottom-color: var(--card-dark-divider);
              }

              body.night-mode .history-card-username {
                color: var(--body-color-dark);
              }

              body.night-mode .history-card-time {
                color: #999;
              }

              body.night-mode .history-card-note {
                border-top-color: var(--card-dark-divider);
                color: #999;
              }

              body.night-mode .phone-number {
                background: #2dce89;
                color: #fff;
              }

              body.night-mode .note-text {
                color: #999;
              }

              body.night-mode #emptyState .text-muted {
                color: #999;
              }

              /* Dark mode for buttons and navigation */
              body.night-mode .btn-primary {
                background-color: var(--link-color);
                border-color: var(--link-color);
              }

              body.night-mode .btn-info {
                background-color: #1171ef;
                border-color: #1171ef;
              }

              body.night-mode .nav-tabs .nav-link {
                color: var(--body-color-dark);
                background-color: var(--card-dark-color);
                border-color: var(--card-dark-divider);
              }

              body.night-mode .nav-tabs .nav-link.active {
                color: white;
                background-color: var(--link-color);
                border-color: var(--link-color);
              }

              body.night-mode .nav-tabs .nav-link:hover {
                background-color: var(--card-dark-hover);
                border-color: var(--card-dark-divider);
              }

              /* Dark mode for status badges */
              body.night-mode .status-badge.pending {
                background-color: #1171ef;
                color: white;
              }

              body.night-mode .status-badge.success {
                background-color: #2dce89;
                color: white;
              }

              body.night-mode .status-badge.not_found {
                background-color: #666;
                color: #ccc;
              }

              body.night-mode .status-badge.error {
                background-color: #f5365c;
                color: white;
              }

              /* Dark mode for pagination and other elements */
              body.night-mode .pagination {
                background: var(--card-dark-color) !important;
              }

              body.night-mode .page-item .page-link {
                background-color: var(--card-dark-color) !important;
                border-color: var(--card-dark-divider) !important;
                color: var(--body-color-dark) !important;
              }

              body.night-mode .page-item.active .page-link {
                background-color: var(--link-color) !important;
                border-color: var(--link-color) !important;
                color: white !important;
              }

              body.night-mode .page-item .page-link:hover {
                background-color: var(--card-dark-hover) !important;
                border-color: var(--card-dark-divider) !important;
                color: var(--body-color-dark) !important;
              }

              /* Dark mode for all text elements */
              body.night-mode .text-muted {
                color: #999 !important;
              }

              body.night-mode small.text-muted {
                color: #999 !important;
              }

              /* Dark mode for empty state */
              body.night-mode #emptyState {
                background: var(--card-dark-color) !important;
                color: var(--body-color-dark) !important;
              }

              body.night-mode #emptyState h5,
              body.night-mode #emptyState p {
                color: var(--body-color-dark) !important;
              }

              /* Dark mode for icons */
              body.night-mode .fa {
                color: var(--body-color-dark) !important;
              }
              </style>
            {elseif $view == "history"}
              <div class="card-header bg-transparent">
                <strong>{__("Lịch sử Check Số Điện Thoại")}</strong>
              </div>
              <div class="card-body">
                <!-- Statistics Section -->
                <div class="stats-section mb-4">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="stat-card">
                        <div class="stat-icon">
                          <i class="fa fa-list"></i>
                        </div>
                        <div class="stat-info">
                          <h4>{$stats.total}</h4>
                          <p>Tổng số check</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="stat-card success">
                        <div class="stat-icon">
                          <i class="fa fa-check"></i>
                        </div>
                        <div class="stat-info">
                          <h4>{$stats.success}</h4>
                          <p>Thành công</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="stat-card warning">
                        <div class="stat-icon">
                          <i class="fa fa-clock"></i>
                        </div>
                        <div class="stat-info">
                          <h4>{$stats.pending}</h4>
                          <p>Đang check</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="stat-card danger">
                        <div class="stat-icon">
                          <i class="fa fa-times"></i>
                        </div>
                        <div class="stat-info">
                          <h4>{$stats.not_found + $stats.error}</h4>
                          <p>Thất bại</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Filters Section -->
                <div class="filters-section mb-4">
                  <form method="GET" action="{$system['system_url']}/shop-ai" id="filterForm">
                    <input type="hidden" name="view" value="history">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="search" class="form-label">
                            <i class="fa fa-search mr-2"></i>Tìm kiếm username
                          </label>
                          <input type="text" class="form-control" id="search" name="search" 
                                 value="{$filters.search}" placeholder="Nhập username...">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="status_filter" class="form-label">
                            <i class="fa fa-filter mr-2"></i>Trạng thái
                          </label>
                          <select class="form-control" id="status_filter" name="status_filter">
                            <option value="">Tất cả</option>
                            <option value="pending" {if $filters.status_filter == "pending"}selected{/if}>Đang check</option>
                            <option value="success" {if $filters.status_filter == "success"}selected{/if}>Thành công</option>
                            <option value="not_found" {if $filters.status_filter == "not_found"}selected{/if}>Không tìm thấy</option>
                            <option value="error" {if $filters.status_filter == "error"}selected{/if}>Lỗi</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="date_from" class="form-label">
                            <i class="fa fa-calendar mr-2"></i>Từ ngày
                          </label>
                          <input type="date" class="form-control" id="date_from" name="date_from" value="{$filters.date_from}">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="date_to" class="form-label">
                            <i class="fa fa-calendar mr-2"></i>Đến ngày
                          </label>
                          <input type="date" class="form-control" id="date_to" name="date_to" value="{$filters.date_to}">
                        </div>
                      </div>
                      <div class="col-md-1">
                        <div class="form-group">
                          <label for="limit" class="form-label">Số dòng</label>
                          <select class="form-control" id="limit" name="limit">
                            <option value="10" {if $filters.limit == 10}selected{/if}>10</option>
                            <option value="20" {if $filters.limit == 20}selected{/if}>20</option>
                            <option value="50" {if $filters.limit == 50}selected{/if}>50</option>
                            <option value="100" {if $filters.limit == 100}selected{/if}>100</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label class="form-label">&nbsp;</label>
                          <div class="btn-group w-100">
                            <button type="submit" class="btn btn-primary">
                              <i class="fa fa-search mr-2"></i>Lọc
                            </button>
                            <button type="button" class="btn btn-success" id="exportBtn">
                              <i class="fa fa-download mr-2"></i>Excel
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>

                <!-- History Table -->
                <div class="history-table-section">
                  <div class="table-responsive">
                    <table class="table table-hover" id="historyTable">
                      <thead class="thead-dark">
                        <tr>
                          <th width="5%">#</th>
                          <th width="15%">Thời gian</th>
                          <th width="20%">Username</th>
                          <th width="15%">Trạng thái</th>
                          <th width="20%">Số điện thoại</th>
                          <th width="25%">Ghi chú</th>
                        </tr>
                      </thead>
                      <tbody>
                        {if $history && count($history) > 0}
                          {foreach $history as $index => $item}
                            <tr>
                              <td>{($pagination.current_page - 1) * $pagination.items_per_page + $index + 1}</td>
                              <td>
                                <div>
                                  <div style="font-weight: 600;">{$item.created_at|date_format:"%H:%M:%S"}</div>
                                  <div style="font-size: 12px; color: #6c757d;">{$item.created_at|date_format:"%d/%m/%Y"}</div>
                                </div>
                              </td>
                              <td><strong>{$item.checked_username}</strong></td>
                              <td>
                                {if $item.status == "pending"}
                                  <span class="badge badge-info">
                                    <i class="fa fa-spinner fa-spin mr-1"></i>Đang check...
                                  </span>
                                {elseif $item.status == "success"}
                                  <span class="badge badge-success">
                                    <i class="fa fa-check mr-1"></i>Thành công
                                  </span>
                                {elseif $item.status == "not_found"}
                                  <span class="badge badge-secondary">
                                    <i class="fa fa-user-times mr-1"></i>Không tìm thấy
                                  </span>
                                {else}
                                  <span class="badge badge-danger">
                                    <i class="fa fa-exclamation-triangle mr-1"></i>Lỗi
                                  </span>
                                {/if}
                              </td>
                              <td>
                                {if $item.phone}
                                  <span class="phone-number">{$item.phone}</span>
                                {else}
                                  <span class="text-muted">-</span>
                                {/if}
                              </td>
                              <td>
                                <span class="note-text">{$item.result_message}</span>
                              </td>
                            </tr>
                          {/foreach}
                        {else}
                          <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                              <i class="fa fa-search fa-2x mb-2"></i>
                              <br>Không tìm thấy dữ liệu phù hợp
                            </td>
                          </tr>
                        {/if}
                      </tbody>
                    </table>
                  </div>

                  <!-- Pagination -->
                  {if $pagination.total_pages > 1}
                    <nav class="mt-3">
                      <ul class="pagination justify-content-center">
                        {if $pagination.current_page > 1}
                          <li class="page-item">
                            <a class="page-link" href="?view=history&page={$pagination.current_page - 1}&search={$filters.search}&status_filter={$filters.status_filter}&date_from={$filters.date_from}&date_to={$filters.date_to}&limit={$filters.limit}">
                              Trước
                            </a>
                          </li>
                        {/if}
                        
                        {for $i=max(1, $pagination.current_page - 2) to min($pagination.total_pages, $pagination.current_page + 2)}
                          <li class="page-item {if $i == $pagination.current_page}active{/if}">
                            <a class="page-link" href="?view=history&page={$i}&search={$filters.search}&status_filter={$filters.status_filter}&date_from={$filters.date_from}&date_to={$filters.date_to}&limit={$filters.limit}">
                              {$i}
                            </a>
                          </li>
                        {/for}
                        
                        {if $pagination.current_page < $pagination.total_pages}
                          <li class="page-item">
                            <a class="page-link" href="?view=history&page={$pagination.current_page + 1}&search={$filters.search}&status_filter={$filters.status_filter}&date_from={$filters.date_from}&date_to={$filters.date_to}&limit={$filters.limit}">
                              Sau
                            </a>
                          </li>
                        {/if}
                      </ul>
                    </nav>
                  {/if}

                  <!-- Pagination Info -->
                  <div class="text-center mt-2">
                    <small class="text-muted">
                      Hiển thị {($pagination.current_page - 1) * $pagination.items_per_page + 1} - {min($pagination.current_page * $pagination.items_per_page, $pagination.total_items)} 
                      trong tổng số {$pagination.total_items} bản ghi
                    </small>
                  </div>
                </div>
              </div>

              <!-- Styles for History Page -->
              <style>
              .stats-section .stat-card {
                background: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                text-align: center;
                transition: all 0.3s ease;
                border-left: 4px solid #007bff;
              }

              /* Dark mode override for stat cards */
              body.night-mode .stats-section .stat-card {
                background: var(--card-dark-color) !important;
                color: var(--body-color-dark) !important;
                box-shadow: 0 2px 10px rgba(0,0,0,0.3) !important;
              }

              .stats-section .stat-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 20px rgba(0,0,0,0.15);
              }

              /* Dark mode hover for stat cards */
              body.night-mode .stats-section .stat-card:hover {
                background-color: var(--card-dark-hover) !important;
                box-shadow: 0 4px 20px rgba(0,0,0,0.5) !important;
              }

              .stats-section .stat-card.success {
                border-left-color: #28a745;
              }

              .stats-section .stat-card.warning {
                border-left-color: #ffc107;
              }

              .stats-section .stat-card.danger {
                border-left-color: #dc3545;
              }

              .stats-section .stat-icon {
                font-size: 24px;
                color: #007bff;
                margin-bottom: 10px;
              }

              .stats-section .stat-card.success .stat-icon {
                color: #28a745;
              }

              .stats-section .stat-card.warning .stat-icon {
                color: #ffc107;
              }

              .stats-section .stat-card.danger .stat-icon {
                color: #dc3545;
              }

              .stats-section .stat-info h4 {
                font-size: 28px;
                font-weight: bold;
                margin: 0;
                color: #495057;
              }

              .stats-section .stat-info p {
                margin: 0;
                color: #6c757d;
                font-size: 14px;
              }

              /* Dark mode for stat info */
              body.night-mode .stats-section .stat-info h4 {
                color: var(--body-color-dark) !important;
              }

              body.night-mode .stats-section .stat-info p {
                color: #999 !important;
              }

              .filters-section {
                background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
                padding: 25px;
                border-radius: 15px;
                border: 1px solid #bbdefb;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
              }

              /* Dark mode for filters section */
              body.night-mode .filters-section {
                background: linear-gradient(135deg, var(--body-bg-color-dark) 0%, var(--card-dark-color) 100%) !important;
                border-color: var(--card-dark-divider) !important;
                box-shadow: 0 2px 10px rgba(0,0,0,0.4) !important;
              }

              .filters-section .form-label {
                font-weight: 600;
                color: #1565c0;
                margin-bottom: 8px;
                font-size: 14px;
              }

              .filters-section .form-control {
                border-radius: 8px;
                border: 1px solid #bbdefb;
                transition: all 0.3s ease;
              }

              /* Dark mode for filters form elements */
              body.night-mode .filters-section .form-label {
                color: var(--link-color) !important;
              }

              body.night-mode .filters-section .form-control {
                background-color: var(--card-dark-input) !important;
                border-color: var(--card-dark-divider) !important;
                color: var(--card-dark-input-color) !important;
              }

              .filters-section .form-control:focus {
                border-color: #2196f3;
                box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
              }

              .history-table-section {
                background: white;
                border-radius: 15px;
                border: 1px solid #dee2e6;
                overflow: hidden;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
              }

              /* Dark mode for history table section */
              body.night-mode .history-table-section {
                background: var(--card-dark-color) !important;
                border-color: var(--card-dark-divider) !important;
                box-shadow: 0 2px 10px rgba(0,0,0,0.4) !important;
              }

              #historyTable thead th {
                background: linear-gradient(135deg, #495057 0%, #343a40 100%);
                color: white;
                font-weight: 600;
                border: none;
                padding: 15px 12px;
                font-size: 14px;
              }

              #historyTable tbody td {
                padding: 12px;
                vertical-align: middle;
                border-bottom: 1px solid #e9ecef;
              }

              #historyTable tbody tr {
                transition: all 0.3s ease;
              }

              #historyTable tbody tr:hover {
                background-color: #f8f9fa;
              }

              /* Dark mode for history table */
              body.night-mode #historyTable thead th {
                background: linear-gradient(135deg, var(--body-bg-color-dark) 0%, var(--card-dark-color) 100%) !important;
                color: var(--body-color-dark) !important;
              }

              body.night-mode #historyTable tbody td {
                background: var(--card-dark-color) !important;
                color: var(--body-color-dark) !important;
                border-bottom-color: var(--card-dark-divider) !important;
              }

              body.night-mode #historyTable tbody tr:hover {
                background-color: var(--card-dark-hover) !important;
              }

              .phone-number {
                font-family: 'Courier New', monospace;
                font-weight: 600;
                color: #28a745;
                background: #e8f5e8;
                padding: 4px 8px;
                border-radius: 4px;
                font-size: 13px;
              }

              .note-text {
                font-size: 13px;
                color: #6c757d;
                font-style: italic;
              }

              /* Dark mode for phone number and note text */
              body.night-mode .phone-number {
                background: #2dce89 !important;
                color: #fff !important;
              }

              body.night-mode .note-text {
                color: #999 !important;
              }

              /* Dark mode for History Page */
              body.night-mode .stats-section .stat-card {
                background: var(--card-dark-color);
                border-color: var(--card-dark-divider);
                color: var(--body-color-dark);
              }

              body.night-mode .stats-section .stat-card:hover {
                background-color: var(--card-dark-hover);
                box-shadow: 0 4px 20px rgba(0,0,0,0.3);
              }

              body.night-mode .stats-section .stat-info h4 {
                color: var(--body-color-dark);
              }

              body.night-mode .stats-section .stat-info p {
                color: #999;
              }

              body.night-mode .filters-section {
                background: linear-gradient(135deg, var(--body-bg-color-dark) 0%, var(--card-dark-color) 100%);
                border-color: var(--card-dark-divider);
              }

              body.night-mode .filters-section .form-label {
                color: var(--link-color);
              }

              body.night-mode .filters-section .form-control {
                background-color: var(--card-dark-input);
                border-color: var(--card-dark-divider);
                color: var(--card-dark-input-color);
              }

              body.night-mode .history-table-section {
                background: var(--card-dark-color);
                border-color: var(--card-dark-divider);
              }

              body.night-mode #historyTable thead th {
                background: linear-gradient(135deg, var(--body-bg-color-dark) 0%, var(--card-dark-color) 100%);
                color: var(--body-color-dark);
              }

              body.night-mode #historyTable tbody td {
                background: var(--card-dark-color);
                color: var(--body-color-dark);
                border-bottom-color: var(--card-dark-divider);
              }

              body.night-mode #historyTable tbody tr:hover {
                background-color: var(--card-dark-hover);
              }

              body.night-mode .note-text {
                color: #999;
              }

              /* Dark mode for pagination and other elements */
              body.night-mode .pagination .page-link {
                background-color: var(--card-dark-color) !important;
                border-color: var(--card-dark-divider) !important;
                color: var(--body-color-dark) !important;
              }

              body.night-mode .pagination .page-item.active .page-link {
                background-color: var(--link-color) !important;
                border-color: var(--link-color) !important;
                color: white !important;
              }

              body.night-mode .pagination .page-link:hover {
                background-color: var(--card-dark-hover) !important;
                border-color: var(--card-dark-divider) !important;
                color: var(--body-color-dark) !important;
              }

              body.night-mode .text-muted {
                color: #999 !important;
              }

              body.night-mode small.text-muted {
                color: #999 !important;
              }

              /* Dark mode for table text elements */
              body.night-mode #historyTable tbody td .text-muted {
                color: #999 !important;
              }

              body.night-mode #historyTable tbody td div {
                color: var(--body-color-dark) !important;
              }

              body.night-mode #historyTable tbody td div:last-child {
                color: #999 !important;
              }
              </style>

              <!-- JavaScript for History Page -->
              <script>
              document.addEventListener('DOMContentLoaded', function() {
                // Export to Excel functionality
                var exportBtn = document.getElementById('exportBtn');
                if (exportBtn) {
                  exportBtn.addEventListener('click', function() {
                    // Build export URL with current filters
                    var params = new URLSearchParams();
                    params.append('action', 'export_excel');
                    params.append('user_id', {$user->_data.user_id});
                    params.append('search', document.getElementById('search').value);
                    params.append('status_filter', document.getElementById('status_filter').value);
                    params.append('date_from', document.getElementById('date_from').value);
                    params.append('date_to', document.getElementById('date_to').value);
                    
                    var exportUrl = 'includes/ajax/phone-check-export.php?' + params.toString();
                    
                    // Create temporary link and click to download
                    var link = document.createElement('a');
                    link.href = exportUrl;
                    link.download = 'lich_su_check_' + new Date().getTime() + '.xlsx';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                  });
                }
                
                // Auto-submit form when filters change
                var filterInputs = document.querySelectorAll('#filterForm input, #filterForm select');
                filterInputs.forEach(function(input) {
                  if (input.type === 'text') {
                    // Debounce for text inputs
                    input.addEventListener('input', function() {
                      clearTimeout(input.timeout);
                      input.timeout = setTimeout(function() {
                        document.getElementById('filterForm').submit();
                      }, 500);
                    });
                  } else {
                    // Immediate submit for selects and dates
                    input.addEventListener('change', function() {
                      document.getElementById('filterForm').submit();
                    });
                  }
                });
              });
              </script>
            {else}
              <div class="card-header bg-transparent">
                <strong>Shopee Phone Checker</strong>
              </div>
              <div class="card-body">
                <!-- Combined Check & Filter Section -->
                <div class="combined-section mb-4">
                  <div class="row">
                    <!-- Check Form -->
                    <div class="col-md-6">
                      <div class="check-form-part">
                        <h5 class="section-title">
                          <i class="fa fa-mobile mr-2"></i>Check Số Điện Thoại Shopee
                        </h5>
                        <div class="form-group">
                          <label for="usernameInput" class="form-label">
                            <i class="fa fa-user mr-2"></i>Shopee Username
                          </label>
                          <div class="row">
                            <div class="col-8">
                              <input type="text" 
                                     class="form-control" 
                                     id="usernameInput" 
                                     placeholder="vd: buiquocvu"
                                     maxlength="30">
                            </div>
                            <div class="col-4">
                              <button type="button" class="btn btn-primary btn-block" id="checkBtn" disabled>
                                <i class="fa fa-search mr-1"></i><span class="btn-text-desktop">Check số</span><span class="btn-text-mobile">Gửi</span>
                              </button>
                            </div>
                          </div>
                          <small class="form-text text-muted">
                            3–30 ký tự, a–z, 0–9, chấm (.), gạch dưới (_), gạch ngang (-)
                          </small>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Search & Filter -->
                    <div class="col-md-6">
                      <div class="filter-form-part">
                        <h5 class="section-title">
                          <i class="fa fa-filter mr-2"></i>Tìm Kiếm & Lọc Lịch Sử
                        </h5>
                        <div class="form-group">
                          <label class="form-label">
                            <i class="fa fa-search mr-2"></i>Tìm kiếm & Lọc
                          </label>
                          <div class="row">
                            <div class="col-6">
                              <input type="text" class="form-control" id="searchInput" placeholder="Tìm username...">
                            </div>
                            <div class="col-6">
                              <select class="form-control" id="statusFilter">
                                <option value="">Tất cả trạng thái</option>
                                <option value="pending">Đang check</option>
                                <option value="success">Thành công</option>
                                <option value="not_found">Không tìm thấy</option>
                                <option value="error">Lỗi</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="btn-group btn-group-justified w-100">
                            <button class="btn btn-info" id="refreshBtn" title="Làm mới dữ liệu">
                              <i class="fa fa-refresh mr-1"></i>Làm mới
                            </button>
                            <a href="{$system['system_url']}/shop-ai?view=history" class="btn btn-primary" title="Xem tất cả lịch sử check">
                              <i class="fa fa-list mr-1"></i>Tất cả lịch sử
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- History Section -->
                <div class="history-section">
                  <div class="history-header mb-3">
                    <div class="row align-items-center">
                      <div class="col-md-6">
                        <h5 class="mb-0">
                          <i class="fa fa-history mr-2"></i>Lịch sử check
                        </h5>
                      </div>
                      <div class="col-md-6 text-right">
                        <small class="text-muted" id="historyStats">Đang tải...</small>
                      </div>
                    </div>
                  </div>

                  <!-- Desktop: History Table -->
                  <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover">
                      <thead class="thead-light">
                        <tr>
                          <th width="15%">Thời gian</th>
                          <th width="20%">Username</th>
                          <th width="15%">Trạng thái</th>
                          <th width="20%">Số điện thoại</th>
                          <th width="30%">Ghi chú</th>
                        </tr>
                      </thead>
                      <tbody id="historyTableBody">
                        <!-- History items will be populated here -->
                      </tbody>
                    </table>
                  </div>

                  <!-- Mobile: History Cards -->
                  <div class="d-block d-md-none" id="historyCardsList">
                    <!-- History cards will be populated here -->
                  </div>

                  <!-- Empty State -->
                  <div id="emptyState" class="text-center py-5" style="display: none;">
                    <i class="fa fa-search fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted" id="emptyStateTitle">Không tìm thấy kết quả</h5>
                    <p class="text-muted" id="emptyStateMessage">Thử thay đổi từ khóa tìm kiếm hoặc bộ lọc</p>
                  </div>
                </div>
              </div>

              <!-- Styles -->
              <style>
              .combined-section {
                background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 100%);
                padding: 20px;
                border-radius: 15px;
                border: 1px solid #bbdefb;
                margin-bottom: 20px;
                box-shadow: 0 2px 15px rgba(0,0,0,0.08);
              }

              /* Override for dark mode */
              body.night-mode .combined-section {
                background: linear-gradient(135deg, var(--card-dark-color) 0%, var(--body-bg-color-dark) 100%) !important;
                border-color: var(--card-dark-divider) !important;
                box-shadow: 0 2px 15px rgba(0,0,0,0.4) !important;
              }

              .check-form-part, .filter-form-part {
                background: white;
                padding: 18px;
                border-radius: 12px;
                box-shadow: 0 1px 8px rgba(0,0,0,0.06);
                height: 100%;
              }

              /* Override for dark mode */
              body.night-mode .check-form-part, 
              body.night-mode .filter-form-part {
                background: var(--card-dark-color) !important;
                border-color: var(--card-dark-divider) !important;
                color: var(--body-color-dark) !important;
                box-shadow: 0 1px 8px rgba(0,0,0,0.3) !important;
              }

              .check-form-part {
                border-left: 3px solid #007bff;
              }

              .filter-form-part {
                border-left: 3px solid #28a745;
              }

              .section-title {
                font-size: 14px;
                font-weight: 600;
                color: #495057;
                margin-bottom: 15px;
                padding-bottom: 8px;
                border-bottom: 1px solid #e9ecef;
              }

              .check-form-part .section-title {
                color: #007bff;
                border-bottom-color: #007bff;
              }

              .filter-form-part .section-title {
                color: #28a745;
                border-bottom-color: #28a745;
              }

              .combined-section .form-label {
                font-weight: 600;
                color: #495057;
                margin-bottom: 6px;
                font-size: 13px;
              }

              .combined-section .form-control {
                border-radius: 6px;
                border: 1px solid #dee2e6;
                transition: all 0.3s ease;
                padding: 8px 12px;
                font-size: 14px;
              }

              .combined-section .form-control:focus {
                border-color: #007bff;
                box-shadow: 0 0 0 0.15rem rgba(0, 123, 255, 0.2);
              }

              .combined-section .form-text {
                font-size: 11px;
                margin-top: 4px;
              }

              .combined-section .btn {
                padding: 8px 16px;
                font-size: 14px;
                border-radius: 6px;
              }

              .combined-section .btn-lg {
                padding: 10px 20px;
                font-size: 15px;
              }

              .btn-block {
                width: 100%;
              }

              /* Button text responsive */
              .btn-text-mobile {
                display: none;
              }

              .btn-text-desktop {
                display: inline;
              }

              /* Mobile Responsive */
              @media (max-width: 767px) {
                .combined-section {
                  padding: 15px;
                  margin-bottom: 15px;
                }
                
                .combined-section .row {
                  margin: 0 -5px;
                }
                
                .combined-section .col-md-6 {
                  padding: 0 5px;
                  margin-bottom: 15px;
                }
                
                .check-form-part, .filter-form-part {
                  padding: 15px;
                  margin-bottom: 10px;
                }
                
                .section-title {
                  font-size: 13px;
                  margin-bottom: 12px;
                  padding-bottom: 6px;
                }
                
                .combined-section .form-control {
                  padding: 6px 10px;
                  font-size: 13px;
                }
                
                .combined-section .btn {
                  padding: 6px 12px;
                  font-size: 13px;
                }
                
                .history-section {
                  margin-top: 10px;
                }
                
                .history-header {
                  padding: 12px 15px;
                }
                
                .history-header h5 {
                  font-size: 14px;
                }
                
                /* Button text mobile */
                .btn-text-desktop {
                  display: none;
                }
                
                .btn-text-mobile {
                  display: inline;
                }
              }

              /* History Cards for Mobile */
              .history-card {
                background: white;
                border: 1px solid #e9ecef;
                border-radius: 12px;
                margin-bottom: 12px;
                padding: 15px;
                box-shadow: 0 1px 6px rgba(0,0,0,0.08);
                transition: all 0.3s ease;
              }

              /* Override for dark mode */
              body.night-mode .history-card {
                background: var(--card-dark-color) !important;
                border-color: var(--card-dark-divider) !important;
                color: var(--body-color-dark) !important;
                box-shadow: 0 1px 6px rgba(0,0,0,0.3) !important;
              }

              .history-card:hover {
                box-shadow: 0 2px 12px rgba(0,0,0,0.12);
                transform: translateY(-1px);
              }

              /* Dark mode hover override */
              body.night-mode .history-card:hover {
                background-color: var(--card-dark-hover) !important;
                box-shadow: 0 2px 12px rgba(0,0,0,0.5) !important;
              }

              .history-card-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 10px;
                padding-bottom: 8px;
                border-bottom: 1px solid #f0f0f0;
              }

              .history-card-username {
                font-weight: 600;
                font-size: 15px;
                color: #495057;
              }

              .history-card-time {
                font-size: 11px;
                color: #6c757d;
                text-align: right;
              }

              .history-card-body {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 8px;
              }

              .history-card-status {
                flex: 0 0 auto;
              }

              .history-card-phone {
                flex: 1 1 auto;
                text-align: center;
              }

              .history-card-note {
                flex: 1 1 100%;
                margin-top: 8px;
                padding-top: 8px;
                border-top: 1px solid #f0f0f0;
                font-size: 12px;
                color: #6c757d;
                font-style: italic;
              }

              /* Additional dark mode overrides */
              body.night-mode .history-card-note {
                border-top-color: var(--card-dark-divider) !important;
                color: #999 !important;
              }

              body.night-mode .history-card-header {
                border-bottom-color: var(--card-dark-divider) !important;
              }

              body.night-mode .history-card-username {
                color: var(--body-color-dark) !important;
              }

              body.night-mode .history-card-time {
                color: #999 !important;
              }

              .form-label {
                font-weight: 600;
                color: #495057;
                margin-bottom: 8px;
              }

              .form-control:focus {
                border-color: #007bff;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
              }

              .btn-primary {
                background: linear-gradient(135deg, #007bff, #0056b3);
                border: none;
                padding: 12px 30px;
                font-weight: 600;
                border-radius: 8px;
                transition: all 0.3s ease;
              }

              .btn-primary:hover:not(:disabled) {
                background: linear-gradient(135deg, #0056b3, #004085);
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
              }

              .btn-primary:disabled {
                background: #6c757d;
                cursor: not-allowed;
                transform: none;
                box-shadow: none;
              }

              .history-section {
                background: white;
                border-radius: 12px;
                border: 1px solid #dee2e6;
                overflow: hidden;
              }

              .history-header {
                background: #f8f9fa;
                padding: 15px 18px;
                border-bottom: 1px solid #dee2e6;
              }

              /* Dark mode override for history section (main tab) */
              body.night-mode .history-section {
                background: var(--card-dark-color) !important;
                border-color: var(--card-dark-divider) !important;
              }

              body.night-mode .history-header {
                background: var(--card-dark-color) !important;
                border-bottom-color: var(--card-dark-divider) !important;
              }

              body.night-mode .history-header h5 {
                color: var(--body-color-dark) !important;
              }

              .history-header h5 {
                font-size: 16px;
                margin-bottom: 0;
              }

              .history-controls .input-group {
                max-width: 100%;
              }

              .history-controls .form-control {
                border-radius: 6px;
              }

              .table th {
                background: #f8f9fa;
                border-top: none;
                font-weight: 600;
                color: #495057;
                font-size: 13px;
                padding: 10px 12px;
              }

              .table td {
                vertical-align: middle;
                font-size: 13px;
                padding: 8px 12px;
              }

              .status-badge {
                display: inline-flex;
                align-items: center;
                padding: 4px 8px;
                border-radius: 15px;
                font-size: 11px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.3px;
              }

              .status-badge.pending {
                background: #e3f2fd;
                color: #1976d2;
                border: 1px solid #bbdefb;
              }

              .status-badge.success {
                background: #e8f5e8;
                color: #2e7d32;
                border: 1px solid #c8e6c9;
              }

              .status-badge.not_found {
                background: #f5f5f5;
                color: #616161;
                border: 1px solid #e0e0e0;
              }

              .status-badge.error {
                background: #ffebee;
                color: #c62828;
                border: 1px solid #ffcdd2;
              }

              .spinner {
                display: inline-block;
                width: 12px;
                height: 12px;
                border: 1.5px solid #f3f3f3;
                border-top: 1.5px solid #1976d2;
                border-radius: 50%;
                animation: spin 1s linear infinite;
                margin-right: 6px;
              }

              @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
              }

              .phone-number {
                font-family: 'Courier New', monospace;
                font-weight: 600;
                color: #28a745;
                background: #e8f5e8;
                padding: 3px 6px;
                border-radius: 4px;
                font-size: 12px;
              }

              .note-text {
                font-size: 12px;
                color: #6c757d;
                font-style: italic;
              }

              .empty-state {
                display: none;
              }

              .empty-state.show {
                display: block;
              }

              .table tbody tr {
                transition: all 0.2s ease;
              }

              .table tbody tr:hover {
                background-color: #f8f9fa;
              }

              /* Dark mode override for table hover */
              body.night-mode .table tbody tr:hover {
                background-color: var(--card-dark-hover) !important;
              }

              /* Dark mode for table elements (Check số tab) */
              body.night-mode .table {
                background: var(--card-dark-color) !important;
                color: var(--body-color-dark) !important;
              }

              body.night-mode .table thead th,
              body.night-mode .thead-light th {
                background: var(--card-dark-color) !important;
                color: var(--body-color-dark) !important;
                border-color: var(--card-dark-divider) !important;
                border-bottom-color: var(--card-dark-divider) !important;
              }

              body.night-mode .table tbody td,
              body.night-mode .table tbody th {
                background: var(--card-dark-color) !important;
                color: var(--body-color-dark) !important;
                border-color: var(--card-dark-divider) !important;
                border-bottom-color: var(--card-dark-divider) !important;
              }

              body.night-mode .table-responsive {
                background: var(--card-dark-color) !important;
                border-radius: 8px !important;
              }

              .history-item {
                animation: fadeInUp 0.3s ease-out;
              }

              @keyframes fadeInUp {
                from {
                  opacity: 0;
                  transform: translateY(20px);
                }
                to {
                  opacity: 1;
                  transform: translateY(0);
                }
              }

              .form-control.is-invalid {
                border-color: #dc3545;
                box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
              }

              .invalid-feedback {
                display: block;
                color: #dc3545;
                font-size: 12px;
                margin-top: 4px;
              }
              </style>

              <!-- JavaScript -->
              <script>
              document.addEventListener('DOMContentLoaded', function() {
                console.log('Loading history...');
                
                var currentPage = 1;
                var totalPages = 1;
                var currentSearch = '';
                var currentStatusFilter = '';
                
                function loadHistory(page) {
                  if (!page) page = 1;
                  currentPage = page;
                  
                  fetch('includes/ajax/phone-check-history.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ 
                      action: 'get_history', 
                      user_id: {$user->_data.user_id}, 
                      page: currentPage, 
                      limit: 5,
                      search: currentSearch,
                      status_filter: currentStatusFilter
                    })
                  })
                  .then(function(response) { return response.json(); })
                  .then(function(data) {
                    console.log('Data received:', data);
                    var tbody = document.getElementById('historyTableBody');
                    var empty = document.getElementById('emptyState');
                  
                  // Always clear both table and cards first
                  var tbody = document.getElementById('historyTableBody');
                  var cardsList = document.getElementById('historyCardsList');
                  if (tbody) tbody.innerHTML = '';
                  if (cardsList) cardsList.innerHTML = '';
                  
                  if (data.success && data.data.length > 0) {
                    if (empty) empty.style.display = 'none';
                    
                    // Render desktop table
                    renderDesktopTable(data.data);
                    
                    // Render mobile cards
                    renderMobileCards(data.data);
                    // Update pagination and stats
                    if (data.pagination) {
                      totalPages = data.pagination.total_pages;
                      updatePagination(data.pagination);
                      updateHistoryStats(data.pagination);
                    }
                  } else {
                    // No data found
                    if (empty) {
                      empty.style.display = 'block';
                      var emptyTitle = document.getElementById('emptyStateTitle');
                      var emptyMessage = document.getElementById('emptyStateMessage');
                      
                      if (currentSearch || currentStatusFilter) {
                        if (emptyTitle) emptyTitle.innerHTML = 'Không tìm thấy kết quả';
                        if (emptyMessage) emptyMessage.innerHTML = 'Thử thay đổi từ khóa tìm kiếm hoặc bộ lọc';
                      } else {
                        if (emptyTitle) emptyTitle.innerHTML = 'Chưa có lịch sử check nào';
                        if (emptyMessage) emptyMessage.innerHTML = 'Nhập username và bấm "Check số" để bắt đầu';
                      }
                    }
                    updatePagination({ current_page: 1, total_pages: 0, total_items: 0 });
                    updateHistoryStats({ current_page: 1, total_pages: 0, total_items: 0 });
                  }
                })
                .catch(function(error) {
                  console.error('Error:', error);
                  var tbody = document.getElementById('historyTableBody');
                  var cardsList = document.getElementById('historyCardsList');
                  var empty = document.getElementById('emptyState');
                  if (tbody) tbody.innerHTML = '';
                  if (cardsList) cardsList.innerHTML = '';
                  if (empty) empty.style.display = 'block';
                  updatePagination({ current_page: 1, total_pages: 0, total_items: 0 });
                  updateHistoryStats({ current_page: 1, total_pages: 0, total_items: 0 });
                });
                }
                
                function updatePagination(pagination) {
                  var container = document.getElementById('paginationContainer');
                  if (!container) {
                    container = document.createElement('div');
                    container.id = 'paginationContainer';
                    container.className = 'pagination-container mt-3';
                    var historySection = document.querySelector('.history-section');
                    if (historySection) {
                      historySection.appendChild(container);
                    }
                  }
                  
                  if (!pagination || pagination.total_pages <= 1) {
                    container.innerHTML = '';
                    return;
                  }
                  
                  var html = '<nav><ul class="pagination justify-content-center">';
                  
                  // Previous button
                  if (pagination.current_page > 1) {
                    html += '<li class="page-item"><a class="page-link" href="#" data-page="' + (pagination.current_page - 1) + '">Trước</a></li>';
                  }
                  
                  // Page numbers
                  var startPage = Math.max(1, pagination.current_page - 2);
                  var endPage = Math.min(pagination.total_pages, pagination.current_page + 2);
                  
                  for (var i = startPage; i <= endPage; i++) {
                    var activeClass = i === pagination.current_page ? 'active' : '';
                    html += '<li class="page-item ' + activeClass + '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
                  }
                  
                  // Next button
                  if (pagination.current_page < pagination.total_pages) {
                    html += '<li class="page-item"><a class="page-link" href="#" data-page="' + (pagination.current_page + 1) + '">Sau</a></li>';
                  }
                  
                  html += '</ul></nav>';
                  container.innerHTML = html;
                  
                  // Add click listeners
                  container.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (e.target.classList.contains('page-link')) {
                      var page = parseInt(e.target.dataset.page);
                      if (page && page !== currentPage) {
                        loadHistory(page);
                      }
                    }
                  });
                }
                
                // Form handling
                var input = document.getElementById('usernameInput');
                var btn = document.getElementById('checkBtn');
                
                if (input && btn) {
                  input.addEventListener('input', function() {
                    btn.disabled = input.value.trim().length < 3;
                  });
                  
                  btn.addEventListener('click', function() {
                    var username = input.value.trim().toLowerCase();
                    if (username.length < 3) return;
                    
                    btn.disabled = true;
                    
                    fetch('includes/ajax/phone-check-history.php', {
                      method: 'POST',
                      headers: { 'Content-Type': 'application/json' },
                      body: JSON.stringify({ action: 'check_phone', user_id: {$user->_data.user_id}, username: username })
                    })
                    .then(function(response) { return response.json(); })
                    .then(function(data) {
                      if (data.success) {
                        input.value = '';
                        loadHistory(1); // Reload history instead of page reload
                      } else {
                        alert('Lỗi: ' + data.message);
                      }
                    })
                    .catch(function(error) {
                      alert('Có lỗi xảy ra');
                    })
                    .finally(function() {
                      btn.disabled = false;
                    });
                  });
                }
                
                function renderDesktopTable(historyItems) {
                  var tbody = document.getElementById('historyTableBody');
                  if (!tbody) return;
                  
                  tbody.innerHTML = '';
                  
                  historyItems.forEach(function(item) {
                    var row = document.createElement('tr');
                    var time = new Date(item.created_at);
                    var timeStr = time.toLocaleTimeString('vi-VN', { 
                      hour: '2-digit', 
                      minute: '2-digit', 
                      second: '2-digit' 
                    });
                    var dateStr = time.toLocaleDateString('vi-VN');
                    
                    var statusBadge = createStatusBadge(item.status);
                    var phoneDisplay = item.phone ? '<span class="phone-number">' + item.phone + '</span>' : '-';
                    
                    row.innerHTML = '<td><div><div style="font-weight: 600;">' + timeStr + '</div><div style="font-size: 12px; color: #6c757d;">' + dateStr + '</div></div></td><td><strong>' + item.checked_username + '</strong></td><td>' + statusBadge + '</td><td>' + phoneDisplay + '</td><td><span class="note-text">' + item.result_message + '</span></td>';
                    tbody.appendChild(row);
                  });
                }
                
                function renderMobileCards(historyItems) {
                  var cardsList = document.getElementById('historyCardsList');
                  if (!cardsList) return;
                  
                  cardsList.innerHTML = '';
                  
                  historyItems.forEach(function(item) {
                    var card = document.createElement('div');
                    card.className = 'history-card';
                    
                    var time = new Date(item.created_at);
                    var timeStr = time.toLocaleTimeString('vi-VN', { 
                      hour: '2-digit', 
                      minute: '2-digit', 
                      second: '2-digit' 
                    });
                    var dateStr = time.toLocaleDateString('vi-VN');
                    
                    var statusBadge = createStatusBadge(item.status);
                    var phoneDisplay = item.phone ? '<span class="phone-number">' + item.phone + '</span>' : '<span class="text-muted">Chưa có</span>';
                    
                    card.innerHTML = 
                      '<div class="history-card-header">' +
                        '<div class="history-card-username">' + item.checked_username + '</div>' +
                        '<div class="history-card-time">' + timeStr + '<br>' + dateStr + '</div>' +
                      '</div>' +
                      '<div class="history-card-body">' +
                        '<div class="history-card-status">' + statusBadge + '</div>' +
                        '<div class="history-card-phone">' + phoneDisplay + '</div>' +
                        '<div class="history-card-note">' + item.result_message + '</div>' +
                      '</div>';
                    
                    cardsList.appendChild(card);
                  });
                }
                
                function createStatusBadge(status) {
                  if (status === 'pending') {
                    return '<span class="status-badge pending"><div class="spinner"></div> Đang check...</span>';
                  } else if (status === 'success') {
                    return '<span class="status-badge success"><i class="fa fa-check"></i> Thành công</span>';
                  } else if (status === 'not_found') {
                    return '<span class="status-badge not_found"><i class="fa fa-user-times"></i> Không tìm thấy</span>';
                  } else {
                    return '<span class="status-badge error"><i class="fa fa-exclamation-triangle"></i> Lỗi</span>';
                  }
                }
                
                function updateHistoryStats(pagination) {
                  var statsElement = document.getElementById('historyStats');
                  if (statsElement && pagination) {
                    if (pagination.total_items > 0) {
                      var from = (pagination.current_page - 1) * pagination.items_per_page + 1;
                      var to = Math.min(pagination.current_page * pagination.items_per_page, pagination.total_items);
                      statsElement.innerHTML = 'Hiển thị ' + from + '-' + to + ' trong tổng số ' + pagination.total_items + ' bản ghi';
                    } else {
                      if (currentSearch || currentStatusFilter) {
                        statsElement.innerHTML = 'Không tìm thấy kết quả phù hợp';
                      } else {
                        statsElement.innerHTML = 'Chưa có dữ liệu';
                      }
                    }
                  }
                }
                
                
                // Search and filter handling
                var searchInput = document.getElementById('searchInput');
                var statusFilter = document.getElementById('statusFilter');
                var refreshBtn = document.getElementById('refreshBtn');
                
                if (searchInput) {
                  searchInput.addEventListener('input', function() {
                    clearTimeout(searchInput.timeout);
                    searchInput.timeout = setTimeout(function() {
                      currentSearch = searchInput.value.trim();
                      currentPage = 1;
                      loadHistory(1);
                    }, 300);
                  });
                }
                
                if (statusFilter) {
                  statusFilter.addEventListener('change', function() {
                    currentStatusFilter = statusFilter.value;
                    currentPage = 1;
                    loadHistory(1);
                  });
                }
                
                if (refreshBtn) {
                  refreshBtn.addEventListener('click', function() {
                    currentSearch = '';
                    currentStatusFilter = '';
                    currentPage = 1;
                    
                    // Reset form values
                    if (searchInput) searchInput.value = '';
                    if (statusFilter) statusFilter.value = '';
                    
                    loadHistory(1);
                  });
                }
                
                // Initial load
                loadHistory(1);
              });
              </script>
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

