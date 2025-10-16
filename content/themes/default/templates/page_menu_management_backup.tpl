{* Template quản lý menu cho chủ page ẩm thực *}
<div class="card">
  <div class="card-header with-icon with-nav">
    <!-- panel title -->
    <div class="mb20">
      <div class="float-end">
        <a href="{$system['system_url']}/pages/{$spage['page_name']}" class="btn btn-md btn-info">
          <i class="fa fa-eye mr5"></i>Xem thực đơn công khai
        </a>
        <button class="btn btn-md btn-primary" data-bs-toggle="modal" data-bs-target="#add-menu-item">
          <i class="fa fa-plus mr5"></i>Thêm món mới
        </button>
      </div>
      
      <i class="fa fa-utensils mr10"></i>Quản lý thực đơn - {$spage['page_title']}
    </div>
    <!-- panel title -->

    <!-- panel nav -->
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link {if $menu_view == "" || $menu_view == "items"}active{/if}" href="{$system['system_url']}/pages/{$spage['page_name']}/settings?view=menu&menu_view=items">
          <i class="fa fa-list fa-fw mr5"></i><strong>Danh sách món</strong>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {if $menu_view == "categories"}active{/if}" href="{$system['system_url']}/pages/{$spage['page_name']}/settings?view=menu&menu_view=categories">
          <i class="fa fa-folder fa-fw mr5"></i><strong>Danh mục</strong>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {if $menu_view == "settings"}active{/if}" href="{$system['system_url']}/pages/{$spage['page_name']}/settings?view=menu&menu_view=settings">
          <i class="fa fa-cog fa-fw mr5"></i><strong>Cài đặt</strong>
        </a>
      </li>
    </ul>
    <!-- panel nav -->
  </div>

  {if $menu_view == "categories"}
    <!-- Categories Management -->
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <h4>Quản lý danh mục thực đơn</h4>
          <p class="text-muted">Tạo và sắp xếp các danh mục cho thực đơn của bạn</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-category">
          <i class="fa fa-plus"></i> Thêm danh mục
        </button>
      </div>

      {if $menu_categories}
        <div class="row">
          {foreach $menu_categories as $category}
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card category-card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="card-title mb-0">
                      <i class="{$category.category_icon} mr-2"></i>
                      {$category.category_name}
                    </h6>
                    <div class="dropdown">
                      <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                        <i class="fa fa-ellipsis-v"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#" onclick="editCategory({$category.category_id})">
                          <i class="fa fa-edit mr-2"></i> Sửa
                        </a>
                        <a class="dropdown-item text-danger" href="#" onclick="deleteCategory({$category.category_id})">
                          <i class="fa fa-trash mr-2"></i> Xóa
                        </a>
                      </div>
                    </div>
                  </div>
                  
                  <div class="category-stats">
                    <small class="text-muted">
                      <i class="fa fa-utensils mr-1"></i>
                      {$category.items_count} món ăn
                    </small>
                    <br>
                    <small class="text-muted">
                      <i class="fa fa-sort mr-1"></i>
                      Thứ tự: {$category.display_order}
                    </small>
                  </div>
                </div>
              </div>
            </div>
          {/foreach}
        </div>
      {else}
        <div class="text-center py-5">
          <div class="empty-state">
            <i class="fa fa-folder-open fa-3x text-muted mb-3"></i>
            <h5>Chưa có danh mục nào</h5>
            <p class="text-muted">Bắt đầu bằng cách thêm danh mục đầu tiên cho thực đơn của bạn</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-category">
              <i class="fa fa-plus"></i> Thêm danh mục đầu tiên
            </button>
          </div>
        </div>
      {/if}
    </div>

  {elseif $menu_view == "settings"}
    <!-- Menu Settings -->
    <div class="card-body">
      <h4>Cài đặt thực đơn</h4>
      <p class="text-muted">Cấu hình hiển thị và hoạt động của thực đơn</p>
      
      <form class="ajax-form" data-url="includes/ajax/pages/menu.php?do=update_settings&page_id={$spage['page_id']}">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Tiêu đề thực đơn</label>
              <input type="text" class="form-control" name="menu_title" value="Thực đơn của chúng tôi" placeholder="Thực đơn của chúng tôi">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Mô tả thực đơn</label>
              <input type="text" class="form-control" name="menu_description" value="Khám phá các món ngon tại {$spage['page_title']}" placeholder="Mô tả ngắn về thực đơn">
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Hiển thị giá</label>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="show_prices" checked>
                <label class="form-check-label">Hiển thị giá món ăn</label>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Hiển thị ảnh</label>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="show_images" checked>
                <label class="form-check-label">Hiển thị ảnh món ăn</label>
              </div>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Cho phép đặt món</label>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="allow_ordering">
                <label class="form-check-label">Khách hàng có thể đặt món trực tuyến</label>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Hiển thị trạng thái</label>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="show_availability" checked>
                <label class="form-check-label">Hiển thị "Còn hàng/Hết hàng"</label>
              </div>
            </div>
          </div>
        </div>
        
        <div class="form-group">
          <label class="form-label">Ghi chú thêm</label>
          <textarea class="form-control" name="menu_notes" rows="3" placeholder="Ghi chú về giờ phục vụ, điều kiện đặt món...">Thực đơn có thể thay đổi theo mùa. Vui lòng liên hệ để biết thêm chi tiết.</textarea>
        </div>
        
        <div class="form-group">
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Lưu cài đặt
          </button>
        </div>
      </form>
    </div>

  {else}
    <!-- Menu Items Management -->
    <div class="card-body">
      <div class="row mb20">
        <div class="col-md-8">
          <h4>Quản lý món ăn</h4>
          <p class="text-muted">Thêm, sửa, xóa các món ăn trong thực đơn của bạn</p>
        </div>
        <div class="col-md-4 text-end">
          <select class="form-select" id="filter-category" onchange="filterByCategory(this.value)">
            <option value="">Tất cả danh mục</option>
            {foreach $menu_categories as $category}
              <option value="{$category.category_id}">{$category.category_name}</option>
            {/foreach}
          </select>
        </div>
      </div>

      {if $menu_categories}
        {foreach $menu_categories as $category}
          <div class="menu-category-section mb40" data-category-id="{$category.category_id}">
            <h5 class="menu-category-header">
              <i class="{$category.category_icon} mr10"></i>
              {$category.category_name}
              <small class="text-muted">({$category.items_count} món)</small>
              <button class="btn btn-sm btn-outline-primary float-end" onclick="editCategory({$category.category_id})">
                <i class="fa fa-edit mr5"></i>Sửa danh mục
              </button>
            </h5>

            {if $category.items}
              <div class="row">
                {foreach $category.items as $item}
                  <div class="col-lg-6 col-xl-4 mb20">
                    <div class="menu-admin-item-card">
                      <div class="menu-admin-item-image">
                        {if $item.item_image}
                          <img src="{$item.item_image}" alt="{$item.item_name}">
                        {else}
                          <div class="no-image-placeholder">
                            <i class="fa fa-image fa-2x text-muted"></i>
                            <p>Chưa có ảnh</p>
                          </div>
                        {/if}
                        
                        <div class="item-admin-actions">
                          <button class="btn btn-sm btn-light" onclick="editMenuItem({$item.item_id}, {
                            name: '{$item.item_name|escape:'javascript'}',
                            price: {$item.item_price},
                            description: '{$item.item_description|escape:'javascript'}',
                            image: '{$item.item_image|escape:'javascript'}',
                            is_popular: '{$item.is_popular}',
                            is_available: '{$item.is_available}'
                          })" title="Sửa món">
                            <i class="fa fa-edit"></i>
                          </button>
                          <button class="btn btn-sm btn-danger" onclick="deleteMenuItem({$item.item_id})" title="Xóa món">
                            <i class="fa fa-trash"></i>
                          </button>
                        </div>

                        {if $item.is_popular == '1'}
                          <span class="popular-admin-badge">HOT</span>
                        {/if}
                        
                        {if $item.is_available == '0'}
                          <span class="unavailable-admin-badge">HẾT HÀNG</span>
                        {/if}
                      </div>
                      
                      <div class="menu-admin-item-content">
                        <h6 class="item-name">{$item.item_name}</h6>
                        <p class="item-description">{$item.item_description|truncate:80}</p>
                        
                        <div class="item-admin-footer">
                          <div class="item-price">
                            <strong>{$item.item_price|number_format:0:",":"."} đ</strong>
                          </div>
                          
                          <div class="item-status-toggle">
                            <label class="switch">
                              <input type="checkbox" {if $item.is_available == '1'}checked{/if} 
                                     onchange="toggleItemAvailability({$item.item_id}, this.checked)">
                              <span class="slider round"></span>
                            </label>
                            <small class="d-block mt-1">
                              {if $item.is_available == '1'}
                                <span class="text-success"><i class="fa fa-check-circle"></i> Còn hàng</span>
                              {else}
                                <span class="text-danger"><i class="fa fa-times-circle"></i> Hết hàng</span>
                              {/if}
                            </small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                {/foreach}
              </div>
            {else}
              <div class="text-center py30">
                <i class="fa fa-utensils fa-2x text-muted mb10"></i>
                <p class="text-muted">Chưa có món nào trong danh mục này</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-menu-item" data-category-id="{$category.category_id}">
                  <i class="fa fa-plus mr5"></i>Thêm món đầu tiên
                </button>
              </div>
            {/if}
          </div>
        {/foreach}
      {else}
        <div class="text-center py50">
          <i class="fa fa-utensils fa-3x text-muted mb20"></i>
          <h5 class="text-muted">Chưa có danh mục nào</h5>
          <p class="text-muted">Tạo danh mục đầu tiên để bắt đầu xây dựng thực đơn</p>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-category">
            <i class="fa fa-folder-plus mr5"></i>Tạo danh mục đầu tiên
          </button>
        </div>
      {/if}
    </div>

  {elseif $menu_view == "categories"}
    <!-- Categories Management -->
    <div class="card-body">
      <div class="row mb20">
        <div class="col-md-8">
          <h4>Quản lý danh mục</h4>
          <p class="text-muted">Tổ chức thực đơn theo các danh mục khác nhau</p>
        </div>
        <div class="col-md-4 text-end">
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-category">
            <i class="fa fa-plus mr5"></i>Thêm danh mục
          </button>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Icon</th>
              <th>Tên danh mục</th>
              <th>Số món</th>
              <th>Thứ tự</th>
              <th>Trạng thái</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            {if $menu_categories}
              {foreach $menu_categories as $category}
                <tr>
                  <td><i class="{$category.category_icon}" style="font-size: 20px; color: #e74c3c;"></i></td>
                  <td><strong>{$category.category_name}</strong></td>
                  <td><span class="badge bg-info">{$category.items_count}</span></td>
                  <td>{$category.display_order}</td>
                  <td>
                    {if $category.is_active == '1'}
                      <span class="badge bg-success">Hoạt động</span>
                    {else}
                      <span class="badge bg-secondary">Tạm dừng</span>
                    {/if}
                  </td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="editCategory({$category.category_id})">
                      <i class="fa fa-edit"></i>
                    </button>
                    {if $category.items_count == 0}
                      <button class="btn btn-sm btn-outline-danger" onclick="deleteCategory({$category.category_id})">
                        <i class="fa fa-trash"></i>
                      </button>
                    {/if}
                  </td>
                </tr>
              {/foreach}
            {/if}
          </tbody>
        </table>
      </div>
    </div>

  {elseif $menu_view == "settings"}
    <!-- Menu Settings -->
    <div class="card-body">
      <h4>Cài đặt thực đơn</h4>
      <p class="text-muted">Tùy chỉnh cách hiển thị thực đơn cho khách hàng</p>

      <form class="js_ajax-forms" data-url="pages/menu.php?do=update_settings&page_id={$spage['page_id']}">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Hiển thị giá</label>
              <select class="form-select" name="show_prices">
                <option value="1">Hiển thị giá</option>
                <option value="0">Ẩn giá</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Layout hiển thị</label>
              <select class="form-select" name="menu_layout">
                <option value="grid">Lưới (Grid)</option>
                <option value="list">Danh sách (List)</option>
                <option value="card">Thẻ (Card)</option>
              </select>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Ký hiệu tiền tệ</label>
          <input type="text" class="form-control" name="currency_symbol" value="đ" maxlength="10">
        </div>

        <div class="card-footer text-end">
          <button type="submit" class="btn btn-primary">Lưu cài đặt</button>
        </div>
      </form>
    </div>
  {/if}
