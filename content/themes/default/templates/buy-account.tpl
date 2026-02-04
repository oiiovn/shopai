{include file='_head.tpl'}
{include file='_header.tpl'}

<!-- Buy Account Styles -->
<style>
.account-card {
  transition: all 0.3s ease;
  cursor: pointer;
  border: 2px solid transparent;
  margin-bottom: 20px;
}
.account-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  border-color: #007bff;
}
.account-card.selected {
  border-color: #28a745;
  background-color: #f8fff8;
}
.account-icon {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  margin: 0 auto 10px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}
.account-price {
  font-size: 20px;
  font-weight: bold;
  color: #22c55e;
}
.account-info {
  font-size: 14px;
  color: #6c757d;
  margin-top: 10px;
}
.account-badge {
  display: inline-block;
  padding: 5px 12px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 500;
  margin: 3px;
}
.account-badge.available {
  background-color: #d4edda;
  color: #155724;
}
.account-badge.sold-out {
  background-color: #f8d7da;
  color: #721c24;
}
.category-tab {
  padding: 10px 20px;
  cursor: pointer;
  border-bottom: 3px solid transparent;
  transition: all 0.2s ease;
  color: #333;
}
.category-tab:hover, .category-tab.active {
  border-bottom-color: #007bff;
  color: #007bff;
}
/* Minimal Fintech – Digital Product card */
.category-card {
  transition: all 0.25s ease;
  border: 1px solid #e8e8e8;
  border-radius: 12px;
  overflow: hidden;
  background: #fff;
}
.category-card:hover {
  box-shadow: 0 4px 20px rgba(0,0,0,0.06);
  border-color: #ddd;
}
.category-card-header {
  padding: 20px 20px 16px;
  border-radius: 12px 12px 0 0;
  min-height: 72px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}
.category-card-header.has-image {
  padding: 0;
  min-height: 0;
  display: block;
}
.category-card-header.has-image img.card-icon-img {
  width: 100% !important;
  max-width: none !important;
  height: auto !important;
  max-height: none !important;
  display: block;
  vertical-align: top;
  object-fit: cover;
  aspect-ratio: 16 / 9;
}
.category-card-header.shopee {
  background: linear-gradient(135deg, #fff5f2 0%, #fff 100%);
}
.category-card-header.default {
  background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
}
.category-card-header img.card-icon-img {
  max-width: 48px;
  max-height: 48px;
  object-fit: contain;
}
.category-card-header .card-icon-placeholder {
  width: 48px;
  height: 48px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
}
.category-card-header.shopee .card-icon-placeholder {
  background: rgba(238, 77, 45, 0.12);
  color: #ee4d2d;
}
.category-card-header.default .card-icon-placeholder {
  background: #f0f0f0;
  color: #666;
}
.category-card-body {
  padding: 16px 20px 20px;
}
.category-card-title {
  font-size: 18px;
  font-weight: 700;
  color: #1a1a1a;
  margin-bottom: 10px;
  letter-spacing: -0.02em;
}
.category-card-checklist {
  font-size: 13px;
  color: #555;
  line-height: 1.6;
  margin-bottom: 14px;
}
.category-card-checklist .check-item {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  margin-bottom: 4px;
}
.category-card-checklist .check-item:before {
  content: "✔";
  color: #22c55e;
  font-weight: 700;
  flex-shrink: 0;
}
.category-card-price {
  font-size: 22px;
  font-weight: 800;
  color: #22c55e;
  margin-bottom: 6px;
  letter-spacing: -0.02em;
}
.category-card-stock {
  font-size: 13px;
  color: #6b7280;
  margin-bottom: 14px;
}
.category-card-cta {
  margin-top: 16px;
}
.category-card-cta .btn-mua {
  width: 100%;
  padding: 12px 20px;
  font-size: 15px;
  font-weight: 600;
  border-radius: 10px;
  border: none;
  background: #22c55e;
  color: #fff;
  transition: all 0.2s ease;
}
.category-card-cta .btn-mua:hover {
  background: #16a34a;
  color: #fff;
}
.category-card-cta .btn-mua:disabled {
  background: #94a3b8;
  cursor: not-allowed;
}
.category-card-admin {
  margin-top: 12px;
  padding-top: 12px;
  border-top: 1px solid #f0f0f0;
}
.category-card-admin .btn {
  font-size: 12px;
  padding: 6px 12px;
  font-weight: 600;
}
.category-card-admin .btn-edit-category {
  background: #3b82f6;
  border-color: #3b82f6;
  color: #fff;
}
.category-card-admin .btn-edit-category:hover {
  background: #2563eb;
  border-color: #2563eb;
  color: #fff;
}
.category-card-admin .btn-delete-category {
  background: #dc2626;
  border-color: #dc2626;
  color: #fff;
}
.category-card-admin .btn-delete-category:hover {
  background: #b91c1c;
  border-color: #b91c1c;
  color: #fff;
}
.category-icon {
  width: 120px;
  height: 120px;
  border-radius: 15px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto;
}
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255,255,255,0.9);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}
/* Trạng thái đơn hàng nổi bật */
.badge-status {
  padding: 6px 14px;
  font-size: 13px;
  font-weight: 600;
  border-radius: 6px;
}
.badge-status-paid {
  background: #0d6efd;
  color: #fff;
}
.badge-status-completed {
  background: #198754;
  color: #fff;
}
/* Shopee màu cam */
.text-shopee {
  color: #ee4d2d !important;
  font-weight: 600;
}
</style>

