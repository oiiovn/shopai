<div class="card-header bg-transparent">
  <strong><i class="fa fa-money-bill-wave mr-2"></i>{__("Rút Tiền")}</strong>
</div>
<div class="card-body">
  
  {if $pending_withdrawal}
    <!-- Đang có withdrawal pending -->
    <div class="alert alert-warning">
      <h5><i class="fa fa-clock mr-2"></i>Bạn đang có yêu cầu rút tiền đang xử lý</h5>
      <p class="mb-2">Mã QR: <code class="badge badge-primary">{$pending_withdrawal.qr_code}</code></p>
      <p class="mb-2">Số tiền: <strong>{($pending_withdrawal.amount - $pending_withdrawal.fee)|number_format:0} VNĐ</strong></p>
      <p class="mb-2">
        Hết hạn: <span class="countdown-wd text-danger font-weight-bold" data-expires="{$pending_withdrawal.expires_at}"></span>
      </p>
      <p class="mb-2">
        <small class="text-muted">Admin sẽ xử lý yêu cầu trong vòng 15 phút. Vui lòng chờ...</small>
      </p>
      <button class="btn btn-sm btn-danger" onclick="cancelWithdrawal('{$pending_withdrawal.qr_code}')">
        <i class="fa fa-times mr-1"></i>Hủy Yêu Cầu
      </button>
    </div>
  {else}
    <!-- No pending withdrawal - Show form -->
    
    <!-- Số dư hiện tại -->
    <div class="alert alert-info text-center mb-4">
      <h4 class="mb-0">
        <i class="fa fa-wallet mr-2"></i>
        Số dư: <strong class="text-primary">{number_format($current_balance, 0, ',', '.')} VNĐ</strong>
      </h4>
    </div>

    {if !$user_banks || $user_banks|count == 0}
      <!-- No bank accounts -->
      <div class="alert alert-danger text-center">
        <i class="fa fa-exclamation-triangle fa-2x mb-3"></i>
        <h5>Bạn chưa thêm tài khoản ngân hàng</h5>
        <p>Vui lòng thêm tài khoản ngân hàng trước khi rút tiền</p>
        <a href="{$system['system_url']}/shop-ai/bank-accounts" class="btn btn-primary">
          <i class="fa fa-plus-circle mr-2"></i>Thêm Ngân Hàng
        </a>
      </div>
    {else}
      <!-- Withdrawal Form -->
      <form id="withdrawalForm">
        <div class="row justify-content-center">
          <div class="col-md-8">
            
            <div class="form-group">
              <label>Chọn tài khoản ngân hàng <span class="text-danger">*</span></label>
              <select class="form-control" name="account_id" id="withdrawalBank" required>
                <option value="">-- Chọn tài khoản --</option>
                {foreach $user_banks as $bank}
                  <option value="{$bank.account_id}" {if $bank.is_default}selected{/if}>
                    {$bank.bank_name} - {$bank.account_number} {if $bank.is_default}(Mặc định){/if}
                  </option>
                {/foreach}
              </select>
            </div>

            <div class="form-group">
              <label>Số tiền rút <span class="text-danger">*</span></label>
              <input type="number" class="form-control" name="amount" id="withdrawalAmount" 
                     min="50000" max="{$current_balance}" step="1000" 
                     placeholder="Tối thiểu 50,000 VNĐ" required>
              <small class="text-muted">Min: 50,000 VNĐ | Max: {number_format($current_balance, 0)} VNĐ</small>
            </div>

            <!-- Preview -->
            <div class="card bg-light mb-3" id="withdrawalPreview" style="display:none;">
              <div class="card-body">
                <h6>Preview Rút Tiền:</h6>
                <div class="row">
                  <div class="col-6">
                    <p class="mb-1">Số tiền rút: <strong id="previewAmount"></strong></p>
                    <p class="mb-1">Phí (1%): <strong class="text-danger" id="previewFee"></strong></p>
                  </div>
                  <div class="col-6">
                    <p class="mb-1">Bạn nhận: <strong class="text-success" id="previewActual"></strong></p>
                    <p class="mb-1">Số dư sau: <strong id="previewBalance"></strong></p>
                  </div>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-success btn-block btn-lg" id="withdrawButton">
              <i class="fa fa-paper-plane mr-2"></i>Tạo Yêu Cầu Rút Tiền
            </button>
          </div>
        </div>
      </form>
    {/if}
    
  {/if}
