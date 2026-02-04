<?php
/* Smarty version 4.3.4, created on 2026-02-04 05:52:22
  from '/Applications/XAMPP/xamppfiles/htdocs/shop-ai.vn/public_html/content/themes/default/templates/giao-dich-trung-gian.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_6982de9652b6a2_65603966',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5c9b0feb4750a25488bf61a24fa3195a9df7f6fa' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/shop-ai.vn/public_html/content/themes/default/templates/giao-dich-trung-gian.tpl',
      1 => 1770184333,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_head.tpl' => 1,
    'file:_header.tpl' => 1,
    'file:_sidebar.tpl' => 1,
    'file:_footer.tpl' => 1,
  ),
),false)) {
function content_6982de9652b6a2_65603966 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:_head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender('file:_header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="<?php if ($_smarty_tpl->tpl_vars['system']->value['fluid_design']) {?>container-fluid<?php } else { ?>container<?php }?> mt20 sg-offcanvas">
  <div class="row">
    <div class="col-12 d-block d-md-none sg-offcanvas-sidebar mt10">
      <?php $_smarty_tpl->_subTemplateRender('file:_sidebar.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    </div>
    <div class="col-12 sg-offcanvas-mainbar">
      <div class="gdtg-tabs-bar mb-4">
        <nav class="gdtg-tabs nav nav-fill" role="tablist">
          <a class="nav-link active" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/giao-dich-trung-gian"><i class="fa fa-info-circle gdtg-tabs-ico"></i> Giới thiệu</a>
          <a class="nav-link" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/giao-dich-trung-gian/list"><i class="fa fa-list-ul gdtg-tabs-ico"></i> Danh sách giao dịch</a>
          <a class="nav-link" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/giao-dich-trung-gian/create"><i class="fa fa-plus-circle gdtg-tabs-ico"></i> Tạo giao dịch</a>
        </nav>
      </div>
      <style>
      .gdtg-tabs-bar { background: #f1f5f9; border-radius: 12px; padding: 6px; box-shadow: 0 1px 3px rgba(0,0,0,.06); }
      .gdtg-tabs { display: flex; flex-wrap: wrap; gap: 4px; border: none; }
      .gdtg-tabs .nav-link { border: none; border-radius: 10px; padding: 0.65rem 1.1rem; font-weight: 500; color: #64748b; transition: background .2s, color .2s; }
      .gdtg-tabs .nav-link:hover { color: #1e40af; background: rgba(255,255,255,.9); }
      .gdtg-tabs .nav-link.active { background: #2563eb; color: #fff; font-weight: 600; }
      .gdtg-tabs-ico { margin-right: 0.4rem; opacity: .9; }
      @media (max-width: 575px) { .gdtg-tabs .nav-link { padding: 0.5rem 0.75rem; font-size: 0.9rem; } .gdtg-tabs-ico { margin-right: 0.25rem; } }
      </style>

      <div class="card shadow">
        <div class="card-body text-with-list" style="font-size: 1.05rem; line-height: 1.7;">

          <h1 class="mb20 text-primary">🔥 GIAO DỊCH ONLINE KHÔNG CÒN "NIỀM TIN MÙ"</h1>
          <p class="lead">Một tính năng trung gian được xây dựng vì cộng đồng – chống lừa đảo – minh bạch từng đồng</p>
          <h3 class="mt25 mb10">Bạn đã từng:</h3>
          <ul>
            <li>Chuyển tiền xong… bên kia mất hút?</li>
            <li>Bán tài khoản nhưng bị bom?</li>
            <li>Mua phần mềm, dịch vụ online mà chỉ biết cầu may?</li>
          </ul>
          <p>👉 Vấn đề không nằm ở người mua hay người bán<br>
          👉 Vấn đề là thiếu một bên trung gian đủ uy tín & đủ minh bạch</p>
          <p><strong>Và đó là lý do tính năng Giao Dịch Trung Gian ra đời.</strong></p>

          <h3 class="mt25 mb10">💡 Giao dịch trung gian – Đổi cách chơi, không đổi người</h3>
          <p>Chúng tôi không hứa "100% không rủi ro".<br>
          Chúng tôi xây một quy trình để rủi ro không còn mập mờ.</p>
          <p>Với tính năng trung gian:</p>
          <ul>
            <li>💰 Tiền được ký quỹ tại trung gian</li>
            <li>📄 Điều khoản được thống nhất trước – không sửa sau</li>
            <li>👀 Mọi trạng thái đều hiển thị minh bạch</li>
            <li>⚖️ Tranh chấp xử lý theo quy trình, không cảm tính</li>
          </ul>
          <p>👉 Không còn:<br>
          ❌ Tin nhắn riêng<br>
          ❌ Thoả thuận miệng<br>
          ❌ "Anh tin em mà…"</p>

          <h3 class="mt25 mb10">⚙️ Giao dịch diễn ra như thế nào?</h3>
          <p><strong>1️⃣ Tạo giao dịch trung gian</strong><br>
          Hai bên thống nhất: Giao dịch gì, Giá bao nhiêu, Điều kiện hoàn tất, Thời gian kiểm tra, Phí trung gian (hiển thị rõ).</p>
          <p><strong>2️⃣ Ký quỹ tiền vào trung gian</strong><br>
          Tiền được khóa – Không ai được tự ý rút.</p>
          <p><strong>3️⃣ Thực hiện & kiểm tra</strong><br>
          Bên bán bàn giao – Bên mua có thời gian xác nhận.</p>
          <p><strong>4️⃣ Hoàn tất hoặc khiếu nại</strong><br>
          Đồng ý → tiền về đúng người. Có vấn đề → xử lý theo điều khoản đã ký.</p>
          <p>📌 Không ai "ăn gian", không ai "ôm tiền chạy".</p>

          <h3 class="mt25 mb10">🛡️ Trung gian cam kết điều gì?</h3>
          <ul>
            <li>Minh bạch dòng tiền</li>
            <li>Phí rõ ràng – thu đúng, thu đủ</li>
            <li>Không thiên vị bất kỳ bên nào</li>
            <li>Chỉ làm đúng những gì hệ thống đã cam kết</li>
          </ul>
          <p>👉 Chúng tôi không làm "cò",<br>
          👉 Chúng tôi làm người giữ luật chơi.</p>

          <h3 class="mt25 mb10">🗓️ Lộ trình phát triển</h3>
          <ul>
            <li>🚧 Đang xây dựng hệ thống giao dịch trung gian</li>
            <li>🧪 Chuẩn bị mở trải nghiệm thử nghiệm (beta)</li>
            <li>🛠️ Hoàn thiện theo góp ý từ cộng đồng</li>
            <li>⏳ Dự kiến ra mắt: [điền thời gian dự kiến]</li>
          </ul>

          <h3 class="mt25 mb10">❤️ Đây không chỉ là một tính năng – đây là một hướng đi</h3>
          <p>Tính năng trung gian này: Sinh ra từ những vụ lừa đảo thật – Được xây để cộng đồng tự bảo vệ nhau – Cần sự ủng hộ & góp ý từ chính bạn.</p>
          <p>Nếu bạn: ✔️ Từng bị lừa | ✔️ Từng sợ khi giao dịch online | ✔️ Muốn một môi trường mua bán minh bạch hơn<br>
          👉 Bạn đang ở đúng chỗ.</p>

          <h3 class="mt25 mb15">📋 Tài liệu & chính sách</h3>
          <p class="mb15">Các trang sau nằm trong trang chính Giao Dịch Trung Gian – mở trong tab mới nếu cần:</p>
          <ul class="list-unstyled">
            <li class="mb10">
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/giao-dich-trung-gian/terms"><i class="fa fa-file-alt mr5 text-primary"></i><strong>📜 Điều khoản dịch vụ (Terms of Service – TOS)</strong></a>
            </li>
            <li class="mb10">
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/giao-dich-trung-gian/fees"><i class="fa fa-percent mr5 text-primary"></i><strong>💰 Chính sách phí & thuế</strong></a>
            </li>
            <li class="mb10">
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/giao-dich-trung-gian/privacy"><i class="fa fa-shield-alt mr5 text-primary"></i><strong>🔐 Chính sách bảo mật</strong></a>
            </li>
          </ul>

          <h3 class="mt25 mb15">🚀 Tham gia cùng chúng tôi ngay từ đầu</h3>

          <div class="row mt20 mb20">
            <div class="col-md-6 mb15">
              <div class="card border-primary h-100">
                <div class="card-body text-center">
                  <h5 class="card-title text-primary">Tôi quan tâm & muốn sử dụng tính năng trung gian</h5>
                  <p class="card-text text-muted small">Đăng ký quan tâm để nhận thông báo khi tính năng ra mắt.</p>
                  <?php if ($_smarty_tpl->tpl_vars['user']->value->_logged_in) {?>
                    <button type="button" class="btn btn-primary btn-lg js-escrow-feedback" data-type="interest">
                      <i class="fa fa-heart mr5"></i> Tôi quan tâm
                    </button>
                    <div class="js-escrow-result-interest mt10 small"></div>
                  <?php } else { ?>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/signin" class="btn btn-primary btn-lg"><i class="fa fa-sign-in-alt mr5"></i> Đăng nhập để gửi</a>
                  <?php }?>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb15">
              <div class="card border-info h-100">
                <div class="card-body text-center">
                  <h5 class="card-title text-info">Tôi muốn góp ý để hệ thống tốt hơn</h5>
                  <p class="card-text text-muted small">Gửi ý kiến, đề xuất cho đội ngũ phát triển.</p>
                  <?php if ($_smarty_tpl->tpl_vars['user']->value->_logged_in) {?>
                    <textarea class="form-control mb10 js-escrow-message" rows="2" placeholder="Góp ý của bạn (tùy chọn)..."></textarea>
                    <button type="button" class="btn btn-info btn-lg js-escrow-feedback" data-type="feedback">
                      <i class="fa fa-comment-dots mr5"></i> Gửi góp ý
                    </button>
                    <div class="js-escrow-result-feedback mt10 small"></div>
                  <?php } else { ?>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/signin" class="btn btn-info btn-lg"><i class="fa fa-sign-in-alt mr5"></i> Đăng nhập để gửi</a>
                  <?php }?>
                </div>
              </div>
            </div>
          </div>

          <p class="text-muted mt20"><em>Niềm tin không thể yêu cầu – nó phải được xây dựng. Và chúng tôi đang xây nó từ hôm nay, cùng cộng đồng.</em></p>

        </div>
      </div>
    </div>
  </div>
</div>

<?php echo '<script'; ?>
>
(function() {
  var ajaxUrl = 'includes/ajax/escrow-feedback.php';
  document.querySelectorAll('.js-escrow-feedback').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var type = this.getAttribute('data-type');
      var resultEl = document.querySelector('.js-escrow-result-' + type);
      var message = type === 'feedback' ? (document.querySelector('.js-escrow-message') && document.querySelector('.js-escrow-message').value) : '';
      if (resultEl) resultEl.innerHTML = '';
      this.disabled = true;
      var fd = new FormData();
      fd.append('type', type);
      fd.append('message', message || '');
      fetch(ajaxUrl, {
        method: 'POST',
        body: fd,
        credentials: 'same-origin',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
        .then(function(r) {
          return r.text().then(function(text) {
            try { return { ok: r.ok, data: JSON.parse(text) }; }
            catch (e) { return { ok: false, data: { message: 'Lỗi kết nối. Kiểm tra đăng nhập hoặc thử lại.' } }; }
          });
        })
        .then(function(o) {
          btn.disabled = false;
          var data = o.data;
          var msg = (data && data.message) ? data.message : 'Có lỗi. Thử lại sau.';
          if (resultEl) resultEl.innerHTML = (data && data.success) ? '<span class="text-success">' + msg + '</span>' : '<span class="text-danger">' + msg + '</span>';
          if (data && data.success && type === 'feedback' && document.querySelector('.js-escrow-message')) document.querySelector('.js-escrow-message').value = '';
        })
        .catch(function() {
          btn.disabled = false;
          if (resultEl) resultEl.innerHTML = '<span class="text-danger">Lỗi kết nối.</span>';
        });
    });
  });
})();
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:_footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