<!-- page content -->
<div class="{if $system['fluid_design']}container-fluid{else}container{/if} mt20 sg-offcanvas">
  <div class="row">

    <!-- side panel (mobile only) -->
    <div class="col-12 d-block d-md-none sg-offcanvas-sidebar">
      {include file='_sidebar.tpl'}
    </div>
    <!-- side panel -->

    <!-- buy-account sidebar (desktop only) -->
    <div class="col-md-4 col-lg-3 sg-offcanvas-sidebar js_sticky-sidebar shop-ai-sidebar d-none d-md-block">
      <div class="card main-side-nav-card">
        <div class="card-body with-nav">
          <!-- Số dư -->
          <div class="text-center mb-3 p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; color: white;">
            <div class="small">Số dư của bạn</div>
            <div class="h4 mb-0">{number_format($user->_data['user_wallet_balance'], 0, ',', '.')} đ</div>
            <a href="{$system['system_url']}/shop-ai/recharge" class="btn btn-sm btn-light mt-2">
              <i class="fa fa-plus"></i> Nạp tiền
            </a>
          </div>
          
          <ul class="main-side-nav">
            <li {if $view == 'list'}class="active"{/if}>
              <a href="{$system['system_url']}/buy-account">
                <i class="fa fa-shopping-cart main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Danh sách tài khoản
              </a>
            </li>
            <li {if $view == 'my-accounts'}class="active"{/if}>
              <a href="{$system['system_url']}/buy-account?view=my-accounts">
                <i class="fa fa-user-check main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Tài khoản đã mua
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- buy-account sidebar -->

    <!-- content panel -->
    <div class="col-12 col-md-8 col-lg-9 sg-offcanvas-mainbar shop-ai-mainbar">

      {if $view == 'list'}
        <!-- Danh sách danh mục -->
        <div class="card">
          <div class="card-header bg-transparent">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">
                <i class="fa fa-shopping-cart mr-2"></i>
                Danh mục tài khoản
              </h5>
              {if $is_admin}
              <div>
                <button type="button" class="btn btn-success btn-sm mr-1" id="btnAddCategory" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                  <i class="fa fa-plus mr-1"></i> Thêm danh mục
                </button>
                <button type="button" class="btn btn-primary btn-sm" id="btnImportExcel" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                  <i class="fa fa-upload mr-1"></i> Thêm tài khoản từ Excel
                </button>
              </div>
              {/if}
            </div>
          </div>
          <div class="card-body">
            {if $has_categories}
            <div class="row">
              {foreach $categories as $category}
              <div class="col-md-6 col-lg-4 mb-4">
                <div class="card category-card h-100">
                  <div class="category-card-header{if $category.is_shopee} shopee{else} default{/if}{if $category.category_image_url} has-image{/if}">
                    {if $category.category_image_url}
                    <img src="{$category.category_image_url}" alt="{$category.category_name}" class="card-icon-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="card-icon-placeholder" style="display: none;"><i class="fa fa-shopping-bag"></i></div>
                    {else}
                    <div class="card-icon-placeholder">
                      <i class="fa {if $category.is_shopee}fa-shopping-bag{else}fa-id-card{/if}"></i>
                    </div>
                    {/if}
                  </div>
                  <div class="category-card-body">
                    <h5 class="category-card-title">{$category.category_name}</h5>
                    
                    {if $category.description_lines}
                    <div class="category-card-checklist">
                      {foreach $category.description_lines as $line}
                      <div class="check-item">{$line|escape:"html"}</div>
                      {/foreach}
                    </div>
                    {elseif $category.category_description}
                    <div class="category-card-checklist">
                      <div class="check-item">{$category.category_description|escape:"html"}</div>
                    </div>
                    {/if}
                    
                    <div class="category-card-price">💰 {number_format($category.category_price, 0, ',', '.')}đ / tài khoản</div>
                    <div class="category-card-stock">📦 Còn lại: <strong>{$category.available_count}</strong> tài khoản</div>
                    
                    {if $category.available_count > 0}
                    <form class="buy-quick-form" data-category-id="{$category.category_id}" data-unit-price="{$category.category_price}" data-max="{$category.available_count}" data-user-balance="{$user->_data['user_wallet_balance']|default:0}">
                      <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text" style="font-size: 13px;">Số lượng:</span>
                        <input type="number" class="form-control quantity-input" min="1" max="{$category.available_count}" value="1" required style="font-size: 14px;">
                        <button type="submit" class="btn btn-mua">
                          <i class="fa fa-shopping-cart mr-1"></i>Mua ngay
                        </button>
                      </div>
                      <div class="buy-quick-result small" style="display: none;"></div>
                    </form>
                    {else}
                    <div class="category-card-cta">
                      <button type="button" class="btn btn-mua" disabled>Hết hàng</button>
                    </div>
                    {/if}
                    
                    {if $is_admin}
                    <div class="category-card-admin btn-group btn-group-sm d-flex">
                      <button type="button" class="btn flex-fill btn-edit-category" data-id="{$category.category_id}" data-name="{$category.category_name|escape:"html"}" data-slug="{$category.category_slug|escape:"html"}" data-price="{$category.category_price}" data-desc="{$category.category_description|escape:"html"}" data-image="{$category.category_image|escape:"html"}">
                        <i class="fa fa-edit mr-1"></i>Sửa
                      </button>
                      <button type="button" class="btn flex-fill btn-delete-category" data-id="{$category.category_id}" data-name="{$category.category_name|escape:"html"}">
                        <i class="fa fa-trash mr-1"></i>Xóa
                      </button>
                    </div>
                    {/if}
                  </div>
                </div>
              </div>
              {/foreach}
            </div>
            {else}
            <div class="text-center py-5">
              <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
              <p class="text-muted">Chưa có danh mục nào.</p>
              {if $is_admin}
              <button type="button" class="btn btn-success mt-2" id="btnAddCategoryEmpty" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="fa fa-plus mr-1"></i> Thêm danh mục đầu tiên
              </button>
              {/if}
            </div>
            {/if}
          </div>
        </div>

      {elseif $view == 'category'}
        <!-- Danh sách tài khoản trong danh mục -->
        <div class="card">
          <div class="card-header bg-transparent">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h5 class="mb-0">
                  <i class="fa fa-list mr-2"></i>
                  {$category.category_name}
                </h5>
                <small class="text-muted">
                  Giá: {number_format($category.category_price, 0, ',', '.')} đ/tài khoản | 
                  Còn: <strong>{$total_accounts}</strong> tài khoản
                </small>
              </div>
              <div>
                <a href="{$system['system_url']}/buy-account" class="btn btn-sm btn-secondary mr-2">
                  <i class="fa fa-arrow-left mr-1"></i>Quay lại
                </a>
                {if $is_admin}
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#importExcelModal" data-preselect-category="{$category.category_id}">
                  <i class="fa fa-upload mr-1"></i>Thêm tài khoản từ Excel
                </button>
                {/if}
              </div>
            </div>
          </div>
          <div class="card-body">
            {if $has_accounts}
            <!-- Form mua hàng -->
            <div class="alert alert-info mb-4">
              <h6><i class="fa fa-info-circle mr-2"></i>Mua tài khoản</h6>
              <form id="buyAccountForm" class="row align-items-end">
                <input type="hidden" id="category_id" value="{$category.category_id}">
                <input type="hidden" id="unit_price" value="{$category.category_price}">
                <input type="hidden" id="user_balance" value="{$user->_data['user_wallet_balance']|default:0}">
                <div class="col-md-4">
                  <label>Số lượng:</label>
                  <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="{$total_accounts}" value="1" required>
                  <small class="text-muted">Tối đa: {$total_accounts} tài khoản</small>
                </div>
                <div class="col-md-4">
                  <label>Tổng tiền:</label>
                  <div class="h5 mb-0 account-price" id="totalPrice">
                    {number_format($category.category_price, 0, ',', '.')} đ
                  </div>
                </div>
                <div class="col-md-4">
                  <button type="submit" class="btn btn-success btn-block" id="buyBtn">
                    <i class="fa fa-shopping-cart mr-1"></i>Mua ngay
                  </button>
                </div>
              </form>
              <div id="buyResult" class="mt-3" style="display: none;"></div>
            </div>
            
            <!-- Không hiển thị chi tiết tài khoản chưa mua - chỉ hiện form mua -->
            <div class="text-center py-3">
              <p class="text-muted mb-0"><i class="fa fa-lock mr-1"></i>Thông tin tài khoản chỉ hiển thị sau khi bạn mua thành công.</p>
            </div>
            
            {else}
            <div class="text-center py-5">
              <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
              <p class="text-muted">Danh mục này hiện không còn tài khoản nào.</p>
            </div>
            {/if}
          </div>
        </div>

      {elseif $view == 'my-accounts'}
        <!-- Bảng danh sách đơn hàng đã mua -->
        <div class="card">
          <div class="card-header bg-transparent">
            <h5 class="mb-0">
              <i class="fa fa-user-check mr-2"></i>
              Tài khoản đã mua
            </h5>
          </div>
          <div class="card-body">
            {if $has_orders}
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Mã đơn</th>
                    <th>Danh mục</th>
                    <th>Số lượng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Thời gian</th>
                    <th>Thao tác</th>
                  </tr>
                </thead>
                <tbody>
                  {foreach $orders as $ord}
                  <tr>
                    <td>#{$ord.order_id}</td>
                    <td>
                      {if $ord.category_image_url}
                      <img src="{$ord.category_image_url}" alt="{$ord.category_name}" style="width: 36px; height: 36px; object-fit: cover; border-radius: 6px; margin-right: 10px; vertical-align: middle;">
                      {else}
                      <span class="category-icon-placeholder" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; background: #f0f0f0; border-radius: 6px; margin-right: 10px; vertical-align: middle;"><i class="fa fa-image text-muted"></i></span>
                      {/if}
                      <span class="category-name-cell{if $ord.is_shopee} text-shopee{/if}">{$ord.category_name}</span>
                    </td>
                    <td>{$ord.quantity} tài khoản</td>
                    <td class="account-price">{number_format($ord.total_price, 0, ',', '.')} đ</td>
                    <td class="status-cell">
                      {if $ord.status == 'paid'}
                        <span class="badge badge-status badge-status-paid">Đã thanh toán</span>
                      {elseif $ord.status == 'completed'}
                        <span class="badge badge-status badge-status-completed">Hoàn thành</span>
                      {else}
                        <span class="badge badge-status badge-secondary">{$ord.status}</span>
                      {/if}
                    </td>
                    <td>{$ord.created_at|date_format:"%d/%m/%Y %H:%M"}</td>
                    <td>
                      <a href="{$system['system_url']}/buy-account?view=order&order_id={$ord.order_id}" class="btn btn-sm btn-primary">
                        <i class="fa fa-eye mr-1"></i>Chi tiết
                      </a>
                    </td>
                  </tr>
                  {/foreach}
                </tbody>
              </table>
            </div>
            {if $total_pages > 1}
            <nav aria-label="Page navigation" class="mt-4">
              <ul class="pagination justify-content-center">
                {if $current_page > 1}
                <li class="page-item">
                  <a class="page-link" href="{$system['system_url']}/buy-account?view=my-accounts&page={$current_page - 1}">Trước</a>
                </li>
                {/if}
                {for $p=1 to $total_pages}
                  {if $p == $current_page}
                  <li class="page-item active"><span class="page-link">{$p}</span></li>
                  {else}
                  <li class="page-item"><a class="page-link" href="{$system['system_url']}/buy-account?view=my-accounts&page={$p}">{$p}</a></li>
                  {/if}
                {/for}
                {if $current_page < $total_pages}
                <li class="page-item">
                  <a class="page-link" href="{$system['system_url']}/buy-account?view=my-accounts&page={$current_page + 1}">Sau</a>
                </li>
                {/if}
              </ul>
            </nav>
            {/if}
            {else}
            <div class="text-center py-5">
              <i class="fa fa-user-times fa-3x text-muted mb-3"></i>
              <p class="text-muted">Bạn chưa mua tài khoản nào.</p>
              <a href="{$system['system_url']}/buy-account" class="btn btn-primary">Xem danh mục tài khoản</a>
            </div>
            {/if}
          </div>
        </div>

      {elseif $view == 'order'}
        <!-- Chi tiết đơn hàng -->
        <div class="card">
          <div class="card-header bg-transparent">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">
                <i class="fa fa-receipt mr-2"></i>
                Đơn hàng #{$order.order_id}
              </h5>
              <a href="{$system['system_url']}/buy-account?view=my-accounts" class="btn btn-sm btn-secondary">
                <i class="fa fa-arrow-left mr-1"></i>Quay lại
              </a>
            </div>
          </div>
          <div class="card-body">
            {if $order}
            <!-- Danh sách tài khoản đã mua - bảng đầy đủ các trường -->
            <h6 class="mb-3"><i class="fa fa-list mr-2"></i>Danh sách tài khoản đã mua:</h6>
            {if $order_items}
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>STT</th>
                    <th>User</th>
                    <th>Pass</th>
                    <th>Email|Pass</th>
                    <th>Cookie</th>
                    <th>Info (SPC_F)</th>
                  </tr>
                </thead>
                <tbody>
                  {foreach $order_items as $index => $item}
                  <tr>
                    <td>{$index + 1}</td>
                    <td><strong>{$item.UserName}</strong></td>
                    <td><small>{$item.Pass|default:'-'}</small></td>
                    <td>
                      <small class="expandable-cell" style="display: block; max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; cursor: pointer; word-break: break-all;" title="Nhấn để mở rộng">{$item.EmailPass|default:'-'}</small>
                    </td>
                    <td>
                      {if $item.Cookie}
                      <small class="expandable-cell" style="display: block; max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; cursor: pointer; word-break: break-all;" title="Nhấn để mở rộng">{$item.Cookie}</small>
                      <button class="btn btn-sm btn-outline-primary mt-1" onclick="copyFromElement(this.previousElementSibling, this); return false;">
                        <i class="fa fa-copy"></i> Copy
                      </button>
                      {else}-{/if}
                    </td>
                    <td>
                      <small class="expandable-cell" style="display: block; max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; cursor: pointer; word-break: break-all;" title="Nhấn để mở rộng">{$item.Info|default:'-'}</small>
                    </td>
                  </tr>
                  {/foreach}
                </tbody>
              </table>
            </div>
            {else}
            <div class="alert alert-warning">
              <i class="fa fa-exclamation-triangle mr-2"></i>Chưa có tài khoản nào trong đơn hàng này.
            </div>
            {/if}
            
            {else}
            <div class="text-center py-5">
              <i class="fa fa-exclamation-triangle fa-3x text-warning mb-3"></i>
              <p class="text-muted">Không tìm thấy đơn hàng</p>
            </div>
            {/if}
          </div>
        </div>

      {elseif $view == 'details'}
        <!-- Chi tiết tài khoản -->
        <div class="card">
          <div class="card-header bg-transparent">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">
                <i class="fa fa-info-circle mr-2"></i>
                Chi tiết tài khoản
              </h5>
              <a href="{$system['system_url']}/buy-account?view={if $account.Status == 'sold'}my-accounts{else}list{/if}" class="btn btn-sm btn-secondary">
                <i class="fa fa-arrow-left mr-1"></i>Quay lại
              </a>
            </div>
          </div>
          <div class="card-body">
            {if $account}
            {* Chỉ hiển thị mật khẩu, cookie khi user sở hữu (đã mua) hoặc admin *}
            {assign var="can_view_sensitive" value=($account.Status == 'sold' && ($account.SoldTo == $user->_data['user_id'] || $is_admin)) || $is_admin}
            <div class="row">
              <div class="col-md-6">
                <h6 class="text-muted mb-3">Thông tin tài khoản</h6>
                <table class="table table-bordered">
                  <tr>
                    <td width="40%" class="font-weight-bold">User:</td>
                    <td>{$account.UserName}</td>
                  </tr>
                  {if $can_view_sensitive}
                  <tr>
                    <td class="font-weight-bold">Pass:</td>
                    <td>
                      <span id="passwordDisplay">••••••••</span>
                      <button class="btn btn-sm btn-outline-primary ml-2" onclick="togglePassword()">
                        <i class="fa fa-eye" id="passwordToggleIcon"></i> Hiện/Ẩn
                      </button>
                    </td>
                  </tr>
                  {else}
                  <tr><td colspan="2" class="text-muted"><i class="fa fa-lock mr-1"></i>Mua tài khoản để xem thông tin đầy đủ</td></tr>
                  {/if}
                  {if $can_view_sensitive && $account.EmailPass}
                  <tr>
                    <td class="font-weight-bold">Email|Pass:</td>
                    <td>{$account.EmailPass}</td>
                  </tr>
                  {/if}
                  {if $account.AccType}
                  <tr>
                    <td class="font-weight-bold">Loại tài khoản:</td>
                    <td><span class="badge badge-secondary">{$account.AccType}</span></td>
                  </tr>
                  {/if}
                  <tr>
                    <td class="font-weight-bold">Đọc Hòm Thư:</td>
                    <td>
                      {if $account.DocHomThu == '1'}
                        <span class="badge badge-success"><i class="fa fa-check mr-1"></i>Có</span>
                      {else}
                        <span class="badge badge-secondary"><i class="fa fa-times mr-1"></i>Không</span>
                      {/if}
                    </td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">Giá:</td>
                    <td class="account-price">
                      {if $account.Price > 0}
                        {number_format($account.Price, 0, ',', '.')} đ
                      {else}
                        <span class="text-muted">Miễn phí</span>
                      {/if}
                    </td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">Trạng thái:</td>
                    <td>
                      {if $account.Status == 'available'}
                        <span class="badge badge-success">Có sẵn</span>
                      {elseif $account.Status == 'sold'}
                        <span class="badge badge-danger">Đã bán</span>
                      {elseif $account.Status == 'reserved'}
                        <span class="badge badge-warning">Đã đặt</span>
                      {else}
                        <span class="badge badge-secondary">Vô hiệu</span>
                      {/if}
                    </td>
                  </tr>
                </table>
              </div>
              
              <div class="col-md-6">
                <h6 class="text-muted mb-3">Thông tin bổ sung</h6>
                {if $can_view_sensitive && $account.Cookie}
                <div class="mb-3">
                  <label class="font-weight-bold">Cookie:</label>
                  <textarea class="form-control copy-source" id="copyCookie" rows="5" readonly>{$account.Cookie}</textarea>
                  <button class="btn btn-sm btn-outline-primary mt-2" onclick="copyFromElement(document.getElementById('copyCookie'), this); return false;">
                    <i class="fa fa-copy mr-1"></i>Copy Cookie
                  </button>
                </div>
                {/if}
                
                {if $can_view_sensitive && $account.CookieEditor}
                <div class="mb-3">
                  <label class="font-weight-bold">Cookie Editor:</label>
                  <textarea class="form-control copy-source" id="copyCookieEditor" rows="3" readonly>{$account.CookieEditor}</textarea>
                  <button class="btn btn-sm btn-outline-primary mt-2" onclick="copyFromElement(document.getElementById('copyCookieEditor'), this); return false;">
                    <i class="fa fa-copy mr-1"></i>Copy
                  </button>
                </div>
                {/if}
                
                {if $can_view_sensitive && $account.Info}
                <div class="mb-3">
                  <label class="font-weight-bold">Thông tin (SPC_F):</label>
                  <div class="p-3 bg-light rounded">{$account.Info}</div>
                </div>
                {/if}
                
                <div class="mb-3">
                  <small class="text-muted">
                    <i class="fa fa-calendar mr-1"></i>
                    Tạo lúc: {$account.CreatedAt|date_format:"%d/%m/%Y %H:%M"}
                    {if $account.UpdatedAt != $account.CreatedAt}
                    <br>
                    Cập nhật: {$account.UpdatedAt|date_format:"%d/%m/%Y %H:%M"}
                    {/if}
                  </small>
                </div>
              </div>
            </div>
            
            {if $account.Status == 'available' && $account.category_id}
            <div class="text-center mt-4">
              <a href="{$system['system_url']}/buy-account?view=category&category_id={$account.category_id}" class="btn btn-success btn-lg">
                <i class="fa fa-shopping-cart mr-2"></i>Mua tài khoản này
              </a>
            </div>
            {/if}
            
            {else}
            <div class="text-center py-5">
              <i class="fa fa-exclamation-triangle fa-3x text-warning mb-3"></i>
              <p class="text-muted">Không tìm thấy tài khoản</p>
            </div>
            {/if}
          </div>
        </div>
      {/if}

    </div>
    <!-- content panel -->

  </div>
