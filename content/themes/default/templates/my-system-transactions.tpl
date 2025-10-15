<!-- transactions management -->


<!-- Filters and Search -->
<div class="card mb20">
  <div class="card-header">
    <div class="row align-items-center">
      <div class="col">
        <strong><i class="fa fa-filter mr10"></i>{__("Bộ Lọc và Tìm Kiếm")}</strong>
      </div>
      <div class="col-auto">
        <button class="btn btn-outline-danger btn-sm" id="clearFiltersBtn" onclick="clearFilters()" style="display: none;">
          <i class="fa fa-times mr5"></i>{__("Xóa Lọc")}
        </button>
        <button class="btn btn-primary btn-sm" id="filterBtn" onclick="filterTransactions()" style="width: 85px; height: 32px; text-align: center;">
          <i class="fa fa-search mr5"></i>{__("Lọc")}
        </button>
        <button class="btn btn-success btn-sm ml5" onclick="exportTransactions()">
          <i class="fa fa-download mr5"></i>{__("Xuất Excel")}
        </button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-3 mb10">
        <div class="form-group">
          <label class="form-label">{__("Loại Giao Dịch")}</label>
          <select class="form-control" id="transaction_type">
            <option value="" {if $current_type == ""}selected{/if} style="color: #6c757d; font-style: italic;">{__("Tất cả")}</option>
            <option value="recharge" {if $current_type == "recharge"}selected{/if}>{__("Nạp tiền")}</option>
            <option value="withdraw" {if $current_type == "withdraw"}selected{/if}>{__("Rút tiền")}</option>
          </select>
        </div>
      </div>
      <div class="col-md-3 mb10">
        <div class="form-group">
          <label class="form-label">{__("Khoảng Thời Gian")}</label>
          <select class="form-control" id="time_range">
            <option value="" {if $current_time_range == ""}selected{/if} style="color: #6c757d; font-style: italic;">{__("Tất cả")}</option>
            <option value="today" {if $current_time_range == "today"}selected{/if}>{__("Hôm nay")}</option>
            <option value="yesterday" {if $current_time_range == "yesterday"}selected{/if}>{__("Hôm qua")}</option>
            <option value="week" {if $current_time_range == "week"}selected{/if}>{__("7 ngày qua")}</option>
            <option value="month" {if $current_time_range == "month"}selected{/if}>{__("30 ngày qua")}</option>
            <option value="quarter" {if $current_time_range == "quarter"}selected{/if}>{__("3 tháng qua")}</option>
            <option value="year" {if $current_time_range == "year"}selected{/if}>{__("1 năm qua")}</option>
          </select>
        </div>
      </div>
      <div class="col-md-3 mb10">
        <div class="form-group">
          <label class="form-label">{__("Tìm kiếm theo User ID")}</label>
          <input type="text" class="form-control" id="search_user_id" placeholder="{__('Nhập User ID hoặc tên')}" value="{$current_search_user|default:''}">
        </div>
      </div>
      <div class="col-md-3 mb10">
        <div class="form-group">
          <label class="form-label">{__("Số tiền (VNĐ)")}</label>
          <input type="number" class="form-control" id="search_amount" placeholder="{__('Nhập số tiền')}" step="1000" min="0" value="{$current_search_amount|default:''}">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Filters and Search -->

