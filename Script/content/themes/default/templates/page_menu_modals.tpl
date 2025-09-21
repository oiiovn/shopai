{* Template các modals cho menu management *}

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Thêm món mới</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="addItemForm" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Tên món ăn <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="item_name" required placeholder="Bánh mì thịt nướng">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="item_price" required min="0" placeholder="25000">
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label class="form-label">Danh mục <span class="text-danger">*</span></label>
            <select class="form-select" name="category_id" required>
              <option value="">Chọn danh mục</option>
              {foreach $menu_categories as $category}
                <option value="{$category.category_id}">{$category.category_name}</option>
              {/foreach}
            </select>
          </div>
          
          <div class="form-group">
            <label class="form-label">Mô tả món ăn</label>
            <textarea class="form-control" name="item_description" rows="3" placeholder="Mô tả chi tiết về món ăn..."></textarea>
          </div>
          
          <div class="form-group">
            <label class="form-label">Hình ảnh món ăn</label>
            <input type="file" class="form-control" name="item_image_file" accept="image/*" id="addItemImageFile">
            <div class="form-text">
              <small class="text-muted">Chọn file ảnh JPG, PNG, GIF (tối đa 5MB)</small>
            </div>
            <div class="mt-2">
              <strong>Hoặc nhập URL hình ảnh:</strong>
              <input type="text" class="form-control mt-1" name="item_image_url" placeholder="https://example.com/image.jpg">
            </div>
            <div id="addItemImagePreview" class="mt-2" style="display: none;">
              <img id="addItemPreviewImg" src="" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
              <button type="button" class="btn btn-sm btn-danger ms-2" onclick="clearAddItemImage()">
                <i class="fa fa-times"></i> Xóa
              </button>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_popular">
                <label class="form-check-label">🔥 Món hot</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_available" checked>
                <label class="form-check-label">✅ Còn hàng</label>
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

<style>
/* Menu Item Card Styles */
.menu-item-card {
  border: 1px solid #e9ecef;
  border-radius: 8px;
  transition: all 0.3s ease;
}

.menu-item-card:hover {
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  transform: translateY(-2px);
}

.menu-item-card.unavailable {
  opacity: 0.6;
  background-color: #f8f9fa;
  border-color: #dee2e6;
}

.menu-item-card.unavailable .item-name {
  text-decoration: line-through;
  color: #6c757d;
}

.form-group {
  margin-bottom: 1rem;
}

.menu-category-section {
  border-left: 3px solid #007bff;
  padding-left: 15px;
  margin-left: 10px;
}
</style>

<!-- Delete Item Confirmation Modal -->
<div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="deleteItemModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteItemModalLabel">
          <i class="fa fa-exclamation-triangle me-2"></i>Xác nhận xóa món ăn
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning">
          <i class="fa fa-exclamation-triangle me-2"></i>
          <strong>Bạn có chắc chắn muốn xóa món ăn này không?</strong>
        </div>
        <div class="item-details">
          <p><strong>Tên món:</strong> <span id="delete-item-name"></span></p>
          <p><strong>Giá:</strong> <span id="delete-item-price"></span> VNĐ</p>
          <p><strong>Danh mục:</strong> <span id="delete-item-category"></span></p>
        </div>
        <div class="alert alert-danger mt-3">
          <i class="fa fa-warning me-2"></i>
          <strong>Lưu ý:</strong> Hành động này không thể hoàn tác. Món ăn sẽ bị xóa vĩnh viễn khỏi thực đơn.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fa fa-times me-1"></i>Hủy bỏ
        </button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
          <i class="fa fa-trash me-1"></i>Xóa món ăn
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sửa món ăn</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="editItemForm">
        <input type="hidden" name="item_id" id="edit_item_id">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Tên món ăn <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="item_name" id="edit_item_name" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="item_price" id="edit_item_price" required min="0">
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label class="form-label">Mô tả món ăn</label>
            <textarea class="form-control" name="item_description" id="edit_item_description" rows="3"></textarea>
          </div>
          
          <div class="form-group">
            <label class="form-label">Hình ảnh món ăn</label>
            <input type="file" class="form-control" name="item_image_file" accept="image/*" id="editItemImageFile">
            <div class="form-text">
              <small class="text-muted">Chọn file ảnh mới (JPG, PNG, GIF, tối đa 5MB)</small>
            </div>
            <div class="mt-2">
              <strong>Hoặc nhập URL hình ảnh:</strong>
              <input type="text" class="form-control mt-1" name="item_image_url" id="edit_item_image_url" placeholder="https://example.com/image.jpg">
            </div>
            <div id="editItemImagePreview" class="mt-2">
              <img id="editItemPreviewImg" src="" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
              <button type="button" class="btn btn-sm btn-danger ms-2" onclick="clearEditItemImage()">
                <i class="fa fa-times"></i> Xóa
              </button>
            </div>
            <input type="hidden" name="item_image" id="edit_item_image" value="">
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_popular" id="edit_is_popular">
                <label class="form-check-label">🔥 Món hot</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_available" id="edit_is_available">
                <label class="form-check-label">✅ Còn hàng</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
          <button type="button" class="btn btn-info" onclick="testEditSubmit()">🔧 Test</button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