</div>
<!-- page content -->

{* Modal Import Excel - Chỉ hiển thị cho admin *}
{if $is_admin}
<!-- Modal Thêm/Sửa danh mục -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCategoryModalLabel">
          <i class="fa fa-plus-circle mr-2"></i><span id="categoryModalTitle">Thêm danh mục mới</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addCategoryForm" enctype="multipart/form-data">
        <input type="hidden" id="form_category_id" name="category_id" value="">
        <div class="modal-body">
          <div class="form-group" id="categoryCurrentImageWrap" style="display: none;">
            <label>Ảnh hiện tại</label>
            <div class="mb-2"><img id="categoryCurrentImage" src="" alt="" style="max-height: 80px; border-radius: 8px;"></div>
          </div>
          <div class="form-group">
            <label for="category_image">Ảnh danh mục</label>
            <input type="file" class="form-control" id="category_image" name="category_image" accept="image/jpeg,image/png,image/gif,image/webp">
            <small class="form-text text-muted">Định dạng: JPG, PNG, GIF, WebP. Tỷ lệ khuyến nghị: <strong>16:9</strong> (vd: 800×450px) – ảnh full rộng thẻ, chiều cao cố định. Để trống khi sửa nếu không đổi ảnh.</small>
          </div>
          <div class="form-group">
            <label for="category_name">Tên danh mục <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="category_name" name="category_name" placeholder="VD: Facebook, Gmail" required maxlength="255">
          </div>
          <div class="form-group">
            <label for="category_slug">Slug (URL)</label>
            <input type="text" class="form-control" id="category_slug" name="category_slug" placeholder="VD: facebook, gmail (để trống sẽ tự tạo)">
            <small class="form-text text-muted">Chữ thường, không dấu, dùng gạch ngang</small>
          </div>
          <div class="form-group">
            <label for="category_price">Giá mỗi tài khoản (đ) <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="category_price" name="category_price" placeholder="50000" min="0" step="1000" value="0" required>
          </div>
          <div class="form-group">
            <label for="category_description">Mô tả</label>
            <textarea class="form-control" id="category_description" name="category_description" rows="3" placeholder="Mô tả ngắn về danh mục"></textarea>
          </div>
          <div id="addCategoryResult" style="display: none;"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-success" id="addCategorySubmit">
            <i class="fa fa-plus mr-1"></i><span id="categorySubmitText">Thêm danh mục</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="importExcelModal" tabindex="-1" role="dialog" aria-labelledby="importExcelModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importExcelModalLabel">
          <i class="fa fa-upload mr-2"></i>Import tài khoản từ Excel
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="importExcelForm" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="alert alert-info">
            <i class="fa fa-info-circle mr-2"></i>
            <strong>Hướng dẫn:</strong>
            <ul class="mb-0 mt-2">
              <li>File Excel/CSV phải có các cột: <code>UserName</code>, <code>Pass</code> (hoặc <code>Password</code>)</li>
              <li>Các cột tùy chọn: <code>Email</code>, <code>EmailPass</code>, <code>FullCookie</code>, <code>Info</code>, <code>Info(SPC_F)</code>, <code>Ngày Mua</code>, <code>AccType</code>, <code>CookieEditor</code>, <code>Cookie</code>, <code>Price</code></li>
              <li>Hỗ trợ định dạng: .xlsx, .xls, .csv</li>
            </ul>
          </div>
          
          {if $has_categories}
          <div class="form-group">
            <label for="import_category_id">Danh mục <span class="text-danger">*</span></label>
            <select class="form-control" id="import_category_id" name="category_id" required>
              <option value="">-- Chọn danh mục --</option>
              {foreach $categories as $cat}
              <option value="{$cat.category_id}">{$cat.category_name}</option>
              {/foreach}
            </select>
            <small class="form-text text-muted">Tài khoản import sẽ được gán vào danh mục này</small>
          </div>
          {/if}
          
          <div class="form-group">
            <label for="excel_file">Chọn file Excel/CSV</label>
            <input type="file" class="form-control-file" id="excel_file" name="excel_file" accept=".xlsx,.xls,.csv" required>
            <small class="form-text text-muted">Kích thước tối đa: 10MB</small>
          </div>
          
          <div id="importProgress" style="display: none;">
            <div class="progress mb-2">
              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
            </div>
            <p class="text-center text-muted">Đang xử lý file...</p>
          </div>
          
          <div id="importResult" style="display: none;"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-upload mr-1"></i>Import
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
(function() {
    // Đợi jQuery sẵn sàng
    function initImportExcel() {
        if (typeof jQuery === 'undefined') {
            setTimeout(initImportExcel, 100);
            return;
        }
        
        var $ = jQuery;
        
        $(document).ready(function() {
            $('#importExcelForm').on('submit', function(e) {
                e.preventDefault();
                
                var formData = new FormData();
                var fileInput = document.getElementById('excel_file');
                
                if (!fileInput || !fileInput.files || !fileInput.files.length) {
                    alert('Vui lòng chọn file');
                    return;
                }
                var catSelect = document.getElementById('import_category_id');
                if (catSelect && catSelect.required && !catSelect.value) {
                    alert('Vui lòng chọn danh mục');
                    return;
                }
                
                formData.append('excel_file', fileInput.files[0]);
                formData.append('action', 'import_excel');
                var catId = $('#import_category_id').val();
                if (catId) formData.append('category_id', catId);
                
                // Hiển thị progress
                $('#importProgress').show();
                $('#importResult').hide().html('');
                $('button[type="submit"]').prop('disabled', true);
                
                $.ajax({
                    url: '{$system["system_url"]}/buy-account',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        $('#importProgress').hide();
                        $('button[type="submit"]').prop('disabled', false);
                        
                        if (response && response.success) {
                            var successHtml = '<div class="alert alert-success">' +
                                '<i class="fa fa-check-circle mr-2"></i>' +
                                '<strong>Thành công!</strong><br>' +
                                (response.message || 'Import thành công');
                            
                            if (response.success_count !== undefined) {
                                successHtml += '<br><small>Đã import: ' + response.success_count + ' tài khoản</small>';
                            }
                            
                            if (response.errors && response.errors.length > 0) {
                                successHtml += '<br><small class="text-warning">Có ' + response.errors.length + ' lỗi xảy ra</small>';
                            }
                            
                            successHtml += '</div>';
                            
                            // Hiển thị chi tiết lỗi nếu có
                            if (response.errors && response.errors.length > 0) {
                                successHtml += '<div class="alert alert-warning mt-2">' +
                                    '<strong>Chi tiết lỗi:</strong><ul class="mb-0">';
                                response.errors.forEach(function(error) {
                                    successHtml += '<li>' + error + '</li>';
                                });
                                successHtml += '</ul></div>';
                            }
                            
                            $('#importResult').html(successHtml).show();
                            
                            // Reset form
                            var form = document.getElementById('importExcelForm');
                            if (form) form.reset();
                            
                            // Reload page sau 3 giây nếu không có lỗi
                            if (!response.errors || response.errors.length === 0) {
                                setTimeout(function() {
                                    location.reload();
                                }, 3000);
                            }
                        } else {
                            var errorHtml = '<div class="alert alert-danger">' +
                                '<i class="fa fa-exclamation-circle mr-2"></i>' +
                                '<strong>Lỗi!</strong><br>' +
                                (response && response.message ? response.message : 'Có lỗi xảy ra');
                            
                            // Hiển thị chi tiết lỗi nếu có
                            if (response && response.errors && response.errors.length > 0) {
                                errorHtml += '<br><br><strong>Chi tiết lỗi:</strong><ul class="mb-0 mt-2">';
                                response.errors.forEach(function(error) {
                                    errorHtml += '<li>' + error + '</li>';
                                });
                                errorHtml += '</ul>';
                            }
                            
                            errorHtml += '</div>';
                            
                            $('#importResult').html(errorHtml).show();
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#importProgress').hide();
                        $('button[type="submit"]').prop('disabled', false);
                        
                        var errorMsg = 'Có lỗi xảy ra khi upload file';
                        var errorDetails = '';
                        
                        try {
                            if (xhr.responseText) {
                                var response = JSON.parse(xhr.responseText);
                                if (response && response.message) {
                                    errorMsg = response.message;
                                }
                                
                                // Hiển thị chi tiết lỗi nếu có
                                if (response && response.errors && response.errors.length > 0) {
                                    errorDetails = '<br><br><strong>Chi tiết lỗi:</strong><ul class="mb-0 mt-2">';
                                    response.errors.forEach(function(err) {
                                        errorDetails += '<li>' + err + '</li>';
                                    });
                                    errorDetails += '</ul>';
                                }
                            } else {
                                errorMsg += '<br><small>Status: ' + status + ', Error: ' + error + '</small>';
                                if (xhr.status) {
                                    errorMsg += '<br><small>HTTP Status: ' + xhr.status + '</small>';
                                }
                            }
                        } catch(e) {
                            console.error('Error parsing response:', e);
                            errorMsg += '<br><small>Không thể phân tích phản hồi từ server</small>';
                            if (xhr.responseText) {
                                errorMsg += '<br><small>Response: ' + xhr.responseText.substring(0, 200) + '</small>';
                            }
                        }
                        
                        $('#importResult').html(
                            '<div class="alert alert-danger">' +
                            '<i class="fa fa-exclamation-circle mr-2"></i>' +
                            '<strong>Lỗi!</strong><br>' +
                            errorMsg +
                            errorDetails +
                            '</div>'
                        ).show();
                    }
                });
            });
            
            // Preselect category khi mở từ trang danh mục
            $(document).on('show.bs.modal', '#importExcelModal', function(e) {
                var btn = $(e.relatedTarget);
                var preselect = btn && btn.data('preselect-category');
                if (preselect && $('#import_category_id').length) {
                    $('#import_category_id').val(preselect);
                }
            });
            
            // Reset modal khi đóng
            $('#importExcelModal').on('hidden.bs.modal', function() {
                var form = document.getElementById('importExcelForm');
                if (form) form.reset();
                $('#importProgress').hide();
                $('#importResult').hide().html('');
            });
        });
    }
    
        // Khởi tạo ngay hoặc đợi DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initImportExcel);
        } else {
            initImportExcel();
        }
    })();
    
    // Form thêm danh mục
    (function() {
        function initAddCategory() {
            if (typeof jQuery === 'undefined') {
                setTimeout(initAddCategory, 100);
                return;
            }
            var $ = jQuery;
            var form = document.getElementById('addCategoryForm');
            if (!form) return;
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                var submitBtn = $('#addCategorySubmit');
                var resultDiv = $('#addCategoryResult');
                submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i>Đang xử lý...');
                resultDiv.hide().html('');
                
                var formData = new FormData(form);
                var catId = $('#form_category_id').val();
                var isEdit = !!catId;
                formData.set('action', isEdit ? 'edit_category' : 'add_category');
                if (isEdit) formData.set('category_id', catId);
                
                $.ajax({
                    url: '{$system["system_url"]}/buy-account',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(res) {
                        var btnTxt = isEdit ? 'Cập nhật' : 'Thêm danh mục';
                        submitBtn.prop('disabled', false).html('<i class="fa fa-' + (isEdit ? 'save' : 'plus') + ' mr-1"></i>' + btnTxt);
                        if (res && res.success) {
                            resultDiv.html('<div class="alert alert-success mb-0"><i class="fa fa-check mr-2"></i>' + res.message + '</div>').show();
                            if (res.reload) {
                                setTimeout(function() { location.reload(); }, 1000);
                            }
                        } else {
                            resultDiv.html('<div class="alert alert-danger mb-0"><i class="fa fa-exclamation mr-2"></i>' + (res && res.message ? res.message : 'Có lỗi xảy ra') + '</div>').show();
                        }
                    },
                    error: function(xhr) {
                        var btnTxt = $('#form_category_id').val() ? 'Cập nhật' : 'Thêm danh mục';
                        submitBtn.prop('disabled', false).html('<i class="fa fa-plus mr-1"></i>' + btnTxt);
                        var msg = 'Có lỗi xảy ra';
                        try {
                            var r = JSON.parse(xhr.responseText);
                            if (r && r.message) msg = r.message;
                        } catch(ex) {}
                        resultDiv.html('<div class="alert alert-danger mb-0"><i class="fa fa-exclamation mr-2"></i>' + msg + '</div>').show();
                    }
                });
            });
            
            $('#addCategoryModal').on('hidden.bs.modal', function() {
                form.reset();
                $('#form_category_id').val('');
                $('#categoryModalTitle').text('Thêm danh mục mới');
                $('#categorySubmitText').text('Thêm danh mục');
                $('#categoryCurrentImageWrap').hide();
                $('#addCategoryResult').hide().html('');
            });
            
            // Nút mở modal Thêm danh mục
            $(document).on('click', '#btnAddCategory, #btnAddCategoryEmpty', function() {
                $('#form_category_id').val('');
                $('#categoryModalTitle').text('Thêm danh mục mới');
                $('#categorySubmitText').text('Thêm danh mục');
                $('#categoryCurrentImageWrap').hide();
                $('#addCategoryModal').modal('show');
            });
            
            // Nút Sửa danh mục
            $(document).on('click', '.btn-edit-category', function() {
                var btn = $(this);
                $('#form_category_id').val(btn.data('id'));
                $('#category_name').val(btn.data('name'));
                $('#category_slug').val(btn.data('slug'));
                $('#category_price').val(btn.data('price'));
                $('#category_description').val(btn.data('desc') || '');
                $('#category_image').val('');
                $('#categoryModalTitle').text('Sửa danh mục');
                $('#categorySubmitText').text('Cập nhật');
                if (btn.data('image')) {
                    $('#categoryCurrentImage').attr('src', '{$system["system_uploads"]}/' + btn.data('image'));
                    $('#categoryCurrentImageWrap').show();
                } else {
                    $('#categoryCurrentImageWrap').hide();
                }
                $('#addCategoryModal').modal('show');
            });
            
            // Nút Xóa danh mục - dùng confirm() của hệ thống (callback) thay vì confirm native
            $(document).on('click', '.btn-delete-category', function() {
                var btn = $(this);
                var id = parseInt(btn.data('id'), 10) || 0;
                var name = btn.data('name') || '';
                if (!id) { alert('ID danh mục không hợp lệ'); return; }
                if (typeof confirm === 'function' && confirm.length >= 3) {
                    confirm('Xóa danh mục', 'Bạn có chắc muốn xóa danh mục "' + name + '"? Các tài khoản trong danh mục sẽ không còn được phân loại.', function() {
                        $.ajax({
                            url: '{$system["system_url"]}/buy-account',
                            type: 'POST',
                            data: { action: 'delete_category', category_id: id },
                            dataType: 'json',
                            success: function(res) {
                                if (typeof button_status === 'function') button_status($('#modal-confirm-ok'), 'reset');
                                if (res && res.success) {
                                    alert(res.message);
                                    if (res.reload) location.reload();
                                } else {
                                    alert(res && res.message ? res.message : 'Có lỗi xảy ra');
                                }
                            },
                            error: function(xhr) {
                                if (typeof button_status === 'function') button_status($('#modal-confirm-ok'), 'reset');
                                var msg = 'Có lỗi xảy ra';
                                try {
                                    var r = typeof xhr.responseText === 'string' ? JSON.parse(xhr.responseText) : null;
                                    if (r && r.message) msg = r.message;
                                } catch(e) {}
                                alert(msg);
                            }
                        });
                    });
                } else {
                    if (!window.confirm('Bạn có chắc muốn xóa danh mục "' + name + '"? Các tài khoản trong danh mục sẽ không còn được phân loại.')) return;
                    $.ajax({
                        url: '{$system["system_url"]}/buy-account',
                        type: 'POST',
                        data: { action: 'delete_category', category_id: id },
                        dataType: 'json',
                        success: function(res) {
                            if (res && res.success) {
                                alert(res.message);
                                if (res.reload) location.reload();
                            } else {
                                alert(res && res.message ? res.message : 'Có lỗi xảy ra');
                            }
                        },
                        error: function(xhr) {
                            var msg = 'Có lỗi xảy ra';
                            try {
                                var r = typeof xhr.responseText === 'string' ? JSON.parse(xhr.responseText) : null;
                                if (r && r.message) msg = r.message;
                            } catch(e) {}
                            alert(msg);
                        }
                    });
                }
            });
            
            // Fallback: đóng modal khi click nút Đóng/Close (Bootstrap 5)
            $('#addCategoryModal, #importExcelModal').find('[data-bs-dismiss="modal"], .btn-close, .btn-secondary[type="button"]').on('click', function() {
                var modal = $(this).closest('.modal');
                if (modal.length) modal.modal('hide');
            });
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initAddCategory);
        } else {
            initAddCategory();
        }
    })();
    
    // Đảm bảo nút mở modal hoạt động
    (function() {
        function initModalButton() {
            if (typeof jQuery === 'undefined') {
                setTimeout(initModalButton, 100);
                return;
            }
            
            var $ = jQuery;
            var btnImport = document.getElementById('btnImportExcel');
            var btnAddCat = document.getElementById('btnAddCategory') || document.getElementById('btnAddCategoryEmpty');
            if (btnAddCat) {
                btnAddCat.addEventListener('click', function(e) {
                    e.preventDefault();
                    var m = document.getElementById('addCategoryModal');
                    if (m && typeof $.fn.modal !== 'undefined') $('#addCategoryModal').modal('show');
                });
            }
            if (btnImport) {
                btnImport.addEventListener('click', function(e) {
                    e.preventDefault();
                    var modal = document.getElementById('importExcelModal');
                    if (modal) {
                        // Sử dụng Bootstrap modal nếu có
                        if (typeof $.fn.modal !== 'undefined') {
                            $('#importExcelModal').modal('show');
                        } else {
                            // Fallback: hiển thị modal bằng CSS
                            modal.style.display = 'block';
                            modal.classList.add('show');
                            document.body.classList.add('modal-open');
                            
                            // Thêm backdrop
                            var backdrop = document.createElement('div');
                            backdrop.className = 'modal-backdrop fade show';
                            backdrop.id = 'importExcelBackdrop';
                            document.body.appendChild(backdrop);
                            
                            // Đóng modal khi click backdrop
                            backdrop.addEventListener('click', function() {
                                modal.style.display = 'none';
                                modal.classList.remove('show');
                                document.body.classList.remove('modal-open');
                                document.body.removeChild(backdrop);
                            });
                        }
                    }
                });
            }
        }
        
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initModalButton);
        } else {
            initModalButton();
        }
    })();
