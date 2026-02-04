{include file='_head.tpl'}
{include file='_header.tpl'}

<style>
.escrow-create .card-form { border-radius: 1rem; overflow: hidden; border: 1px solid #e2e8f0; }
.escrow-create .card-form .card-header-dark { background: #0f172a; color: #fff; padding: 1.25rem 1.5rem; }
.escrow-create .card-form .card-header-dark h2 { font-size: 1.25rem; font-weight: 700; margin: 0; }
.escrow-create .card-form .card-header-dark .sub { color: #94a3b8; font-size: 0.875rem; margin-top: 0.25rem; }
.escrow-create .card-form .card-body { padding: 2rem; }
.escrow-create .input-rounded { border: 2px solid #f1f5f9; border-radius: 0.75rem; padding: 0.75rem 1rem; }
.escrow-create .input-rounded:focus { border-color: #3b82f6; outline: none; }
.escrow-create .fee-toggle { display: flex; gap: 0.5rem; padding: 0.25rem; background: #f1f5f9; border-radius: 0.75rem; }
.escrow-create .fee-toggle .btn-option { flex: 1; padding: 0.5rem 0.75rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; border: none; background: transparent; color: #64748b; }
.escrow-create .fee-toggle .btn-option:hover { background: #e2e8f0; color: #334155; }
.escrow-create .fee-toggle .btn-option.active { background: #fff; color: #2563eb; font-weight: 700; box-shadow: 0 1px 2px rgba(0,0,0,.05); }
.escrow-create .criteria-row { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; }
.escrow-create .criteria-num { width: 2rem; height: 2rem; border-radius: 50%; background: #3b82f6; color: #fff; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.escrow-create .criteria-input { flex: 1; border: none; border-bottom: 2px solid #f1f5f9; padding: 0.5rem 0; outline: none; font-size: 0.875rem; }
.escrow-create .criteria-input:focus { border-color: #93c5fd; }
.escrow-create .criteria-del { color: #cbd5e1; background: none; border: none; padding: 0.25rem; opacity: 0; transition: opacity .2s; }
.escrow-create .criteria-row:hover .criteria-del { opacity: 1; }
.escrow-create .criteria-del:hover { color: #ef4444; }
.escrow-create .sidebar-summary { background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%); color: #fff; border-radius: 1rem; padding: 1.5rem; position: relative; overflow: hidden; }
.escrow-create .sidebar-summary .watermark { position: absolute; right: -0.5rem; top: -0.5rem; font-size: 4rem; font-weight: 800; opacity: 0.1; font-style: italic; }
.escrow-create .sidebar-summary h3 { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.8; margin-bottom: 1rem; }
.escrow-create .sidebar-summary .total-line { display: flex; justify-content: space-between; align-items: flex-end; border-bottom: 1px solid rgba(255,255,255,.2); padding-bottom: 0.5rem; margin-bottom: 1rem; }
.escrow-create .sidebar-summary .total-line .val { font-size: 1.25rem; font-weight: 700; font-style: italic; }
.escrow-create .sidebar-summary .steps { font-size: 0.75rem; opacity: 0.85; }
.escrow-create .sidebar-summary .steps li { margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem; }
.escrow-create .tip-box { background: #fffbeb; border: 1px solid #fcd34d; border-radius: 1rem; padding: 1rem; }
.escrow-create .tip-box .tip-title { color: #b45309; font-weight: 700; font-size: 0.875rem; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem; }
.escrow-create .tip-box .tip-text { font-size: 0.75rem; color: #92400e; line-height: 1.5; }
.escrow-create .btn-submit { width: 100%; padding: 1rem; font-weight: 700; border-radius: 0.75rem; background: #2563eb; border: none; color: #fff; box-shadow: 0 4px 14px rgba(37,99,235,.3); transition: all .2s; }
.escrow-create .btn-submit:hover { background: #1d4ed8; transform: translateY(-1px); color: #fff; }
.gdtg-tabs-bar { background: #f1f5f9; border-radius: 12px; padding: 6px; box-shadow: 0 1px 3px rgba(0,0,0,.06); }
.gdtg-tabs { display: flex; flex-wrap: wrap; gap: 4px; border: none; }
.gdtg-tabs .nav-link { border: none; border-radius: 10px; padding: 0.65rem 1.1rem; font-weight: 500; color: #64748b; transition: background .2s, color .2s; }
.gdtg-tabs .nav-link:hover { color: #1e40af; background: rgba(255,255,255,.9); }
.gdtg-tabs .nav-link.active { background: #2563eb; color: #fff; font-weight: 600; }
.gdtg-tabs-ico { margin-right: 0.4rem; opacity: .9; }
@media (max-width: 575px) { .gdtg-tabs .nav-link { padding: 0.5rem 0.75rem; font-size: 0.9rem; } .gdtg-tabs-ico { margin-right: 0.25rem; } }
</style>

<div class="{if $system['fluid_design']}container-fluid{else}container{/if} mt20 sg-offcanvas escrow-create">
  <div class="row">
    <div class="col-12 d-block d-md-none sg-offcanvas-sidebar mt10">
      {include file='_sidebar.tpl'}
    </div>
    <div class="col-12 sg-offcanvas-mainbar">
      <div class="gdtg-tabs-bar mb-4">
        <nav class="gdtg-tabs nav nav-fill" role="tablist">
          <a class="nav-link" href="{$system['system_url']}/giao-dich-trung-gian"><i class="fa fa-info-circle gdtg-tabs-ico"></i> Giới thiệu</a>
          <a class="nav-link" href="{$system['system_url']}/giao-dich-trung-gian/list"><i class="fa fa-list-ul gdtg-tabs-ico"></i> Danh sách giao dịch</a>
          <a class="nav-link active" href="{$system['system_url']}/giao-dich-trung-gian/create"><i class="fa fa-plus-circle gdtg-tabs-ico"></i> Tạo giao dịch</a>
        </nav>
      </div>

      <div class="row">
        <div class="col-12 col-lg-8">
          <div class="card shadow-sm card-form mb-4">
            <div class="card-header-dark">
              <h2><i class="fas fa-file-contract mr2" style="color:#60a5fa;"></i> Tạo Giao Dịch Trung Gian Mới</h2>
              <p class="sub">Thiết lập các điều khoản chặt chẽ để bảo vệ quyền lợi của bạn.</p>
            </div>
            <div class="card-body">
              <form id="js-escrow-create-form">
                <div class="row mb-4">
                  <div class="col-md-6 mb-3">
                    <label class="d-block small font-weight-bold text-secondary mb-2">Tên giao dịch <span class="text-danger">*</span></label>
                    <input type="text" class="form-control input-rounded w-100" id="title" name="title" placeholder="Ví dụ: Bán tài khoản Canva Pro 1 năm" required maxlength="500">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="d-block small font-weight-bold text-secondary mb-2">Giá trị (VND) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control input-rounded w-100 font-weight-bold text-success" id="amount" name="amount" placeholder="500000" value="500000" required>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-md-6 mb-3 position-relative">
                    <label class="d-block small font-weight-bold text-secondary mb-2">Username người mua <span class="text-danger">*</span></label>
                    <input type="text" class="form-control input-rounded w-100" id="buyer_username" name="buyer_username" placeholder="Gõ username hoặc tên để tìm..." required autocomplete="off">
                    <div id="buyer-suggest-list" class="list-group position-absolute w-100 shadow-sm border rounded mt-1" style="z-index:100; max-height:220px; overflow-y:auto; display:none;"></div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="d-block small font-weight-bold text-secondary mb-2">Phí trung gian do ai trả?</label>
                    <div class="fee-toggle">
                      <button type="button" class="btn-option active" data-value="buyer">Bên Mua</button>
                      <button type="button" class="btn-option" data-value="seller">Bên Bán</button>
                      <button type="button" class="btn-option" data-value="split">Chia đôi</button>
                    </div>
                    <input type="hidden" name="fee_payer" id="fee_payer" value="buyer">
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-12 col-md-6 mb-3">
                    <label class="d-block small font-weight-bold text-secondary mb-2">Thời gian kiểm tra</label>
                    <select class="form-control input-rounded w-100" name="inspection_hours" id="inspection_hours">
                      <option value="12">12 giờ (Giao dịch nhanh)</option>
                      <option value="24" selected>24 giờ (Tiêu chuẩn)</option>
                      <option value="48">48 giờ (An toàn cao)</option>
                    </select>
                  </div>
                </div>

                <hr class="border-light my-4">

                <div class="mb-4">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <label class="small font-weight-bold text-dark border-bottom border-primary pb-1">Điều kiện để giải ngân</label>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill js-add-condition"><i class="fas fa-plus mr1"></i> Thêm điều kiện</button>
                  </div>
                  <div id="criteria-list">
                    <div class="criteria-row group">
                      <span class="criteria-num">1</span>
                      <input type="text" class="criteria-input" placeholder="Đăng nhập được vào Email khôi phục gốc" data-name="cond">
                      <button type="button" class="criteria-del js-remove-condition" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                    </div>
                    <div class="criteria-row group">
                      <span class="criteria-num">2</span>
                      <input type="text" class="criteria-input" placeholder="Nhập điều kiện tiếp theo..." data-name="cond">
                      <button type="button" class="criteria-del js-remove-condition" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                    </div>
                  </div>
                  <p class="text-muted small mt-3 mb-0"><em>* Admin sẽ căn cứ vào các điều kiện này để phân xử khi có tranh chấp.</em></p>
                </div>

                <button type="submit" class="btn btn-submit" id="js-escrow-create-btn">
                  GỬI YÊU CẦU GIAO DỊCH <i class="fas fa-paper-plane ml2"></i>
                </button>
                <p class="text-danger small mt-2 mb-0" id="js-escrow-create-err"></p>
              </form>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-4">
          <div class="sidebar-summary mb-4">
            <span class="watermark">Escrow</span>
            <h3 class="relative">Tóm tắt hợp đồng</h3>
            <div class="total-line relative">
              <span class="small opacity-75">Tổng tiền bên mua trả:</span>
              <span class="val" id="js-summary-total">525.000 đ</span>
            </div>
            <div class="steps">
              <p class="small opacity-75 mb-2">Quy trình thực hiện:</p>
              <ul class="list-unstyled mb-0">
                <li><i class="fas fa-check-circle text-info"></i> Bên mua nạp tiền vào Escrow</li>
                <li><i class="fas fa-clock text-info"></i> Hệ thống khóa tiền</li>
                <li><i class="fas fa-truck text-info"></i> Bên bán giao thông mật</li>
                <li><i class="fas fa-shield-check text-info"></i> <span id="js-summary-hours">24</span>h kiểm tra và giải ngân</li>
              </ul>
            </div>
          </div>
          <div class="tip-box">
            <div class="tip-title"><i class="fas fa-lightbulb"></i> Mẹo an toàn</div>
            <p class="tip-text mb-0">Nên ghi rõ: <b>"Cần video quay màn hình lúc nhận acc"</b> trong phần điều kiện để tránh việc bên mua đổi pass rồi báo không vào được.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
(function() {
  var baseUrl = '{$system["system_url"]}';
  var feePercent = 5;

  function formatNum(n) {
    return Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' đ';
  }

  function updateSummary() {
    var amount = parseFloat(document.getElementById('amount').value.replace(/\s|\.|,/g, '')) || 0;
    var fp = document.getElementById('fee_payer').value;
    var fee = amount * feePercent / 100;
    var total = amount;
    if (fp === 'buyer') total = amount + fee;
    else if (fp === 'split') total = amount + fee / 2;
    document.getElementById('js-summary-total').textContent = formatNum(total);
    var hours = document.getElementById('inspection_hours').value;
    document.getElementById('js-summary-hours').textContent = hours;
  }

  document.getElementById('amount').addEventListener('input', updateSummary);
  document.getElementById('amount').addEventListener('change', updateSummary);
  document.getElementById('inspection_hours').addEventListener('change', updateSummary);

  (function() {
    var input = document.getElementById('buyer_username');
    var listEl = document.getElementById('buyer-suggest-list');
    var debounceTimer = null;
    var badgeUrl = '{$system["system_url"]}/content/themes/{$system["theme"]}/images/svg/verified_badge.svg';
    function showList(items) {
      listEl.innerHTML = '';
      if (items.length === 0) {
        listEl.style.display = 'none';
        return;
      }
      items.forEach(function(u) {
        var a = document.createElement('a');
        a.href = '#';
        a.className = 'list-group-item list-group-item-action list-group-item-light py-2 d-flex align-items-center';
        a.dataset.username = u.user_name;
        var avatar = document.createElement('img');
        avatar.src = u.avatar || '';
        avatar.alt = '';
        avatar.className = 'rounded-circle flex-shrink-0';
        avatar.style.width = '28px';
        avatar.style.height = '28px';
        avatar.style.objectFit = 'cover';
        avatar.style.marginRight = '10px';
        var text = document.createElement('span');
        text.className = 'small text-dark';
        text.style.marginRight = '6px';
        text.appendChild(document.createTextNode(u.display_name));
        if (u.user_verified) {
          var tick = document.createElement('img');
          tick.src = badgeUrl;
          tick.alt = '';
          tick.style.width = '14px';
          tick.style.height = '14px';
          tick.style.verticalAlign = 'middle';
          tick.style.marginLeft = '4px';
          tick.style.marginRight = '6px';
          text.appendChild(tick);
        }
        text.appendChild(document.createTextNode('@' + u.user_name));
        a.appendChild(avatar);
        a.appendChild(text);
        a.addEventListener('click', function(e) {
          e.preventDefault();
          input.value = u.user_name;
          listEl.style.display = 'none';
        });
        listEl.appendChild(a);
      });
      listEl.style.display = 'block';
    }
    function search() {
      var q = input.value.trim();
      if (q.length < 1) {
        listEl.style.display = 'none';
        return;
      }
      fetch(baseUrl + '/includes/ajax/escrow-transaction.php?action=search_buyer&q=' + encodeURIComponent(q), { credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(function(r) { return r.json(); })
        .then(function(data) {
          if (data && data.list) showList(data.list);
        })
        .catch(function() { listEl.style.display = 'none'; });
    }
    input.addEventListener('input', function() {
      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(search, 280);
    });
    input.addEventListener('focus', function() {
      if (input.value.trim().length >= 1) search();
    });
    input.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') listEl.style.display = 'none';
    });
    document.addEventListener('click', function(e) {
      if (e.target !== input && !listEl.contains(e.target)) listEl.style.display = 'none';
    });
  })();

  document.querySelectorAll('.fee-toggle .btn-option').forEach(function(btn) {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.fee-toggle .btn-option').forEach(function(b) { b.classList.remove('active'); });
      this.classList.add('active');
      document.getElementById('fee_payer').value = this.getAttribute('data-value');
      updateSummary();
    });
  });

  function renumberCriteria() {
    document.querySelectorAll('#criteria-list .criteria-row').forEach(function(row, i) {
      row.querySelector('.criteria-num').textContent = i + 1;
    });
  }

  document.querySelector('.js-add-condition').addEventListener('click', function() {
    var list = document.getElementById('criteria-list');
    var n = list.querySelectorAll('.criteria-row').length + 1;
    var div = document.createElement('div');
    div.className = 'criteria-row group';
    div.innerHTML = '<span class="criteria-num">' + n + '</span><input type="text" class="criteria-input" placeholder="Nhập điều kiện..." data-name="cond"><button type="button" class="criteria-del js-remove-condition" title="Xóa"><i class="fas fa-trash-alt"></i></button>';
    list.appendChild(div);
    div.querySelector('.js-remove-condition').addEventListener('click', function() {
      div.remove();
      renumberCriteria();
    });
  });

  document.querySelectorAll('#criteria-list .js-remove-condition').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var row = this.closest('.criteria-row');
      if (document.querySelectorAll('#criteria-list .criteria-row').length <= 1) return;
      row.remove();
      renumberCriteria();
    });
  });

  updateSummary();

  var form = document.getElementById('js-escrow-create-form');
  var btn = document.getElementById('js-escrow-create-btn');
  var errEl = document.getElementById('js-escrow-create-err');
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    errEl.textContent = '';
    var conditions = [];
    document.querySelectorAll('#criteria-list .criteria-input').forEach(function(inp) {
      var v = inp.value.trim();
      if (v) conditions.push(v);
    });
    btn.disabled = true;
    var fd = new FormData();
    fd.append('action', 'create');
    fd.append('title', document.getElementById('title').value);
    fd.append('amount', document.getElementById('amount').value.replace(/\s|\.|,/g, ''));
    fd.append('buyer_username', document.getElementById('buyer_username').value.trim());
    fd.append('conditions', conditions.join('\n'));
    fd.append('fee_payer', document.getElementById('fee_payer').value);
    fd.append('inspection_hours', document.getElementById('inspection_hours').value);
    fetch(baseUrl + '/includes/ajax/escrow-transaction.php', {
      method: 'POST',
      body: fd,
      credentials: 'same-origin',
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
      .then(function(r) { return r.json(); })
      .then(function(data) {
        btn.disabled = false;
        if (data.success && data.transaction_id) {
          window.location.href = baseUrl + '/giao-dich-trung-gian/detail/' + data.transaction_id;
        } else {
          errEl.textContent = data.message || 'Có lỗi. Thử lại.';
        }
      })
      .catch(function() {
        btn.disabled = false;
        errEl.textContent = 'Lỗi kết nối.';
      });
  });
})();
</script>

{include file='_footer.tpl'}
