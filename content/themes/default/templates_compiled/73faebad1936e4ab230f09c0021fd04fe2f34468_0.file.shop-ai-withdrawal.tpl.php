<?php
/* Smarty version 4.3.4, created on 2025-10-11 15:42:22
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/shop-ai-withdrawal.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68ea7ade9c1558_98580986',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '73faebad1936e4ab230f09c0021fd04fe2f34468' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/shop-ai-withdrawal.tpl',
      1 => 1760197103,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68ea7ade9c1558_98580986 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),1=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.count.php','function'=>'smarty_modifier_count',),));
?>
<div class="card-header bg-transparent">
  <strong><i class="fa fa-money-bill-wave mr-2"></i><?php echo __("Rút Tiền");?>
</strong>
</div>
<div class="card-body">
  
  <?php if ($_smarty_tpl->tpl_vars['pending_withdrawal']->value) {?>
    <!-- Đang có withdrawal pending -->
    <div class="alert alert-warning">
      <h5><i class="fa fa-clock mr-2"></i>Bạn đang có yêu cầu rút tiền đang xử lý</h5>
      <p class="mb-2">Mã QR: <code class="badge badge-primary"><?php echo $_smarty_tpl->tpl_vars['pending_withdrawal']->value['qr_code'];?>
</code></p>
      <p class="mb-2">Số tiền: <strong><?php echo smarty_modifier_number_format(($_smarty_tpl->tpl_vars['pending_withdrawal']->value['amount']-$_smarty_tpl->tpl_vars['pending_withdrawal']->value['fee']),0);?>
 VNĐ</strong></p>
      <p class="mb-2">
        Hết hạn: <span class="countdown-wd text-danger font-weight-bold" data-expires="<?php echo $_smarty_tpl->tpl_vars['pending_withdrawal']->value['expires_at'];?>
"></span>
      </p>
      <p class="mb-2">
        <small class="text-muted">Admin sẽ xử lý yêu cầu trong vòng 15 phút. Vui lòng chờ...</small>
      </p>
      <button class="btn btn-sm btn-danger" onclick="cancelWithdrawal('<?php echo $_smarty_tpl->tpl_vars['pending_withdrawal']->value['qr_code'];?>
')">
        <i class="fa fa-times mr-1"></i>Hủy Yêu Cầu
      </button>
    </div>
  <?php } else { ?>
    <!-- No pending withdrawal - Show form -->
    
    <!-- Số dư hiện tại -->
    <div class="alert alert-info text-center mb-4">
      <h4 class="mb-0">
        <i class="fa fa-wallet mr-2"></i>
        Số dư: <strong class="text-primary"><?php echo number_format($_smarty_tpl->tpl_vars['current_balance']->value,0,',','.');?>
 VNĐ</strong>
      </h4>
    </div>

    <?php if (!$_smarty_tpl->tpl_vars['user_banks']->value || smarty_modifier_count($_smarty_tpl->tpl_vars['user_banks']->value) == 0) {?>
      <!-- No bank accounts -->
      <div class="alert alert-danger text-center">
        <i class="fa fa-exclamation-triangle fa-2x mb-3"></i>
        <h5>Bạn chưa thêm tài khoản ngân hàng</h5>
        <p>Vui lòng thêm tài khoản ngân hàng trước khi rút tiền</p>
        <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/shop-ai/bank-accounts" class="btn btn-primary">
          <i class="fa fa-plus-circle mr-2"></i>Thêm Ngân Hàng
        </a>
      </div>
    <?php } else { ?>
      <!-- Withdrawal Form -->
      <form id="withdrawalForm">
        <div class="row justify-content-center">
          <div class="col-md-8">
            
            <div class="form-group">
              <label>Chọn tài khoản ngân hàng <span class="text-danger">*</span></label>
              <select class="form-control" name="account_id" id="withdrawalBank" required>
                <option value="">-- Chọn tài khoản --</option>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['user_banks']->value, 'bank');
$_smarty_tpl->tpl_vars['bank']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['bank']->value) {
$_smarty_tpl->tpl_vars['bank']->do_else = false;
?>
                  <option value="<?php echo $_smarty_tpl->tpl_vars['bank']->value['account_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['bank']->value['is_default']) {?>selected<?php }?>>
                    <?php echo $_smarty_tpl->tpl_vars['bank']->value['bank_name'];?>
 - <?php echo $_smarty_tpl->tpl_vars['bank']->value['account_number'];?>
 <?php if ($_smarty_tpl->tpl_vars['bank']->value['is_default']) {?>(Mặc định)<?php }?>
                  </option>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
              </select>
            </div>

            <div class="form-group">
              <label>Số tiền rút <span class="text-danger">*</span></label>
              <input type="number" class="form-control" name="amount" id="withdrawalAmount" 
                     min="50000" max="<?php echo $_smarty_tpl->tpl_vars['current_balance']->value;?>
" step="1000" 
                     placeholder="Tối thiểu 50,000 VNĐ" required>
              <small class="text-muted">Min: 50,000 VNĐ | Max: <?php echo number_format($_smarty_tpl->tpl_vars['current_balance']->value,0);?>
 VNĐ</small>
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
    <?php }?>
    
  <?php }?>
</div>

<?php echo '<script'; ?>
>

var currentBalance = <?php echo $_smarty_tpl->tpl_vars['current_balance']->value;?>
;

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
    
    fetch('<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/shop-ai.php', {
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
  
  fetch('<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/shop-ai.php', {
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

<?php echo '</script'; ?>
>

<?php }
}