</script>
{/if}

{if $view == 'details' && isset($account)}
<script>
// Toggle password visibility
function togglePassword() {
    var display = document.getElementById('passwordDisplay');
    var icon = document.getElementById('passwordToggleIcon');
    if (display && icon) {
        if (display.textContent === '••••••••') {
            display.textContent = '{$account.Pass|escape:"javascript"}';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            display.textContent = '••••••••';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
}

// Copy from DOM element (handles long text, special chars). btnEl: optional button for visual feedback
function copyFromElement(el, btnEl) {
    if (!el) return;
    var text = el.value !== undefined ? el.value : (el.textContent || el.innerText || '');
    copyToClipboard(text, btnEl);
}

function showCopyFeedback(btn) {
    if (!btn) return;
    var html = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-check"></i> Đã copy!';
    btn.classList.remove('btn-outline-primary');
    btn.classList.add('btn-success');
    setTimeout(function() {
        btn.disabled = false;
        btn.innerHTML = html;
        btn.classList.add('btn-outline-primary');
        btn.classList.remove('btn-success');
    }, 1500);
}

// Copy to clipboard
function copyToClipboard(text, btnEl) {
    function onSuccess() {
        showCopyFeedback(btnEl);
    }
    function onError() {
        if (typeof modal === 'function') {
            modal('#modal-error', { title: 'Thông báo', message: 'Không thể copy. Vui lòng copy thủ công.' });
        } else {
            alert('Không thể copy. Vui lòng copy thủ công.');
        }
    }
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(function() {
            onSuccess();
        }).catch(function(err) {
            console.error('Failed to copy:', err);
            fallbackCopyToClipboard(text, btnEl, onSuccess, onError);
        });
    } else {
        fallbackCopyToClipboard(text, btnEl, onSuccess, onError);
    }
}

function fallbackCopyToClipboard(text, btnEl, onSuccess, onError) {
    var textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.position = "fixed";
    textArea.style.left = "-999999px";
    textArea.style.top = "-999999px";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        var ok = document.execCommand('copy');
        document.body.removeChild(textArea);
        if (ok) onSuccess(); else onError();
    } catch (err) {
        console.error('Fallback copy failed:', err);
        if (document.body.contains(textArea)) document.body.removeChild(textArea);
        onError();
    }
}