<!-- Transactions Table -->
<div class="card" id="transactionsTableCard">
  <div class="card-header">
    <div class="row align-items-center">
      <div class="col">
        <strong><i class="fa fa-list mr10"></i>{__("Danh Sách Giao Dịch")}</strong>
      </div>
      <div class="col-auto">
        <span class="badge badge-info">{__("Tổng: {$total_transactions} giao dịch")}</span>
      </div>
    </div>
  </div>
  <div class="card-body" id="transactionsTableBody">
    
    {if $has_transactions}
      <!-- Transaction Table -->
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
          <thead class="bg-light">
            <tr>
              <th style="width: 80px;">{__("ID")}</th>
              <th style="width: 150px;">{__("User")}</th>
              <th style="width: 100px;">{__("Loại")}</th>
              <th style="width: 120px;">{__("Số Tiền")}</th>
              <th style="width: 200px;">{__("Mô Tả")}</th>
              <th style="width: 150px;">{__("Thời Gian")}</th>
              <th style="width: 100px;">{__("Thao Tác")}</th>
            </tr>
          </thead>
          <tbody>
            {foreach $transactions as $transaction}
              <tr>
                <td class="text-center">
                  <strong>#{$transaction.transaction_id}</strong>
                </td>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="{$transaction.user_picture}" 
                         class="rounded-circle mr10" width="30" height="30">
                    <div>
                      <div class="font-weight-bold">{$transaction.user_display_name}</div>
                      <small class="text-muted">ID: {$transaction.user_id}</small>
                    </div>
                  </div>
                </td>
                <td class="text-center">
                  {if $transaction.type == "recharge"}
                    <span style="background-color: #198754; color: white; font-size: 11px; padding: 8px 15px; border-radius: 20px; font-weight: 600; display: inline-block; min-width: 80px; text-align: center;">
                      <i class="fa fa-arrow-up mr5"></i>{__("NẠP TIỀN")}
                    </span>
                  {elseif $transaction.type == "withdraw"}
                    <span style="background-color: #dc3545; color: white; font-size: 11px; padding: 8px 15px; border-radius: 20px; font-weight: 600; display: inline-block; min-width: 80px; text-align: center;">
                      <i class="fa fa-arrow-down mr5"></i>{__("RÚT TIỀN")}
                    </span>
                  {else}
                    <span style="background-color: #6c757d; color: white; font-size: 11px; padding: 8px 15px; border-radius: 20px; font-weight: 600; display: inline-block; min-width: 80px; text-align: center;">
                      <i class="fa fa-question mr5"></i>{__("KHÁC")}
                    </span>
                  {/if}
                </td>
                <td class="text-right">
                  <span class="font-weight-bold {if $transaction.type == 'recharge'}text-success{elseif $transaction.type == 'withdraw'}text-danger{else}text-secondary{/if}">
                    {$transaction.formatted_amount}
                  </span>
                </td>
                <td>
                  <span class="text-muted">{$transaction.description|default:'-'}</span>
                </td>
                <td class="text-center">
                  <small>{$transaction.formatted_time}</small>
                </td>
                <td class="text-center">
                  <button class="btn btn-sm btn-outline-primary" onclick="viewTransactionDetails({$transaction.transaction_id})">
                    <i class="fa fa-eye"></i>
                  </button>
                </td>
              </tr>
            {/foreach}
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      {if $total_pages > 1}
        <div class="text-center mt20">
          <nav>
            <ul class="pagination justify-content-center">
              <!-- Previous Page -->
              <li class="page-item {if $current_page <= 1}disabled{/if}">
                {if $current_page > 1}
                  <a class="page-link" href="javascript:void(0)" onclick="loadPage({$current_page-1})">
                    <i class="fa fa-chevron-left mr5"></i>{__("Trước")}
                  </a>
                {else}
                  <span class="page-link">
                    <i class="fa fa-chevron-left mr5"></i>{__("Trước")}
                  </span>
                {/if}
              </li>

              <!-- Page Numbers -->
              {for $page = max(1, $current_page-2) to min($total_pages, $current_page+2)}
                <li class="page-item {if $page == $current_page}active{/if}">
                  <a class="page-link" href="javascript:void(0)" onclick="loadPage({$page})">
                    {$page}
                  </a>
                </li>
              {/for}

              <!-- Next Page -->
              <li class="page-item {if $current_page >= $total_pages}disabled{/if}">
                {if $current_page < $total_pages}
                  <a class="page-link" href="javascript:void(0)" onclick="loadPage({$current_page+1})">
                    {__("Sau")}<i class="fa fa-chevron-right ml5"></i>
                  </a>
                {else}
                  <span class="page-link">
                    {__("Sau")}<i class="fa fa-chevron-right ml5"></i>
                  </span>
                {/if}
              </li>
            </ul>
          </nav>
        </div>
      {/if}
    {else}
      <!-- No Transactions Message -->
      <div class="text-center text-muted" style="padding: 60px 20px;">
        <i class="fa fa-exchange-alt fa-5x mb20" style="opacity: 0.3;"></i>
        <h4 class="mb10">{__("Chưa có giao dịch nào")}</h4>
        <p class="text-muted">{__("Không tìm thấy giao dịch phù hợp với bộ lọc")}</p>
      </div>
    {/if}

    {* Debug Information - Only for admins *}
    {if isset($debug_info)}
      <div class="card mt20">
        <div class="card-header bg-warning">
          <strong><i class="fa fa-bug mr10"></i>{__("Debug Information")}</strong>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <strong>{__("Total Transactions:")}</strong> {$debug_info.total_transactions}<br>
              <strong>{__("Current Page:")}</strong> {$debug_info.current_page}<br>
              <strong>{__("Total Pages:")}</strong> {$debug_info.total_pages}<br>
            </div>
            <div class="col-md-6">
              <strong>{__("Where Clause:")}</strong> <code>{$debug_info.where_clause|default:'None'}</code><br>
              <strong>{__("Parameters:")}</strong> <code>{$debug_info.params|implode:', '}</code><br>
              <strong>{__("Parameter Types:")}</strong> <code>{$debug_info.param_types}</code><br>
            </div>
          </div>
        </div>
      </div>
    {/if}

  </div>
