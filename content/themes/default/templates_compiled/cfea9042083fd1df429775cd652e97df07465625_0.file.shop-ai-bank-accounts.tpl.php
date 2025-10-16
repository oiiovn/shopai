<?php
/* Smarty version 4.3.4, created on 2025-10-11 15:42:18
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/shop-ai-bank-accounts.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68ea7adad15313_14751286',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cfea9042083fd1df429775cd652e97df07465625' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/shop-ai-bank-accounts.tpl',
      1 => 1760197070,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68ea7adad15313_14751286 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.count.php','function'=>'smarty_modifier_count',),));
?>
<div class="card-header bg-transparent">
  <strong><i class="fa fa-university mr-2"></i><?php echo __("Quản Lý Ngân Hàng");?>
</strong>
</div>
<div class="card-body">
  
  <!-- Add Bank Form -->
  <div class="card mb-4">
    <div class="card-header bg-primary text-white">
      <i class="fa fa-plus-circle mr-2"></i>Thêm Tài Khoản Ngân Hàng
    </div>
    <div class="card-body">
      <form id="addBankForm">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Ngân hàng <span class="text-danger">*</span></label>
              <select class="form-control" name="bank_code" id="bankSelect" required>
                <option value="">-- Chọn ngân hàng --</option>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['vietnam_banks']->value, 'bank');
$_smarty_tpl->tpl_vars['bank']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['bank']->value) {
$_smarty_tpl->tpl_vars['bank']->do_else = false;
?>
                  <option value="<?php echo $_smarty_tpl->tpl_vars['bank']->value['bank_code'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['bank']->value['bank_name'];?>
">
                    <?php echo $_smarty_tpl->tpl_vars['bank']->value['short_name'];?>
 - <?php echo $_smarty_tpl->tpl_vars['bank']->value['bank_name'];?>

                  </option>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Số tài khoản <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="account_number" id="accountNumber" 
                     placeholder="Nhập 6-20 chữ số" pattern="[0-9]{6,20}" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Tên chủ tài khoản <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="account_holder" id="accountHolder" 
                     placeholder="VD: NGUYEN VAN A" style="text-transform: uppercase;" required>
              <small class="text-muted">Nhập chính xác theo CMND/CCCD (IN HOA)</small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Biệt danh (tùy chọn)</label>
              <input type="text" class="form-control" name="account_nickname" placeholder="VD: Tài khoản chính">
            </div>
          </div>
        </div>
        <input type="hidden" name="bank_name" id="bankName">
        <button type="submit" class="btn btn-primary">
          <i class="fa fa-save mr-2"></i>Thêm Tài Khoản
        </button>
      </form>
    </div>
  </div>

  <!-- List of Banks -->
  <div class="card">
    <div class="card-header">
      <i class="fa fa-list mr-2"></i>Danh Sách Tài Khoản Đã Lưu
      <?php if ($_smarty_tpl->tpl_vars['user_banks']->value) {?>
        <span class="badge badge-info ml-2"><?php echo smarty_modifier_count($_smarty_tpl->tpl_vars['user_banks']->value);?>
</span>
      <?php }?>
    </div>
    <div class="card-body">
      <?php if ($_smarty_tpl->tpl_vars['user_banks']->value) {?>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Ngân hàng</th>
                <th>Số TK</th>
                <th>Chủ TK</th>
                <th>Biệt danh</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
              <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['user_banks']->value, 'bank');
$_smarty_tpl->tpl_vars['bank']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['bank']->value) {
$_smarty_tpl->tpl_vars['bank']->do_else = false;
?>
                <tr>
                  <td>
                    <strong><?php echo $_smarty_tpl->tpl_vars['bank']->value['bank_name'];?>
</strong>
                    <br><small class="text-muted"><?php echo $_smarty_tpl->tpl_vars['bank']->value['bank_code'];?>
</small>
                  </td>
                  <td><code><?php echo $_smarty_tpl->tpl_vars['bank']->value['account_number'];?>
</code></td>
                  <td><strong><?php echo $_smarty_tpl->tpl_vars['bank']->value['account_holder'];?>
</strong></td>
                  <td><?php echo (($tmp = $_smarty_tpl->tpl_vars['bank']->value['account_nickname'] ?? null)===null||$tmp==='' ? '-' ?? null : $tmp);?>
</td>
                  <td>
                    <?php if ($_smarty_tpl->tpl_vars['bank']->value['is_default']) {?>
                      <span class="badge badge-success">Mặc định</span>
                    <?php } else { ?>
                      <button class="btn btn-sm btn-outline-primary" onclick="setDefaultBank(<?php echo $_smarty_tpl->tpl_vars['bank']->value['account_id'];?>
)">
                        Đặt mặc định
                      </button>
                    <?php }?>
                  </td>
                  <td>
                    <button class="btn btn-sm btn-danger" onclick="deleteBank(<?php echo $_smarty_tpl->tpl_vars['bank']->value['account_id'];?>
)">
                      <i class="fa fa-trash"></i>
                    </button>
                  </td>
                </tr>
              <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </tbody>
          </table>
        </div>
      <?php } else { ?>
        <div class="text-center py-5">
          <i class="fa fa-university fa-3x text-muted mb-3"></i>
          <h5>Chưa có tài khoản ngân hàng nào</h5>
          <p class="text-muted">Thêm tài khoản ngân hàng để có thể rút tiền</p>
        </div>
      <?php }?>
    </div>
  </div>
  
</div>

<?php echo '<script'; ?>
>

// Auto fill bank name
document.getElementById('bankSelect').addEventListener('change', function() {
  var selectedOption = this.options[this.selectedIndex];
  var bankName = selectedOption.getAttribute('data-name');
  document.getElementById('bankName').value = bankName || '';
});

// Auto uppercase account holder
document.getElementById('accountHolder').addEventListener('input', function() {
  this.value = this.value.toUpperCase();
});

// Add bank form
document.getElementById('addBankForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  var formData = new FormData(this);
  var data = {
    action: 'add_bank_account',
    bank_code: formData.get('bank_code'),
    bank_name: formData.get('bank_name'),
    account_number: formData.get('account_number'),
    account_holder: formData.get('account_holder'),
    account_nickname: formData.get('account_nickname')
  };
  
  fetch('<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/shop-ai.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
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
});

// Delete bank
function deleteBank(accountId) {
  if (!confirm('Bạn có chắc muốn xóa tài khoản ngân hàng này?')) return;
  
  fetch('<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/shop-ai.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      action: 'delete_bank_account',
      account_id: accountId
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
  });
}

// Set default bank
function setDefaultBank(accountId) {
  fetch('<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/shop-ai.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      action: 'set_default_bank',
      account_id: accountId
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
  });
}

<?php echo '</script'; ?>
>

<?php }
}