// Buy account function
function buyAccount(accountId) {
    if (!confirm('Bạn có chắc muốn mua tài khoản này?')) {
        return;
    }
    
    // TODO: Implement buy account logic
    alert('Chức năng mua tài khoản đang được phát triển. Account ID: ' + accountId);
}

</script>

{if $view == 'category'}
<script>
(function() {
    function initBuyForm() {
        if (typeof jQuery === 'undefined') {
            setTimeout(initBuyForm, 100);
            return;
        }
        
        var $ = jQuery;
        var unitPrice = parseFloat($('#unit_price').val() || 0);
        var maxQuantity = parseInt($('#quantity').attr('max') || 0);
        var userBalance = parseFloat($('#user_balance').val() || 0);
        
        // Update total price when quantity changes
        $('#quantity').on('input', function() {
            var quantity = parseInt($(this).val() || 1);
            if (quantity < 1) quantity = 1;
            if (quantity > maxQuantity) quantity = maxQuantity;
            $(this).val(quantity);
            
            var total = unitPrice * quantity;
            $('#totalPrice').text(total.toLocaleString('vi-VN') + ' đ');
        });
        
        // Handle form submit - dùng confirm callback (app dùng modal confirm thay vì window.confirm)
        var buyInProgress = false;
        $('#buyAccountForm').on('submit', function(e) {
            e.preventDefault();
            
            if (buyInProgress) return;
            
            var categoryId = $('#category_id').val();
            var quantity = parseInt($('#quantity').val() || 1);
            
            if (!categoryId || quantity < 1) {
                if (typeof modal === 'function') modal('#modal-error', { title: 'Thông báo', message: 'Vui lòng nhập số lượng hợp lệ' });
                else alert('Vui lòng nhập số lượng hợp lệ');
                return;
            }
            
            var totalPrice = unitPrice * quantity;
            
            // Kiểm tra số dư trước khi mua
            if (userBalance < totalPrice) {
                var needMore = (totalPrice - userBalance).toLocaleString('vi-VN');
                var msg = 'Số dư không đủ. Bạn cần nạp thêm ' + needMore + ' đ để thực hiện giao dịch.';
                if (typeof modal === 'function') modal('#modal-error', { title: 'Thông báo', message: msg });
                else alert(msg);
                return;
            }
            
            buyInProgress = true;
            var $btn = $('#buyBtn');
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i>Đang xử lý...');
            
            var totalAmount = totalPrice.toLocaleString('vi-VN') + ' đ';
            var doBuyCalled = false;
            
            // Re-enable khi user đóng modal mà không xác nhận
            $('#modal-confirm').one('hidden.bs.modal', function() {
                if (!doBuyCalled) {
                    buyInProgress = false;
                    $btn.prop('disabled', false).html('<i class="fa fa-shopping-cart mr-1"></i>Mua ngay');
                }
            });
            
            function doBuy() {
                doBuyCalled = true;
                var formData = {
                    action: 'buy_accounts',
                    category_id: categoryId,
                    quantity: quantity
                };
                
                $('#buyResult').hide().html('');
                
                $.ajax({
                    url: '{$system["system_url"]}/buy-account',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        buyInProgress = false;
                        $('#buyBtn').prop('disabled', false).html('<i class="fa fa-shopping-cart mr-1"></i>Mua ngay');
                        
                        if (response && response.success) {
                            $('#buyResult').html(
                                '<div class="alert alert-success">' +
                                '<i class="fa fa-check-circle mr-2"></i>' +
                                '<strong>Thành công!</strong><br>' +
                                response.message +
                                '<br><a href="{$system["system_url"]}/buy-account?view=my-accounts" class="alert-link mt-2 d-inline-block">Xem tài khoản đã mua ngay</a>' +
                                '</div>'
                            ).show();
                            
                            if (response.redirect_url) {
                                setTimeout(function() {
                                    window.location.href = response.redirect_url;
                                }, 1500);
                            }
                        } else {
                            $('#buyResult').html(
                                '<div class="alert alert-danger">' +
                                '<i class="fa fa-exclamation-circle mr-2"></i>' +
                                '<strong>Lỗi!</strong><br>' +
                                (response && response.message ? response.message : 'Có lỗi xảy ra') +
                                '</div>'
                            ).show();
                        }
                    },
                    error: function(xhr, status, error) {
                        buyInProgress = false;
                        $('#buyBtn').prop('disabled', false).html('<i class="fa fa-shopping-cart mr-1"></i>Mua ngay');
                        
                        var errorMsg = 'Có lỗi xảy ra khi đặt hàng';
                        try {
                            if (xhr.responseText) {
                                var resp = JSON.parse(xhr.responseText);
                                if (resp && resp.message) errorMsg = resp.message;
                            }
                        } catch(e) {}
                        
                        $('#buyResult').html(
                            '<div class="alert alert-danger">' +
                            '<i class="fa fa-exclamation-circle mr-2"></i>' +
                            '<strong>Lỗi!</strong><br>' + errorMsg + '</div>'
                        ).show();
                    }
                });
            }
            
            // Sử dụng confirm modal của app (callback khi user bấm OK)
            if (typeof confirm === 'function' && confirm.length >= 3) {
                confirm('Xác nhận mua', 'Bạn có chắc muốn mua ' + quantity + ' tài khoản với tổng tiền ' + totalAmount + '?', function() {
                    try {
                        $('#modal-confirm').modal('hide');
                        if (typeof button_status === 'function') {
                            button_status($('#modal-confirm-ok'), 'reset');
                        }
                    } catch(e) {}
                    doBuy();
                });
            } else {
                if (window.confirm('Bạn có chắc muốn mua ' + quantity + ' tài khoản với tổng tiền ' + totalAmount + '?')) {
                    doBuy();
                }
            }
        });
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBuyForm);
    } else {
        initBuyForm();
    }
})();
</script>
{/if}
{/if}