</div>
<!-- Transactions Table -->

<!-- Custom Modal Styles -->
<style>
  .modal-dialog-centered {
    animation: modalSlideDown 0.3s ease-out;
  }
  
  @keyframes modalSlideDown {
    from {
      opacity: 0;
      transform: translateY(-50px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .detail-item {
    transition: all 0.3s ease;
  }
  
  .detail-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }
  
  .btn-close-white {
    filter: brightness(0) invert(1);
    opacity: 0.8;
    transition: opacity 0.2s;
  }
  
  .btn-close-white:hover {
    opacity: 1;
  }
  
  .avatar-placeholder {
    transition: transform 0.3s ease;
  }
  
  .avatar-placeholder:hover {
    transform: scale(1.1);
  }
  
  #transactionModal .modal-footer .btn {
    transition: all 0.3s ease;
  }
  
  #transactionModal .modal-footer .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }
</style>

<!-- Transaction Details Modal -->
<div class="modal fade" id="transactionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
      <!-- Modal Header -->
      <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0; padding: 20px 30px;">
        <div>
          <h5 class="modal-title mb-0" style="font-weight: 600;">
            <i class="fa fa-file-invoice mr-2"></i>{__("Chi Tiết Giao Dịch")}
          </h5>
          <small class="d-block mt-1" style="opacity: 0.9;">ID: <span id="modal_transaction_id">-</span></small>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body" style="padding: 30px;">
        <!-- User Info Card -->
        <div class="card mb-3" style="border: none; background: #f8f9fa; border-radius: 10px;">
          <div class="card-body p-3">
            <h6 class="text-muted mb-3" style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">
              <i class="fa fa-user mr-1"></i> Thông Tin Người Dùng
            </h6>
            <div class="d-flex align-items-center">
              <div class="avatar-placeholder" style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 20px; margin-right: 15px;">
                U
              </div>
              <div>
                <div style="font-weight: 600; font-size: 16px; color: #2d3748;">User Name</div>
                <small class="text-muted">User ID: <span id="modal_user_id">-</span></small>
              </div>
            </div>
          </div>
        </div>

        <!-- Transaction Details Grid -->
        <div class="row g-3">
          <!-- Transaction Type -->
          <div class="col-md-6">
            <div class="detail-item" style="background: white; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0;">
              <label class="d-block mb-2" style="font-size: 12px; color: #718096; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">
                <i class="fa fa-tag mr-1"></i> Loại Giao Dịch
              </label>
              <div id="modal_type" style="font-weight: 600; font-size: 15px; color: #2d3748;">-</div>
            </div>
          </div>

          <!-- Amount -->
          <div class="col-md-6">
            <div class="detail-item" style="background: white; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0;">
              <label class="d-block mb-2" style="font-size: 12px; color: #718096; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">
                <i class="fa fa-money-bill-wave mr-1"></i> Số Tiền
              </label>
              <div id="modal_amount" style="font-weight: 700; font-size: 20px; color: #48bb78;">-</div>
            </div>
          </div>

          <!-- Time -->
          <div class="col-md-6">
            <div class="detail-item" style="background: white; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0;">
              <label class="d-block mb-2" style="font-size: 12px; color: #718096; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">
                <i class="fa fa-clock mr-1"></i> Thời Gian
              </label>
              <div id="modal_date" style="font-weight: 600; font-size: 15px; color: #2d3748;">-</div>
            </div>
          </div>

          <!-- Status Badge -->
          <div class="col-md-6">
            <div class="detail-item" style="background: white; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0;">
              <label class="d-block mb-2" style="font-size: 12px; color: #718096; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">
                <i class="fa fa-check-circle mr-1"></i> Trạng Thái
              </label>
              <div>
                <span class="badge" style="background: #48bb78; color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px;">
                  <i class="fa fa-check mr-1"></i> Hoàn Thành
                </span>
              </div>
            </div>
          </div>

          <!-- Description -->
          <div class="col-12">
            <div class="detail-item" style="background: white; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0;">
              <label class="d-block mb-2" style="font-size: 12px; color: #718096; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">
                <i class="fa fa-align-left mr-1"></i> Mô Tả
              </label>
              <div id="modal_description" style="color: #4a5568; line-height: 1.6;">-</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer" style="background: #f8f9fa; border-radius: 0 0 15px 15px; padding: 20px 30px; border-top: 1px solid #e2e8f0;">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px; padding: 10px 20px; font-weight: 500;">
          <i class="fa fa-times mr-1"></i> {__("Đóng")}
        </button>
        <button type="button" class="btn btn-primary" style="border-radius: 8px; padding: 10px 20px; font-weight: 500; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
          <i class="fa fa-edit mr-1"></i> {__("Cập Nhật")}
        </button>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript Functions -->
<script>
// Store initial values to detect changes
let initialValues = {};

// Auto-filter timer
let filterTimeout;

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
  const inputs = ['transaction_type', 'time_range', 'search_user_id', 'search_amount'];
  
  // Store initial values (empty values for comparison)
  inputs.forEach(function(id) {
    initialValues[id] = '';
  });
  
  // Check if any filters are currently applied on page load
  checkIfFiltersApplied();
  
  // Add event listeners to detect changes and auto-filter
  inputs.forEach(function(id) {
    const element = document.getElementById(id);
    
    // For dropdowns (select), filter immediately on change
    if (element.tagName === 'SELECT') {
      element.addEventListener('change', function() {
        checkIfFiltersApplied();
        autoFilter();
      });
    }
    
    // For text inputs, add debounced auto-filter
    else {
      element.addEventListener('input', function() {
        checkIfFiltersApplied();
        
        // Clear existing timeout
        clearTimeout(filterTimeout);
        
        // Set new timeout for auto-filter (500ms delay)
        filterTimeout = setTimeout(function() {
          autoFilter();
        }, 500);
      });
      
      // Also filter on Enter key
      element.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
          clearTimeout(filterTimeout);
          autoFilter();
        }
      });
    }
  });
});

