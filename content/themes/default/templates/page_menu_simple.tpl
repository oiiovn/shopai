<div class="card">
  <div class="card-header">
    <h4>Quản lý thực đơn</h4>
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link {if $menu_view == "" || $menu_view == "items"}active{/if}" href="{$system['system_url']}/pages/{$spage['page_name']}?view=menu&menu_view=items">
          Danh sách món
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {if $menu_view == "categories"}active{/if}" href="{$system['system_url']}/pages/{$spage['page_name']}?view=menu&menu_view=categories">
          Danh mục
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {if $menu_view == "settings"}active{/if}" href="{$system['system_url']}/pages/{$spage['page_name']}?view=menu&menu_view=settings">
          Cài đặt
        </a>
      </li>
    </ul>
  </div>

  <div class="card-body">
    {if $menu_view == "categories"}
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Quản lý danh mục</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
          <i class="fa fa-plus"></i> Thêm danh mục
        </button>
      </div>

      {if $menu_categories}
        <div class="row">
          {foreach $menu_categories as $category}
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <h6><i class="{$category.category_icon}"></i> {$category.category_name}</h6>
                  <p><small class="text-muted">{$category.items_count} món ăn</small></p>
                  <button class="btn btn-sm btn-info" onclick="editCategory({$category.category_id})">Sửa</button>
                  <button class="btn btn-sm btn-danger" onclick="deleteCategory({$category.category_id})">Xóa</button>
                </div>
              </div>
            </div>
          {/foreach}
        </div>
      {else}
        <div class="text-center py-5">
          <p>Chưa có danh mục nào.</p>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="fa fa-plus"></i> Thêm danh mục đầu tiên
          </button>
        </div>
      {/if}
      
    {elseif $menu_view == "settings"}
      <h5>Cài đặt thực đơn</h5>
      
      <form class="ajax-form" data-url="includes/ajax/pages/menu.php?do=update_settings&page_id={$spage['page_id']}">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Tiêu đề thực đơn</label>
              <input type="text" class="form-control" name="menu_title" value="Thực đơn của chúng tôi">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Mô tả thực đơn</label>
              <input type="text" class="form-control" name="menu_description" value="Khám phá các món ngon tại {$spage['page_title']}">
            </div>
          </div>
        </div>
        
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" name="show_prices" checked>
          <label class="form-check-label">Hiển thị giá món ăn</label>
        </div>
        
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" name="show_images" checked>
          <label class="form-check-label">Hiển thị ảnh món ăn</label>
        </div>
        
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" name="allow_ordering">
          <label class="form-check-label">Cho phép đặt món trực tuyến</label>
        </div>
        
        <div class="form-group mt-3">
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Lưu cài đặt
          </button>
        </div>
      </form>
      
    {else}
      <h5>Danh sách món ăn</h5>
      
      <div class="mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
          <i class="fa fa-plus"></i> Thêm món mới
        </button>
      </div>

      {if $menu_categories}
        {foreach $menu_categories as $category}
          <div class="mb-4">
            <h6><i class="fa fa-utensils"></i> {$category.category_name}</h6>
            
            {if $category.items}
              <div class="row">
                {foreach $category.items as $item}
                  <div class="col-md-6 mb-3">
                    <div class="card">
                      <div class="card-body">
                        <h6>{$item.item_name}</h6>
                        <p>{$item.item_description}</p>
                        <strong>{$item.item_price|number_format:0:",":"."} đ</strong>
                        
                        <div class="mt-2">
                          <div class="form-check form-switch d-inline-block me-3">
                            <input class="form-check-input" type="checkbox" {if $item.is_available == '1'}checked{/if} 
                                   onchange="toggleItemAvailability({$item.item_id}, this.checked)">
                            <label class="form-check-label">
                              {if $item.is_available == '1'}Còn hàng{else}Hết hàng{/if}
                            </label>
                          </div>
                          <button class="btn btn-sm btn-info" onclick="editMenuItem({$item.item_id}, {
                            name: '{$item.item_name|escape:'javascript'}',
                            price: {$item.item_price},
                            description: '{$item.item_description|escape:'javascript'}',
                            image: '{$item.item_image|escape:'javascript'}',
                            is_popular: '{$item.is_popular}',
                            is_available: '{$item.is_available}'
                          })">Sửa</button>
                          <button class="btn btn-sm btn-danger" onclick="deleteMenuItem({$item.item_id})">Xóa</button>
                        </div>
                      </div>
                    </div>
                  </div>
                {/foreach}
              </div>
            {else}
              <p class="text-muted">Chưa có món nào trong danh mục này.</p>
            {/if}
          </div>
        {/foreach}
      {else}
        <div class="text-center py-5">
          <p>Chưa có món ăn nào. Hãy thêm món đầu tiên!</p>
        </div>
      {/if}
    {/if}
  </div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Thêm món mới</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form class="js_ajax-forms" data-url="includes/ajax/pages/menu.php?do=add_item&page_id={$spage['page_id']}">
        <div class="modal-body">
          <div class="form-group">
            <label>Tên món ăn</label>
            <input type="text" class="form-control" name="item_name" required>
          </div>
          <div class="form-group">
            <label>Giá (VNĐ)</label>
            <input type="number" class="form-control" name="item_price" required>
          </div>
          <div class="form-group">
            <label>Danh mục</label>
            <select class="form-control" name="category_id" required>
              {foreach $menu_categories as $category}
                <option value="{$category.category_id}">{$category.category_name}</option>
              {/foreach}
            </select>
          </div>
          <div class="form-group">
            <label>Mô tả</label>
            <textarea class="form-control" name="item_description" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label>URL hình ảnh</label>
            <input type="url" class="form-control" name="item_image">
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
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sửa món</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form class="js_ajax-forms" data-url="includes/ajax/pages/menu.php?do=edit_item" id="editItemForm">
        <input type="hidden" name="item_id" id="edit_item_id">
        <div class="modal-body">
          <div class="form-group">
            <label>Tên món ăn</label>
            <input type="text" class="form-control" name="item_name" id="edit_item_name" required>
          </div>
          <div class="form-group">
            <label>Giá (VNĐ)</label>
            <input type="number" class="form-control" name="item_price" id="edit_item_price" required>
          </div>
          <div class="form-group">
            <label>Mô tả</label>
            <textarea class="form-control" name="item_description" id="edit_item_description" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label>URL hình ảnh</label>
            <input type="url" class="form-control" name="item_image" id="edit_item_image">
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_popular" id="edit_is_popular">
            <label class="form-check-label">🔥 Món hot</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_available" id="edit_is_available" checked>
            <label class="form-check-label">✅ Còn hàng</label>
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
<div class="modal fade" id="addCategoryModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Thêm danh mục mới</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form class="js_ajax-forms" data-url="includes/ajax/pages/menu.php?do=add_category&page_id={$spage['page_id']}">
        <div class="modal-body">
          <div class="form-group">
            <label>Tên danh mục</label>
            <input type="text" class="form-control" name="category_name" required placeholder="Món chính, Tráng miệng...">
          </div>
          <div class="form-group">
            <label>Icon</label>
            <input type="text" class="form-control" name="category_icon" placeholder="fa-utensils" value="fa-utensils">
          </div>
          <div class="form-group">
            <label>Thứ tự hiển thị</label>
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

<script src="{$system['system_url']}/js/page-menu.js"></script>