{if $view == 'order'}
<script>
// Copy functions - cần cho nút Copy trong bảng đơn hàng
function copyFromElement(el, btnEl) {
    if (!el) return;
    var text = el.value !== undefined ? el.value : (el.textContent || el.innerText || '');
    copyToClipboard(text, btnEl);
}
function showCopyFeedback(btn) {
    if (!btn) return;
    var html = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-check"></i> Đã copy!';
    btn.classList.remove('btn-outline-primary');
    btn.classList.add('btn-success');
    setTimeout(function() {
        btn.disabled = false;
        btn.innerHTML = html;
        btn.classList.add('btn-outline-primary');
        btn.classList.remove('btn-success');
    }, 1500);
}
function copyToClipboard(text, btnEl) {
    function onSuccess() {
        showCopyFeedback(btnEl);
    }
    function onError() {
        if (typeof modal === 'function') {
            modal('#modal-error', { title: 'Thông báo', message: 'Không thể copy. Vui lòng copy thủ công.' });
        } else {
            alert('Không thể copy. Vui lòng copy thủ công.');
        }
    }
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(function() { onSuccess(); }).catch(function(err) {
            console.error('Failed to copy:', err);
            fallbackCopyToClipboard(text, btnEl, onSuccess, onError);
        });
    } else {
        fallbackCopyToClipboard(text, btnEl, onSuccess, onError);
    }
}
function fallbackCopyToClipboard(text, btnEl, onSuccess, onError) {
    var textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.position = "fixed";
    textArea.style.left = "-999999px";
    textArea.style.top = "-999999px";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        var ok = document.execCommand('copy');
        document.body.removeChild(textArea);
        if (ok) onSuccess(); else onError();
    } catch (err) {
        console.error('Fallback copy failed:', err);
        if (document.body.contains(textArea)) document.body.removeChild(textArea);
        onError();
    }
}
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', function(e) {
            var el = e.target.closest('.expandable-cell');
            if (el) {
                e.preventDefault();
                el.classList.toggle('expanded');
                if (el.classList.contains('expanded')) {
                    el.style.maxWidth = 'none';
                    el.style.whiteSpace = 'normal';
                    el.title = 'Nhấn để thu gọn';
                } else {
                    el.style.maxWidth = '150px';
                    el.style.whiteSpace = 'nowrap';
                    el.title = 'Nhấn để mở rộng';
                }
            }
        });
    });
})();
</script>
<style>
.expandable-cell { transition: max-width 0.2s ease; }
</style>
{/if}

