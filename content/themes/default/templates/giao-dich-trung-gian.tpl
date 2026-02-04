{include file='_head.tpl'}
{include file='_header.tpl'}

<div class="{if $system['fluid_design']}container-fluid{else}container{/if} mt20 sg-offcanvas">
  <div class="row">
    <div class="col-12 d-block d-md-none sg-offcanvas-sidebar mt10">
      {include file='_sidebar.tpl'}
    </div>
    <div class="col-12 sg-offcanvas-mainbar">
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

          <h3 class="mt25 mb15">🚀 Tham gia cùng chúng tôi ngay từ đầu</h3>

          <div class="row mt20 mb20">
            <div class="col-md-6 mb15">
              <div class="card border-primary h-100">
                <div class="card-body text-center">
                  <h5 class="card-title text-primary">Tôi quan tâm & muốn sử dụng tính năng trung gian</h5>
                  <p class="card-text text-muted small">Đăng ký quan tâm để nhận thông báo khi tính năng ra mắt.</p>
                  {if $user->_logged_in}
                    <button type="button" class="btn btn-primary btn-lg js-escrow-feedback" data-type="interest">
                      <i class="fa fa-heart mr5"></i> Tôi quan tâm
                    </button>
                    <div class="js-escrow-result-interest mt10 small"></div>
                  {else}
                    <a href="{$system['system_url']}/signin" class="btn btn-primary btn-lg"><i class="fa fa-sign-in-alt mr5"></i> Đăng nhập để gửi</a>
                  {/if}
                </div>
              </div>
            </div>
            <div class="col-md-6 mb15">
              <div class="card border-info h-100">
                <div class="card-body text-center">
                  <h5 class="card-title text-info">Tôi muốn góp ý để hệ thống tốt hơn</h5>
                  <p class="card-text text-muted small">Gửi ý kiến, đề xuất cho đội ngũ phát triển.</p>
                  {if $user->_logged_in}
                    <textarea class="form-control mb10 js-escrow-message" rows="2" placeholder="Góp ý của bạn (tùy chọn)..."></textarea>
                    <button type="button" class="btn btn-info btn-lg js-escrow-feedback" data-type="feedback">
                      <i class="fa fa-comment-dots mr5"></i> Gửi góp ý
                    </button>
                    <div class="js-escrow-result-feedback mt10 small"></div>
                  {else}
                    <a href="{$system['system_url']}/signin" class="btn btn-info btn-lg"><i class="fa fa-sign-in-alt mr5"></i> Đăng nhập để gửi</a>
                  {/if}
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

<script>
(function() {
  var systemUrl = '{$system['system_url']}';
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
      fetch(systemUrl + '/includes/ajax/escrow-feedback.php', {
        method: 'POST',
        body: fd,
        credentials: 'same-origin',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
        .then(function(r) { return r.json(); })
        .then(function(data) {
          btn.disabled = false;
          if (resultEl) resultEl.innerHTML = data.success ? '<span class="text-success">' + (data.message || 'Đã gửi. Cảm ơn bạn!') + '</span>' : '<span class="text-danger">' + (data.message || 'Có lỗi. Thử lại sau.') + '</span>';
          if (data.success && type === 'feedback' && document.querySelector('.js-escrow-message')) document.querySelector('.js-escrow-message').value = '';
        })
        .catch(function() {
          btn.disabled = false;
          if (resultEl) resultEl.innerHTML = '<span class="text-danger">Lỗi kết nối.</span>';
        });
    });
  });
})();
</script>

{include file='_footer.tpl'}
