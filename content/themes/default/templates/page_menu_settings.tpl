{* Template cài đặt thực đơn *}
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
  
  <div class="form-check form-switch mb-3">
    <input class="form-check-input" type="checkbox" name="show_prices" checked>
    <label class="form-check-label">Hiển thị giá món ăn</label>
  </div>
  
  <div class="form-check form-switch mb-3">
    <input class="form-check-input" type="checkbox" name="show_images" checked>
    <label class="form-check-label">Hiển thị ảnh món ăn</label>
  </div>
  
  <div class="form-check form-switch mb-3">
    <input class="form-check-input" type="checkbox" name="allow_ordering">
    <label class="form-check-label">Cho phép đặt món trực tuyến</label>
  </div>
  
  <button type="submit" class="btn btn-primary">
    <i class="fa fa-save mr-2"></i>Lưu cài đặt
  </button>
</form>
