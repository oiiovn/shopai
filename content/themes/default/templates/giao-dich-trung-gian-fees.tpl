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

          <p class="mb15">
            <a href="{$system['system_url']}/giao-dich-trung-gian" class="text-muted"><i class="fa fa-arrow-left mr5"></i>Về trang Giao Dịch Trung Gian</a>
          </p>

          <h1 class="mb20">💰 TRANG CHÍNH SÁCH PHÍ & THUẾ</h1>

          <h3 class="mt25 mb10">1. Phí trung gian</h3>
          <ul>
            <li>Phí trung gian: <strong>5%</strong> tổng giá trị giao dịch</li>
            <li>Phí được hiển thị trước khi tạo giao dịch</li>
            <li>Phí được khấu trừ khi giao dịch hoàn tất</li>
          </ul>
          <p>📌 Ví dụ:<br>
          Giao dịch 10.000.000 đ → Phí trung gian: 500.000 đ</p>

          <h3 class="mt25 mb10">2. Thuế</h3>
          <p>Thuế áp dụng hiện tại: <strong>0%</strong></p>
          <p>Nếu có thay đổi về chính sách thuế theo quy định pháp luật, hệ thống sẽ:</p>
          <ul>
            <li>Thông báo công khai</li>
            <li>Hiển thị rõ ràng trước khi giao dịch</li>
          </ul>

          <h3 class="mt25 mb10">3. Minh bạch dòng tiền</h3>
          <p>Trong mỗi giao dịch, hệ thống hiển thị:</p>
          <ul>
            <li>Tổng tiền giao dịch</li>
            <li>Phí trung gian</li>
            <li>Thuế (nếu có)</li>
            <li>Số tiền thực nhận</li>
          </ul>
          <p>👉 Không có phí ẩn – không thu ngoài hệ thống.</p>

          <h3 class="mt25 mb10">4. Hoàn phí</h3>
          <ul>
            <li>Phí trung gian không hoàn lại khi giao dịch đã hoàn tất</li>
            <li>Trường hợp hoàn tiền đặc biệt (nếu có) sẽ được thông báo rõ trong giao dịch</li>
          </ul>

          <p class="mt25 pt15 border-top">
            <a href="{$system['system_url']}/giao-dich-trung-gian" class="btn btn-primary"><i class="fa fa-arrow-left mr5"></i>Về trang Giao Dịch Trung Gian</a>
            <a href="{$system['system_url']}/giao-dich-trung-gian/terms" class="btn btn-outline-secondary ml10"><i class="fa fa-file-alt mr5"></i>Điều khoản dịch vụ</a>
            <a href="{$system['system_url']}/giao-dich-trung-gian/privacy" class="btn btn-outline-secondary ml10"><i class="fa fa-shield-alt mr5"></i>Chính sách bảo mật</a>
          </p>

        </div>
      </div>
    </div>
  </div>
</div>

{include file='_footer.tpl'}