{if $view == 'list'}
<script>
(function() {
    function initListBuyForms() {
        if (typeof jQuery === 'undefined') {
            setTimeout(initListBuyForms, 100);
            return;
        }
        var $ = jQuery;
        var buyInProgress = false;
        var systemUrl = '{$system["system_url"]}';
        
        $(document).on('submit', '.buy-quick-form', function(e) {
            e.preventDefault();
            if (buyInProgress) return;
            
            var $form = $(this);
            var categoryId = $form.data('category-id');
            var unitPrice = parseFloat($form.data('unit-price') || 0);
            var maxQty = parseInt($form.data('max') || 0);
            var userBalance = parseFloat($form.data('user-balance') || 0);
            var quantity = parseInt($form.find('.quantity-input').val() || 1);
            
            if (!categoryId || quantity < 1) {
                if (typeof modal === 'function') modal('#modal-error', { title: 'Thông báo', message: 'Vui lòng nhập số lượng hợp lệ' });
                else alert('Vui lòng nhập số lượng hợp lệ');
                return;
            }
            if (quantity > maxQty) {
                if (typeof modal === 'function') modal('#modal-error', { title: 'Thông báo', message: 'Số lượng tối đa là ' + maxQty + ' tài khoản' });
                else alert('Số lượng tối đa là ' + maxQty + ' tài khoản');
                return;
            }
            
            var totalPrice = unitPrice * quantity;
            if (userBalance < totalPrice) {
                var needMore = (totalPrice - userBalance).toLocaleString('vi-VN');
                var msg = 'Số dư không đủ. Bạn cần nạp thêm ' + needMore + ' đ để thực hiện giao dịch.';
                if (typeof modal === 'function') modal('#modal-error', { title: 'Thông báo', message: msg });
                else alert(msg);
                return;
            }
            
            var totalAmount = totalPrice.toLocaleString('vi-VN') + ' đ';
            var $btn = $form.find('button[type="submit"]');
            var $result = $form.find('.buy-quick-result');
            var doBuyCalled = false;
            
            buyInProgress = true;
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            $result.hide().html('');
            
            $('#modal-confirm').one('hidden.bs.modal', function() {
                if (!doBuyCalled) {
                    buyInProgress = false;
                    $btn.prop('disabled', false).html('<i class="fa fa-shopping-cart mr-1"></i>Mua ngay');
                }
            });
            
            function doBuy() {
                doBuyCalled = true;
                $.ajax({
                    url: systemUrl + '/buy-account',
                    type: 'POST',
                    data: { action: 'buy_accounts', category_id: categoryId, quantity: quantity },
                    dataType: 'json',
                    success: function(response) {
                        buyInProgress = false;
                        $btn.prop('disabled', false).html('<i class="fa fa-shopping-cart mr-1"></i>Mua ngay');
                        
                        if (response && response.success) {
                            var orderUrl = response.redirect_url || (systemUrl + '/buy-account?view=order&order_id=' + (response.order_id || ''));
                            $result.html(
                                '<div class="alert alert-success py-2 mb-0 mt-1">' +
                                '<i class="fa fa-check-circle mr-1"></i>' + (response.message || 'Đặt hàng thành công!') +
                                '<br><a href="' + orderUrl + '" class="alert-link">Xem chi tiết đơn hàng</a>' +
                                '</div>'
                            ).show();
                            if (response.redirect_url) {
                                setTimeout(function() { window.location.href = response.redirect_url; }, 2000);
                            }
                        } else {
                            $result.html('<div class="alert alert-danger py-2 mb-0 mt-1">' + (response && response.message ? response.message : 'Có lỗi xảy ra') + '</div>').show();
                        }
                    },
                    error: function(xhr) {
                        buyInProgress = false;
                        $btn.prop('disabled', false).html('<i class="fa fa-shopping-cart mr-1"></i>Mua ngay');
                        var msg = 'Có lỗi xảy ra';
                        try {
                            if (xhr.responseText) {
                                var r = JSON.parse(xhr.responseText);
                                if (r && r.message) msg = r.message;
                            }
                        } catch(e) {}
                        $result.html('<div class="alert alert-danger py-2 mb-0 mt-1">' + msg + '</div>').show();
                    }
                });
            }
            
            if (typeof confirm === 'function' && confirm.length >= 3) {
                confirm('Xác nhận mua', 'Bạn có chắc muốn mua ' + quantity + ' tài khoản với tổng tiền ' + totalAmount + '?', function() {
                    try { $('#modal-confirm').modal('hide'); if (typeof button_status === 'function') button_status($('#modal-confirm-ok'), 'reset'); } catch(e) {}
                    doBuy();
                });
            } else {
                if (window.confirm('Bạn có chắc muốn mua ' + quantity + ' tài khoản với tổng tiền ' + totalAmount + '?')) doBuy();
            }
        });
        
        $('.quantity-input').on('input', function() {
            var $input = $(this);
            var max = parseInt($input.attr('max') || 999);
            var val = parseInt($input.val() || 1);
            if (val < 1) $input.val(1);
            else if (val > max) $input.val(max);
        });
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initListBuyForms);
    } else {
        initListBuyForms();
    }
})();
</script>
{/if}

{include file='_footer.tpl'}