</div>

<!-- Add Menu Item Modal -->
<div class="modal fade" id="add-menu-item" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Thêm món mới</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form class="js_ajax-forms" data-url="includes/ajax/pages/menu.php?do=add_item&page_id={$spage['page_id']}">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Tên món ăn</label>
                <input type="text" class="form-control" name="item_name" required placeholder="Bánh mì thịt nướng">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Giá bán (VNĐ)</label>
                <input type="number" class="form-control" name="item_price" required placeholder="25000" min="0">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Danh mục</label>
            <select class="form-select" name="category_id" required>
              <option value="">Chọn danh mục</option>
              {foreach $menu_categories as $category}
                <option value="{$category.category_id}">{$category.category_name}</option>
              {/foreach}
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">Mô tả món ăn</label>
            <textarea class="form-control" name="item_description" rows="3" placeholder="Mô tả nguyên liệu, cách chế biến..."></textarea>
          </div>

          <div class="form-group">
            <label class="form-label">Hình ảnh món ăn</label>
            <div class="x-image">
              <button type="button" class="btn-close js_x-image-remover" title="Remove"></button>
              <div class="x-image-loader">
                <div class="progress x-progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
              <i class="fa fa-camera fa-2x js_x-uploader" data-handle="x-image"></i>
              <input type="hidden" class="js_x-image-input" name="item_image" value="">
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_popular" id="is_popular">
                <label class="form-check-label" for="is_popular">
                  <i class="fa fa-fire text-danger mr5"></i>Món phổ biến
                </label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_available" id="is_available" checked>
                <label class="form-check-label" for="is_available">
                  Còn hàng
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-primary">Thêm món</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sửa món</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form class="js_ajax-forms" data-url="includes/ajax/pages/menu.php?do=edit_item" id="editItemForm">
        <input type="hidden" name="item_id" id="edit_item_id">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Tên món ăn</label>
                <input type="text" class="form-control" name="item_name" id="edit_item_name" required placeholder="Bánh mì thịt nướng">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Giá (VNĐ)</label>
                <input type="number" class="form-control" name="item_price" id="edit_item_price" required min="0" placeholder="25000">
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label class="form-label">Mô tả món ăn</label>
            <textarea class="form-control" name="item_description" id="edit_item_description" rows="3" placeholder="Bánh mì với thịt heo nướng thơm ngon, rau sống tươi mát..."></textarea>
          </div>
          
          <div class="form-group">
            <label class="form-label">URL hình ảnh</label>
            <input type="url" class="form-control" name="item_image" id="edit_item_image" placeholder="https://example.com/image.jpg">
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_popular" id="edit_is_popular">
                <label class="form-check-label" for="edit_is_popular">
                  🔥 Món hot (nổi bật)
                </label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_available" id="edit_is_available" checked>
                <label class="form-check-label" for="edit_is_available">
                  ✅ Còn hàng
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="add-category" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Thêm danh mục mới</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form class="js_ajax-forms" data-url="includes/ajax/pages/menu.php?do=add_category&page_id={$spage['page_id']}">
        <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Tên danh mục</label>
            <input type="text" class="form-control" name="category_name" required placeholder="Món chính, Tráng miệng...">
          </div>

          <div class="form-group">
            <label class="form-label">Icon</label>
            <input type="text" class="form-control" name="category_icon" placeholder="fa-utensils" value="fa-utensils">
            <small class="form-text text-muted">Class icon FontAwesome</small>
          </div>

          <div class="form-group">
            <label class="form-label">Thứ tự hiển thị</label>
            <input type="number" class="form-control" name="display_order" value="1" min="1">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-primary">Thêm danh mục</button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
