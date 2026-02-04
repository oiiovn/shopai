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

          <h1 class="mb20">📜 TRANG ĐIỀU KHOẢN DỊCH VỤ (TERMS OF SERVICE – TOS)</h1>

          <h3 class="mt25 mb10">1. Giới thiệu</h3>
          <p>Trang web này cung cấp dịch vụ trung gian giao dịch (Escrow Service), cho phép các bên tham gia giao dịch online thông qua một quy trình ký quỹ và xác nhận minh bạch.</p>
          <p>Khi sử dụng dịch vụ, bạn xác nhận rằng đã đọc, hiểu và đồng ý toàn bộ Điều khoản dịch vụ này.</p>

          <h3 class="mt25 mb10">2. Vai trò của Trung gian</h3>
          <ul>
            <li>Trung gian không phải là bên mua hoặc bên bán</li>
            <li>Trung gian không sở hữu, không kiểm soát và không bảo đảm chất lượng của hàng hóa/dịch vụ được giao dịch</li>
            <li>Trung gian chỉ đảm bảo thực thi đúng quy trình giao dịch đã được hai bên thống nhất trong hệ thống</li>
          </ul>
          <p>👉 Trung gian không chịu trách nhiệm cho các thỏa thuận ngoài hệ thống.</p>

          <h3 class="mt25 mb10">3. Quy trình giao dịch trung gian</h3>
          <p>Một giao dịch trung gian bao gồm:</p>
          <ul>
            <li>Tạo giao dịch với đầy đủ điều khoản</li>
            <li>Hai bên đồng ý điều khoản</li>
            <li>Ký quỹ tiền vào tài khoản trung gian</li>
            <li>Thực hiện giao dịch</li>
            <li>Xác nhận hoàn tất hoặc khiếu nại</li>
          </ul>
          <p>📌 Sau khi giao dịch được tạo và đồng ý, điều khoản không thể chỉnh sửa.</p>

          <h3 class="mt25 mb10">4. Ký quỹ & dòng tiền</h3>
          <ul>
            <li>Tiền giao dịch được nạp vào tài khoản trung gian</li>
            <li>Tiền bị khóa trong suốt thời gian giao dịch</li>
            <li>Trung gian không sử dụng, không chiếm dụng tiền ký quỹ</li>
            <li>Tiền chỉ được giải ngân khi: Giao dịch hoàn tất hợp lệ, hoặc Có quyết định xử lý tranh chấp theo điều khoản</li>
          </ul>

          <h3 class="mt25 mb10">5. Xác nhận hoàn tất</h3>
          <ul>
            <li>Bên mua có trách nhiệm xác nhận trong thời gian kiểm tra đã chọn</li>
            <li>Nếu quá thời gian kiểm tra mà không có khiếu nại: Giao dịch được xem là hoàn tất tự động; Tiền được giải ngân theo quy trình</li>
          </ul>

          <h3 class="mt25 mb10">6. Khiếu nại & tranh chấp</h3>
          <ul>
            <li>Khiếu nại chỉ được gửi trong thời gian kiểm tra</li>
            <li>Bên khiếu nại phải cung cấp bằng chứng liên quan</li>
            <li>Trung gian xử lý tranh chấp dựa trên điều khoản đã được hai bên đồng ý</li>
          </ul>
          <p>📌 Quyết định của trung gian là cuối cùng trong phạm vi hệ thống.</p>

          <h3 class="mt25 mb10">7. Phí dịch vụ</h3>
          <ul>
            <li>Phí trung gian được thu theo Chính sách phí & thuế</li>
            <li>Phí được khấu trừ khi giao dịch hoàn tất</li>
            <li>Phí không hoàn lại, trừ khi hệ thống có quy định khác</li>
          </ul>

          <h3 class="mt25 mb10">8. Quyền từ chối & khóa tài khoản</h3>
          <p>Trung gian có quyền:</p>
          <ul>
            <li>Từ chối giao dịch có dấu hiệu gian lận</li>
            <li>Tạm khóa hoặc khóa vĩnh viễn tài khoản vi phạm</li>
            <li>Giữ tiền trong thời gian điều tra khi có dấu hiệu rủi ro</li>
          </ul>

          <h3 class="mt25 mb10">9. Giới hạn trách nhiệm</h3>
          <p>Trung gian không chịu trách nhiệm cho:</p>
          <ul>
            <li>Chất lượng dịch vụ/hàng hóa</li>
            <li>Thiệt hại gián tiếp hoặc mất mát ngoài giao dịch</li>
            <li>Tranh chấp phát sinh ngoài hệ thống</li>
          </ul>

          <h3 class="mt25 mb10">10. Thay đổi điều khoản</h3>
          <p>Điều khoản có thể được cập nhật. Việc tiếp tục sử dụng dịch vụ đồng nghĩa với việc chấp nhận điều khoản mới.</p>

          <p class="mt25 pt15 border-top">
            <a href="{$system['system_url']}/giao-dich-trung-gian" class="btn btn-primary"><i class="fa fa-arrow-left mr5"></i>Về trang Giao Dịch Trung Gian</a>
            <a href="{$system['system_url']}/giao-dich-trung-gian/fees" class="btn btn-outline-secondary ml10"><i class="fa fa-percent mr5"></i>Chính sách phí & thuế</a>
            <a href="{$system['system_url']}/giao-dich-trung-gian/privacy" class="btn btn-outline-secondary ml10"><i class="fa fa-shield-alt mr5"></i>Chính sách bảo mật</a>
          </p>

        </div>
      </div>
    </div>
  </div>
</div>

{include file='_footer.tpl'}
