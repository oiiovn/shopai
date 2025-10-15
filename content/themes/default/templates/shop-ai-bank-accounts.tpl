<div class="card-header bg-transparent">
  <strong><i class="fa fa-university mr-2"></i>{__("Quản Lý Ngân Hàng")}</strong>
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
                {foreach $vietnam_banks as $bank}
                  <option value="{$bank.bank_code}" data-name="{$bank.bank_name}">
                    {$bank.short_name} - {$bank.bank_name}
                  </option>
                {/foreach}
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Số tài khoản <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="account_number" id="accountNumber" 
                     placeholder="Nhập 6-20 chữ số" pattern="[0-9]{ldelim}6,20{rdelim}" required>
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
      {if $user_banks}
        <span class="badge badge-info ml-2">{$user_banks|count}</span>
      {/if}
    </div>
    <div class="card-body">
      {if $user_banks}
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
              {foreach $user_banks as $bank}
                <tr>
                  <td>
                    <strong>{$bank.bank_name}</strong>
                    <br><small class="text-muted">{$bank.bank_code}</small>
                  </td>
                  <td><code>{$bank.account_number}</code></td>
                  <td><strong>{$bank.account_holder}</strong></td>
                  <td>{$bank.account_nickname|default:'-'}</td>
                  <td>
                    {if $bank.is_default}
                      <span class="badge badge-success">Mặc định</span>
                    {else}
                      <button class="btn btn-sm btn-outline-primary" onclick="setDefaultBank({$bank.account_id})">
                        Đặt mặc định
                      </button>
                    {/if}
                  </td>
                  <td>
                    <button class="btn btn-sm btn-danger" onclick="deleteBank({$bank.account_id})">
                      <i class="fa fa-trash"></i>
                    </button>
                  </td>
                </tr>
              {/foreach}
            </tbody>
          </table>
        </div>
      {else}
        <div class="text-center py-5">
          <i class="fa fa-university fa-3x text-muted mb-3"></i>
          <h5>Chưa có tài khoản ngân hàng nào</h5>
          <p class="text-muted">Thêm tài khoản ngân hàng để có thể rút tiền</p>
        </div>
      {/if}
    </div>
  </div>
  
</div>

<script>
{literal}
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
  
  fetch('{/literal}{$system['system_url']}{literal}/shop-ai.php', {
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
  
  fetch('{/literal}{$system['system_url']}{literal}/shop-ai.php', {
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
  fetch('{/literal}{$system['system_url']}{literal}/shop-ai.php', {
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
{/literal}
</script>

