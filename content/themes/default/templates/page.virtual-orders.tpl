{if $spage['page_business_type_id'] != 1}
  <div class="alert alert-warning">
    {__("Tính năng đơn ảo chỉ áp dụng cho loại hình kinh doanh phù hợp.")}
  </div>
{elseif !$spage['i_admin']}
  <div class="alert alert-info">
    {__("Chỉ quản trị viên trang mới có thể truy cập mục này.")}
  </div>
{else}
  {if $__virtual_orders_tab == 'guide'}
    <div class="card page-virtual-orders page-virtual-orders-guide">
      <div class="card-header bg-transparent d-flex align-items-center">
        <strong>{__("Hướng dẫn")}</strong>
      </div>
      <div class="card-body">
        <div class="alert alert-info mb0">
          {__("Video hướng dẫn sẽ được cập nhật trực tiếp trong hệ thống. Hiện tại chức năng đang được hoàn thiện.")}
        </div>
      </div>
    </div>
{elseif $__virtual_orders_tab == 'create'}
    <div class="card page-virtual-orders">
      <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          {include file='__svg_icons.tpl' icon="task_add" class="main-icon mr10" width="24px" height="24px"}
          <strong>Tạo đơn ảo</strong>
        </div>
        <span class="badge bg-primary text-uppercase">{__("Beta")}</span>
      </div>
      <div class="card-body">
        <p class="text-muted mb20">
          {__("Điền thông tin bên dưới để tạo một đơn ảo. Các cộng tác viên sẽ nhìn thấy chiến dịch của bạn và có thể nhận thực hiện.")}
        </p>

        <form class="js_virtual-order-create" data-page-id="{$spage['page_id']}">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">{__("Tên chiến dịch")}</label>
              <input type="text" name="campaign_title" class="form-control" placeholder="{__("VD: Đơn thử nghiệm RED #1")}">
            </div>
            <div class="col-md-6">
              <label class="form-label">{__("Ngân sách tối đa (VNĐ)")} </label>
              <input type="number" min="0" step="1000" name="budget_limit" class="form-control" placeholder="100000">
            </div>
            <div class="col-md-6">
              <label class="form-label">{__("Số lượng đơn mục tiêu")}</label>
              <input type="number" min="1" name="target_quantity" class="form-control" placeholder="10">
            </div>
            <div class="col-md-6">
              <label class="form-label">{__("Thời hạn chiến dịch")}</label>
              <input type="datetime-local" name="deadline" class="form-control">
            </div>
            <div class="col-md-12">
              <label class="form-label">{__("Mô tả nhiệm vụ")} <small class="text-muted">({__("Chi tiết sản phẩm, bước thực hiện, lưu ý")})</small></label>
              <textarea name="campaign_description" rows="5" class="form-control" placeholder="{__("Nhập mô tả chi tiết cho đơn ảo...")}"></textarea>
            </div>
          </div>

          <div class="mt4 d-flex align-items-center justify-content-between">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" id="virtual-order-terms" name="accept_terms">
              <label class="form-check-label" for="virtual-order-terms">
                {__("Tôi đồng ý với chính sách đơn ảo của Shop-ai")}
              </label>
            </div>
            <button type="submit" class="btn btn-primary">
              {include file='__svg_icons.tpl' icon="send" class="main-icon mr5" width="20px" height="20px"}
              {__("Đăng chiến dịch")}
            </button>
          </div>
        </form>
      </div>
    </div>
  {else}
    <div class="card page-virtual-orders">
      <div class="card-header bg-transparent d-flex align-items-center">
        <strong>
          {if $__virtual_orders_tab == 'new'}
            {__("Đơn mới")}
          {elseif $__virtual_orders_tab == 'received'}
            {__("Đã nhận")}
          {elseif $__virtual_orders_tab == 'placed'}
            {__("Đã đặt")}
          {elseif $__virtual_orders_tab == 'reviewed'}
            {__("Đã đánh giá")}
          {elseif $__virtual_orders_tab == 'completed'}
            {__("Hoàn thành")}
          {elseif $__virtual_orders_tab == 'failed'}
            {__("Thất bại")}
          {/if}
        </strong>
      </div>
      <div class="card-body text-center text-muted py-5">
        {__("Tính năng đang được phát triển. Vui lòng quay lại sau.")}
      </div>
    </div>
  {/if}
{/if}