.menu-admin-item-card {
  border: 1px solid #e3e6f0;
  border-radius: 8px;
  overflow: hidden;
  background: white;
  position: relative;
}

.menu-admin-item-image {
  height: 150px;
  position: relative;
  overflow: hidden;
}

.menu-admin-item-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.no-image-placeholder {
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background: #f8f9fa;
  color: #6c757d;
}

.item-admin-actions {
  position: absolute;
  top: 8px;
  right: 8px;
  display: flex;
  gap: 5px;
}

.popular-admin-badge {
  position: absolute;
  top: 8px;
  left: 8px;
  background: #ff6b6b;
  color: white;
  padding: 2px 8px;
  border-radius: 10px;
  font-size: 10px;
  font-weight: bold;
}

.unavailable-admin-badge {
  position: absolute;
  bottom: 8px;
  left: 8px;
  background: #6c757d;
  color: white;
  padding: 2px 8px;
  border-radius: 10px;
  font-size: 10px;
}

.menu-admin-item-content {
  padding: 12px;
}

.item-admin-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 10px;
}

.item-price {
  font-size: 16px;
  color: #e74c3c;
  font-weight: bold;
}

.menu-category-header {
  background: #f8f9fa;
  padding: 12px 15px;
  border-radius: 6px;
  border-left: 4px solid #e74c3c;
  margin-bottom: 15px;
}

.category-card {
  border: 1px solid #e9ecef;
  border-radius: 8px;
  transition: all 0.2s;
}

.category-card:hover {
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  transform: translateY(-2px);
}

.category-stats small {
  display: block;
  margin-bottom: 4px;
}

.empty-state {
  padding: 40px 20px;
}
</style>

<script src="{$system['system_url']}/js/page-menu.js"></script>