</div>

<script>
{literal}
var currentBalance = {/literal}{$current_balance}{literal};

function numberFormat(num) {
  return new Intl.NumberFormat('vi-VN').format(num);
}

// Calculate preview
var amountInput = document.getElementById('withdrawalAmount');
if (amountInput) {
  amountInput.addEventListener('input', function() {
    var amount = parseFloat(this.value) || 0;
    var fee = amount * 0.01;
    var actual = amount - fee;
    var remaining = currentBalance - amount;
    
    var preview = document.getElementById('withdrawalPreview');
    if (amount > 0 && preview) {
      preview.style.display = 'block';
      document.getElementById('previewAmount').textContent = numberFormat(amount) + ' VNĐ';
      document.getElementById('previewFee').textContent = numberFormat(fee) + ' VNĐ';
      document.getElementById('previewActual').textContent = numberFormat(actual) + ' VNĐ';
      document.getElementById('previewBalance').textContent = numberFormat(remaining) + ' VNĐ';
    } else if (preview) {
      preview.style.display = 'none';
    }
  });
}

// Submit withdrawal
var withdrawForm = document.getElementById('withdrawalForm');
if (withdrawForm) {
  withdrawForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    var formData = new FormData(this);
    var amount = parseFloat(formData.get('amount'));
    var accountId = formData.get('account_id');
    
    if (!accountId) {
      alert('Vui lòng chọn tài khoản ngân hàng');
      return;
    }
    
    if (amount < 50000) {
      alert('Số tiền tối thiểu 50,000 VNĐ');
      return;
    }
    
    if (amount > currentBalance) {
      alert('Số dư không đủ!');
      return;
    }
    
    if (!confirm('Xác nhận rút ' + numberFormat(amount) + ' VNĐ?\nPhí: ' + numberFormat(amount * 0.01) + ' VNĐ\nBạn nhận: ' + numberFormat(amount * 0.99) + ' VNĐ')) {
      return;
    }
    
    var button = document.getElementById('withdrawButton');
    button.disabled = true;
    button.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i>Đang xử lý...';
    
    fetch('{/literal}{$system['system_url']}{literal}/shop-ai.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        action: 'create_withdrawal',
        account_id: parseInt(accountId),
        amount: amount
      })
    })
    .then(response => response.json())
    .then(result => {
      if (result.success) {
        alert('✅ ' + result.message);
        location.reload();
      } else {
        alert('❌ ' + result.error);
        button.disabled = false;
        button.innerHTML = '<i class="fa fa-paper-plane mr-2"></i>Tạo Yêu Cầu Rút Tiền';
      }
    })
    .catch(error => {
      alert('❌ Lỗi: ' + error);
      button.disabled = false;
      button.innerHTML = '<i class="fa fa-paper-plane mr-2"></i>Tạo Yêu Cầu Rút Tiền';
    });
  });
}

// Cancel withdrawal
function cancelWithdrawal(qrCode) {
  if (!confirm('Bạn có chắc muốn hủy yêu cầu rút tiền này?\nSố dư sẽ được hoàn lại.')) return;
  
  fetch('{/literal}{$system['system_url']}{literal}/shop-ai.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      action: 'cancel_withdrawal',
      qr_code: qrCode
    })
  })
  .then(response => response.json())
  .then(result => {
    if (result.success) {
      alert('✅ ' + result.message);
      location.reload();
    } else {
      alert('❌ ' + result.error);
    }
  })
  .catch(error => {
    alert('❌ Lỗi: ' + error);
  });
}

// Countdown for pending withdrawal
var countdownEl = document.querySelector('.countdown-wd');
if (countdownEl) {
  setInterval(function() {
    var expires = countdownEl.getAttribute('data-expires');
    var now = new Date().getTime();
    var expiresTime = new Date(expires).getTime();
    var timeLeft = Math.floor((expiresTime - now) / 1000);
    
    if (timeLeft <= 0) {
      countdownEl.textContent = 'Đã hết hạn - Tải lại trang';
      countdownEl.classList.add('text-danger');
    } else {
      var minutes = Math.floor(timeLeft / 60);
      var seconds = timeLeft % 60;
      countdownEl.textContent = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
    }
  }, 1000);
}
{/literal}
</script>