/* Menu Item Card Styles */
.menu-item-card {
  border: 1px solid #e9ecef;
  border-radius: 8px;
  transition: all 0.3s ease;
}

.menu-item-card:hover {
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  transform: translateY(-2px);
}

.menu-item-card.unavailable {
  opacity: 0.6;
  background-color: #f8f9fa;
  border-color: #dee2e6;
}

.menu-item-card.unavailable .item-name {
  text-decoration: line-through;
  color: #6c757d;
}

.form-group {
  margin-bottom: 1rem;
}

.menu-category-section {
  border-left: 3px solid #007bff;
  padding-left: 15px;
  margin-left: 10px;
}
</style>

<!-- Delete Item Confirmation Modal -->
<div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="deleteItemModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteItemModalLabel">
          <i class="fa fa-exclamation-triangle me-2"></i>Xác nhận xóa món ăn
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning">
          <i class="fa fa-exclamation-triangle me-2"></i>
          <strong>Bạn có chắc chắn muốn xóa món ăn này không?</strong>
        </div>
        <div class="item-details">
          <p><strong>Tên món:</strong> <span id="delete-item-name"></span></p>
          <p><strong>Giá:</strong> <span id="delete-item-price"></span> VNĐ</p>
          <p><strong>Danh mục:</strong> <span id="delete-item-category"></span></p>
        </div>
        <div class="alert alert-danger mt-3">
          <i class="fa fa-warning me-2"></i>
          <strong>Lưu ý:</strong> Hành động này không thể hoàn tác. Món ăn sẽ bị xóa vĩnh viễn khỏi thực đơn.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fa fa-times me-1"></i>Hủy bỏ
        </button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
          <i class="fa fa-trash me-1"></i>Xóa món ăn
        </button>
      </div>
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
      <form id="addCategoryForm" data-url="includes/ajax/pages/menu.php?do=add_category&page_id={$spage['page_id']}">
        <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Tên danh mục <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="category_name" required placeholder="Món chính, Tráng miệng...">
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Icon</label>
                <select class="form-select" name="category_icon">
                  <option value="fa-utensils">🍽️ Đồ ăn chung</option>
                  <option value="fa-hamburger">🍔 Burger/Bánh mì</option>
                  <option value="fa-coffee">☕ Đồ uống</option>
                  <option value="fa-ice-cream">🍦 Tráng miệng</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Thứ tự</label>
                <input type="number" class="form-control" name="display_order" value="1" min="1">
              </div>
            </div>
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
/* Menu Item Card Styles */
.menu-item-card {
  border: 1px solid #e9ecef;
  border-radius: 8px;
  transition: all 0.3s ease;
}

.menu-item-card:hover {
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  transform: translateY(-2px);
}

.menu-item-card.unavailable {
  opacity: 0.6;
  background-color: #f8f9fa;
  border-color: #dee2e6;
}

.menu-item-card.unavailable .item-name {
  text-decoration: line-through;
  color: #6c757d;
}

.form-group {
  margin-bottom: 1rem;
}

.menu-category-section {
  border-left: 3px solid #007bff;
  padding-left: 15px;
  margin-left: 10px;
}
</style>

<!-- Delete Item Confirmation Modal -->
<div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="deleteItemModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteItemModalLabel">
          <i class="fa fa-exclamation-triangle me-2"></i>Xác nhận xóa món ăn
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning">
          <i class="fa fa-exclamation-triangle me-2"></i>
          <strong>Bạn có chắc chắn muốn xóa món ăn này không?</strong>
        </div>
        <div class="item-details">
          <p><strong>Tên món:</strong> <span id="delete-item-name"></span></p>
          <p><strong>Giá:</strong> <span id="delete-item-price"></span> VNĐ</p>
          <p><strong>Danh mục:</strong> <span id="delete-item-category"></span></p>
        </div>
        <div class="alert alert-danger mt-3">
          <i class="fa fa-warning me-2"></i>
          <strong>Lưu ý:</strong> Hành động này không thể hoàn tác. Món ăn sẽ bị xóa vĩnh viễn khỏi thực đơn.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fa fa-times me-1"></i>Hủy bỏ
        </button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
          <i class="fa fa-trash me-1"></i>Xóa món ăn
        </button>
      </div>
    </div>
  </div>
</div>