function checkIfFiltersApplied() {
  const inputs = ['transaction_type', 'time_range', 'search_user_id', 'search_amount'];
  let hasFilters = false;
  
  inputs.forEach(function(id) {
    const value = document.getElementById(id).value.trim();
    if (value !== '') {
      hasFilters = true;
    }
  });
  
  // Show/hide clear button based on whether filters are applied
  const clearBtn = document.getElementById('clearFiltersBtn');
  if (hasFilters) {
    clearBtn.style.display = 'inline-block';
  } else {
    clearBtn.style.display = 'none';
  }
}

function autoFilter() {
  // Show loading state
  const filterBtn = document.getElementById('filterBtn');
  
  // Keep button text the same, just disable it
  filterBtn.disabled = true;
  
  // Perform filter
  performFilter();
  
  // Reset button after a short delay
  setTimeout(function() {
    filterBtn.disabled = false;
  }, 1000);
}

function filterTransactions() {
  // Show loading state
  const filterBtn = document.getElementById('filterBtn');
  
  // Keep button text the same, just disable it
  filterBtn.disabled = true;
  
  // Perform filter
  performFilter();
  
  // Reset button after a short delay
  setTimeout(function() {
    filterBtn.disabled = false;
  }, 1000);
}

function performFilter() {
  // Get filter values
  const type = document.getElementById('transaction_type').value;
  const timeRange = document.getElementById('time_range').value;
  const searchUser = document.getElementById('search_user_id').value;
  const searchAmount = document.getElementById('search_amount').value;
  
  // Build URL with parameters
  const params = new URLSearchParams();
  params.append('page', '1'); // Reset to first page
  params.append('ajax', '1'); // AJAX request flag
  
  if (type) params.append('type', type);
  if (timeRange) params.append('time_range', timeRange);
  if (searchUser) params.append('search_user', searchUser);
  if (searchAmount) params.append('search_amount', searchAmount);
  
  // Show loading state
  showTableLoading();
  
  // Make AJAX request
  fetch('?view=transactions&' + params.toString(), {
    method: 'GET',
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.text())
  .then(data => {
    // AJAX response is just the card-body content
    // Target only the transactions table card-body by ID
    const currentTableContent = document.getElementById('transactionsTableBody');
    if (currentTableContent) {
      // Replace table content directly
      currentTableContent.innerHTML = data;
      
      // Update URL without reload
      window.history.pushState({}, '', '?view=transactions&' + params.toString().replace('&ajax=1', ''));
      
      // Check filters after update
      checkIfFiltersApplied();
    }
  })
  .catch(error => {
    console.error('Filter error:', error);
    // Fallback to page reload
    window.location.href = '?view=transactions&' + params.toString().replace('&ajax=1', '');
  })
  .finally(() => {
    hideTableLoading();
  });
}

function clearFilters() {
  // Clear all filter inputs
  document.getElementById('transaction_type').value = '';
  document.getElementById('time_range').value = '';
  document.getElementById('search_user_id').value = '';
  document.getElementById('search_amount').value = '';
  
  // Perform filter with empty values
  performFilter();
}

function showTableLoading() {
  const tableContent = document.getElementById('transactionsTableBody');
  if (tableContent) {
    tableContent.innerHTML = `
      <div class="text-center" style="padding: 60px 20px;">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
          <span class="sr-only">Đang tải...</span>
        </div>
        <h5 class="mt-3">Đang lọc dữ liệu...</h5>
        <p class="text-muted">Vui lòng chờ trong giây lát</p>
      </div>
    `;
  }
}

function hideTableLoading() {
  // Loading will be replaced by new content from AJAX response
}


function loadPage(page) {
  // Get current filter values
  const type = document.getElementById('transaction_type').value;
  const timeRange = document.getElementById('time_range').value;
  const searchUser = document.getElementById('search_user_id').value;
  const searchAmount = document.getElementById('search_amount').value;
  
  // Build URL with parameters
  const params = new URLSearchParams();
  params.append('page', page);
  params.append('ajax', '1'); // AJAX request flag
  
  if (type) params.append('type', type);
  if (timeRange) params.append('time_range', timeRange);
  if (searchUser) params.append('search_user', searchUser);
  if (searchAmount) params.append('search_amount', searchAmount);
  
  // Show loading state
  showTableLoading();
  
  // Make AJAX request
  fetch('?view=transactions&' + params.toString(), {
    method: 'GET',
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.text())
  .then(data => {
    // AJAX response is just the card-body content
    // Target only the transactions table card-body by ID
    const currentTableContent = document.getElementById('transactionsTableBody');
    if (currentTableContent) {
      // Replace table content directly
      currentTableContent.innerHTML = data;
      
      // Update URL without reload
      window.history.pushState({}, '', '?view=transactions&' + params.toString().replace('&ajax=1', ''));
      
      // Scroll to top of table
      document.getElementById('transactionsTableCard').scrollIntoView({ behavior: 'smooth' });
    }
  })
  .catch(error => {
    console.error('Page load error:', error);
    // Fallback to page reload
    window.location.href = '?view=transactions&' + params.toString().replace('&ajax=1', '');
  })
  .finally(() => {
    hideTableLoading();
  });
}

function exportTransactions() {
  // Placeholder for export functionality
  console.log('Exporting transactions...');
}

function viewTransactionDetails(transactionId) {
  // Placeholder for view details functionality
  var modal = document.getElementById('transactionModal');
  if (modal) {
    var bsModal = new bootstrap.Modal(modal);
    bsModal.show();
  }
}
</script>

<!-- transactions management -->