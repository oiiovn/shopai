document.addEventListener('DOMContentLoaded', function() {
  console.log('Shopee Checker JavaScript loaded');
  
  // App state
  var currentPage = 1;
  var totalPages = 1;
  var totalItems = 0;
  var itemsPerPage = 5;
  var currentStatusFilter = '';
  var currentSearch = '';

  // DOM elements
  var usernameInput = document.getElementById('usernameInput');
  var checkBtn = document.getElementById('checkBtn');
  var searchInput = document.getElementById('searchInput');
  var statusFilter = document.getElementById('statusFilter');
  var clearBtn = document.getElementById('clearBtn');
  var historyTableBody = document.getElementById('historyTableBody');
  var emptyState = document.getElementById('emptyState');
  var paginationContainer = document.getElementById('paginationContainer');

  console.log('DOM elements found:', {
    usernameInput: !!usernameInput,
    checkBtn: !!checkBtn,
    historyTableBody: !!historyTableBody,
    emptyState: !!emptyState
  });

  // Username validation regex
  var usernameRegex = /^[a-z0-9._-]{3,30}$/i;

  // Initialize app
  function init() {
    console.log('Initializing app...');
    loadCheckInfo();
    loadHistory();
    setupEventListeners();
  }

  // Setup event listeners
  function setupEventListeners() {
    usernameInput.addEventListener('input', validateInput);
    checkBtn.addEventListener('click', handleCheck);
    searchInput.addEventListener('input', debounce(filterHistory, 300));
    statusFilter.addEventListener('change', filterHistory);
    clearBtn.addEventListener('click', clearHistory);
  }

  // Debounce function for search
  function debounce(func, wait) {
    var timeout;
    return function executedFunction() {
      var later = function() {
        clearTimeout(timeout);
        func();
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  }

  // Validate username input
  function validateInput() {
    var username = usernameInput.value.trim();
    var isValid = usernameRegex.test(username);
    
    usernameInput.classList.toggle('is-invalid', !isValid && username.length > 0);
    checkBtn.disabled = !isValid;
    
    if (username.length === 0) {
      usernameInput.classList.remove('is-invalid');
    }
  }

  // Handle check button click
  function handleCheck() {
    var username = usernameInput.value.trim().toLowerCase();
    
    if (!usernameRegex.test(username)) {
      return;
    }

    // Disable button and clear input
    checkBtn.disabled = true;
    usernameInput.value = '';
    usernameInput.classList.remove('is-invalid');
    
    // Call API to check phone
    checkPhoneAPI(username);
  }

  // Call API to check phone and wait for real response
  function checkPhoneAPI(username) {
    // Show loading state
    checkBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang check...';
    checkBtn.disabled = true;
    
    fetch('includes/ajax/phone-check-history.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        action: 'check_phone_api',
        user_id: 1,
        username: username
      })
    })
    .then(response => response.json())
    .then(data => {
      console.log('API Response:', data);
      
      if (data.success && data.status === 'success') {
        // Success - show result with payment info
        var message = '✅ Check thành công!\n' +
                     'Số điện thoại: ' + data.phone + '\n' +
                     'Username: ' + data.username + '\n' +
                     'Phí check: ' + (data.check_price ? new Intl.NumberFormat('vi-VN').format(data.check_price) + ' VNĐ' : 'N/A') + '\n' +
                     'Số dư mới: ' + (data.new_balance ? new Intl.NumberFormat('vi-VN').format(data.new_balance) + ' VNĐ' : 'N/A');
        alert(message);
        // Reload history to show new result
        loadHistory();
      } else if (data.success === false) {
        // Not found or error - check if it's balance issue
        if (data.required_amount) {
          // Insufficient balance
          var balanceMessage = '❌ Số dư không đủ!\n' +
                              'Cần: ' + new Intl.NumberFormat('vi-VN').format(data.required_amount) + ' VNĐ\n' +
                              'Hiện có: ' + new Intl.NumberFormat('vi-VN').format(data.current_balance) + ' VNĐ\n\n' +
                              'Vui lòng nạp tiền để tiếp tục check số.';
          alert(balanceMessage);
        } else {
          // Check failed but refunded
          var refundMessage = '❌ ' + data.message;
          if (data.refund_amount) {
            refundMessage += '\n\n💰 Đã hoàn tiền: ' + new Intl.NumberFormat('vi-VN').format(data.refund_amount) + ' VNĐ';
          }
          alert(refundMessage);
        }
        // Still reload history to show the attempt
        loadHistory();
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Có lỗi xảy ra khi check số: ' + error.message);
    })
    .finally(() => {
      // Reset button state
      checkBtn.innerHTML = '<i class="fa fa-search"></i> Check Số';
      checkBtn.disabled = false;
    });
  }


  // Create history row HTML
  function createHistoryRow(item) {
    var row = document.createElement('tr');
    row.id = 'row_' + item.id;
    row.className = 'history-item';
    
    var time = new Date(item.created_at);
    var timeStr = time.toLocaleTimeString('vi-VN', { 
      hour: '2-digit', 
      minute: '2-digit', 
      second: '2-digit' 
    });
    var dateStr = time.toLocaleDateString('vi-VN');
    
    row.innerHTML = '<td><div><div style="font-weight: 600;">' + timeStr + '</div><div style="font-size: 12px; color: #6c757d;">' + dateStr + '</div></div></td><td><strong>' + item.checked_username + '</strong></td><td class="status-cell">' + createStatusBadge(item.status, item.status === 'pending') + '</td><td class="phone-cell">' + (item.phone ? '<span class="phone-number">' + item.phone + '</span>' : '-') + '</td><td class="note-cell"><span class="note-text">' + item.result_message + '</span></td>';
    
    return row;
  }

  // Create status badge HTML
  function createStatusBadge(status, isLoading) {
    var badges = {
      pending: {
        text: 'Đang chờ API...',
        class: 'pending',
        icon: '<i class="fa fa-spinner fa-spin"></i>'
      },
      success: {
        text: 'Thành công',
        class: 'success',
        icon: '<i class="fa fa-check"></i>'
      },
      not_found: {
        text: 'Không tìm thấy',
        class: 'not_found',
        icon: '<i class="fa fa-user-times"></i>'
      },
      error: {
        text: 'Lỗi API',
        class: 'error',
        icon: '<i class="fa fa-exclamation-triangle"></i>'
      }
    };
    
    var badge = badges[status] || badges.pending;
    return '<span class="status-badge ' + badge.class + '">' + badge.icon + ' ' + badge.text + '</span>';
  }

  // Filter history
  function filterHistory() {
    currentSearch = searchInput.value.trim();
    currentStatusFilter = statusFilter.value;
    currentPage = 1;
    loadHistory(1);
  }

  // Render history table
  function renderHistory(historyItems) {
    console.log('Rendering history with', historyItems.length, 'items');
    
    if (!historyTableBody) {
      console.error('historyTableBody not found!');
      return;
    }
    
    historyTableBody.innerHTML = '';
    
    if (historyItems.length === 0) {
      console.log('No items, showing empty state');
      if (emptyState) {
        emptyState.style.display = 'block';
      }
      return;
    }
    
    console.log('Hiding empty state, rendering items');
    if (emptyState) {
      emptyState.style.display = 'none';
    }
    
    historyItems.forEach(function(item, index) {
      console.log('Rendering item', index, ':', item);
      var row = createHistoryRow(item);
      historyTableBody.appendChild(row);
    });
  }

  // Update pagination
  function updatePagination(pagination) {
    totalPages = pagination.total_pages;
    totalItems = pagination.total_items;
    
    if (!paginationContainer) {
      createPaginationContainer();
    }
    
    renderPagination();
  }

  // Create pagination container
  function createPaginationContainer() {
    paginationContainer = document.createElement('div');
    paginationContainer.id = 'paginationContainer';
    paginationContainer.className = 'pagination-container mt-3';
    
    var historySection = document.querySelector('.history-section');
    historySection.appendChild(paginationContainer);
  }

  // Render pagination
  function renderPagination() {
    if (totalPages <= 1) {
      paginationContainer.innerHTML = '';
      return;
    }
    
    var html = '<nav><ul class="pagination justify-content-center">';
    
    // Previous button
    if (currentPage > 1) {
      html += '<li class="page-item"><a class="page-link" href="#" data-page="' + (currentPage - 1) + '">Trước</a></li>';
    }
    
    // Page numbers
    var startPage = Math.max(1, currentPage - 2);
    var endPage = Math.min(totalPages, currentPage + 2);
    
    for (var i = startPage; i <= endPage; i++) {
      var activeClass = i === currentPage ? 'active' : '';
      html += '<li class="page-item ' + activeClass + '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
    }
    
    // Next button
    if (currentPage < totalPages) {
      html += '<li class="page-item"><a class="page-link" href="#" data-page="' + (currentPage + 1) + '">Sau</a></li>';
    }
    
    html += '</ul></nav>';
    
    paginationContainer.innerHTML = html;
    
    // Add click listeners
    paginationContainer.addEventListener('click', function(e) {
      e.preventDefault();
      if (e.target.classList.contains('page-link')) {
        var page = parseInt(e.target.dataset.page);
        if (page && page !== currentPage) {
          loadHistory(page);
        }
      }
    });
  }

  // Clear history
  function clearHistory() {
    if (confirm('Bạn có chắc muốn xóa toàn bộ lịch sử?')) {
      // TODO: Implement clear history API
      alert('Tính năng xóa lịch sử sẽ được thêm sau');
    }
  }

  // Load history from API
  function loadHistory(page) {
    if (typeof page === 'undefined') page = 1;
    currentPage = page;
    
    console.log('Loading history, page:', currentPage);
    
    fetch('includes/ajax/phone-check-history.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        action: 'get_history',
        user_id: 1,
        page: currentPage,
        limit: itemsPerPage,
        status_filter: currentStatusFilter,
        search: currentSearch
      })
    })
    .then(response => {
      console.log('Response status:', response.status);
      return response.json();
    })
    .then(data => {
      console.log('History data received:', data);
      if (data.success) {
        renderHistory(data.data);
        updatePagination(data.pagination);
      } else {
        console.error('Error loading history:', data.message);
        renderHistory([]);
      }
    })
    .catch(error => {
      console.error('Fetch error:', error);
      renderHistory([]);
    });
  }

  // Initialize
  init();
});
