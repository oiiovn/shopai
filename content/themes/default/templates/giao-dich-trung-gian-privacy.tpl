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

          <h1 class="mb20">🔐 TRANG CHÍNH SÁCH BẢO MẬT</h1>

          <h3 class="mt25 mb10">1. Thông tin được thu thập</h3>
          <p>Chúng tôi có thể thu thập:</p>
          <ul>
            <li>Thông tin tài khoản (username, email)</li>
            <li>Lịch sử giao dịch trung gian</li>
            <li>Dữ liệu kỹ thuật (IP, trình duyệt, thiết bị)</li>
          </ul>

          <h3 class="mt25 mb10">2. Mục đích sử dụng</h3>
          <p>Dữ liệu được sử dụng để:</p>
          <ul>
            <li>Vận hành hệ thống giao dịch</li>
            <li>Xử lý tranh chấp</li>
            <li>Nâng cao trải nghiệm & bảo mật</li>
            <li>Tuân thủ nghĩa vụ pháp lý (nếu có)</li>
          </ul>

          <h3 class="mt25 mb10">3. Bảo mật dữ liệu</h3>
          <ul>
            <li>Dữ liệu được lưu trữ an toàn</li>
            <li>Chỉ nhân sự có thẩm quyền mới được truy cập</li>
            <li>Không bán hoặc chia sẻ dữ liệu cho bên thứ ba vì mục đích thương mại</li>
          </ul>

          <h3 class="mt25 mb10">4. Chia sẻ thông tin</h3>
          <p>Thông tin chỉ được chia sẻ khi:</p>
          <ul>
            <li>Có sự đồng ý của người dùng</li>
            <li>Có yêu cầu từ cơ quan pháp luật hợp lệ</li>
            <li>Phục vụ xử lý tranh chấp trong hệ thống</li>
          </ul>

          <h3 class="mt25 mb10">5. Thời gian lưu trữ</h3>
          <ul>
            <li>Dữ liệu được lưu trữ trong thời gian cần thiết cho mục đích vận hành</li>
            <li>Người dùng có thể yêu cầu xóa dữ liệu theo quy định</li>
          </ul>

          <h3 class="mt25 mb10">6. Quyền của người dùng</h3>
          <p>Người dùng có quyền:</p>
          <ul>
            <li>Xem thông tin cá nhân</li>
            <li>Yêu cầu chỉnh sửa</li>
            <li>Yêu cầu xóa dữ liệu (nếu phù hợp quy định)</li>
          </ul>

          <h3 class="mt25 mb10">7. Thay đổi chính sách</h3>
          <p>Chính sách bảo mật có thể được cập nhật. Việc tiếp tục sử dụng dịch vụ đồng nghĩa với việc đồng ý chính sách mới.</p>

          <p class="mt25 pt15 border-top">
            <a href="{$system['system_url']}/giao-dich-trung-gian" class="btn btn-primary"><i class="fa fa-arrow-left mr5"></i>Về trang Giao Dịch Trung Gian</a>
            <a href="{$system['system_url']}/giao-dich-trung-gian/terms" class="btn btn-outline-secondary ml10"><i class="fa fa-file-alt mr5"></i>Điều khoản dịch vụ</a>
            <a href="{$system['system_url']}/giao-dich-trung-gian/fees" class="btn btn-outline-secondary ml10"><i class="fa fa-percent mr5"></i>Chính sách phí & thuế</a>
          </p>

        </div>
      </div>
    </div>
  </div>
</div>

{include file='_footer.tpl'}
