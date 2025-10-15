{* Template quản lý menu đầy đủ cho chủ page ẩm thực *}
<div class="card">
  <div class="card-header with-icon with-nav">
    <!-- panel title -->
    <div class="mb20">
      <div class="float-end">
        <a href="{$system['system_url']}/pages/{$spage['page_name']}" class="btn btn-md btn-light">
          <i class="fa fa-eye mr5"></i>Xem thực đơn công khai
        </a>
      </div>
      <div>
        <i class="fa fa-utensils mr10"></i>Quản lý thực đơn
        <div class="text-muted mt5">Tạo và quản lý thực đơn cho {$spage['page_title']}</div>
      </div>
    </div>

    <!-- panel nav -->
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link {if $menu_view == "" || $menu_view == "items"}active{/if}" href="{$system['system_url']}/pages/{$spage['page_name']}?view=menu&menu_view=items">
          <i class="fa fa-list fa-fw mr5"></i><strong>Danh sách món</strong>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {if $menu_view == "categories"}active{/if}" href="{$system['system_url']}/pages/{$spage['page_name']}?view=menu&menu_view=categories">
          <i class="fa fa-folder fa-fw mr5"></i><strong>Danh mục</strong>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {if $menu_view == "settings"}active{/if}" href="{$system['system_url']}/pages/{$spage['page_name']}?view=menu&menu_view=settings">
          <i class="fa fa-cog fa-fw mr5"></i><strong>Cài đặt</strong>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {if $menu_view == "analytics"}active{/if}" href="{$system['system_url']}/pages/{$spage['page_name']}?view=menu&menu_view=analytics">
          <i class="fa fa-chart-bar fa-fw mr5"></i><strong>Thống kê</strong>
        </a>
      </li>
    </ul>
    <!-- panel nav -->
  </div>

  {if $menu_view == "categories"}
    <!-- Categories Management -->
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h4><i class="fa fa-folder-open mr10"></i>Quản lý danh mục thực đơn</h4>
          <p class="text-muted">Tạo và sắp xếp các danh mục cho thực đơn của bạn</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
          <i class="fa fa-plus mr5"></i>Thêm danh mục
        </button>
      </div>

      {if $menu_categories}
        <div class="row">
          {foreach $menu_categories as $category}
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card category-card h-100">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="category-icon-title">
                      <div class="category-icon mb-2">
                        <i class="{$category.category_icon} fa-2x text-primary"></i>
                      </div>
                      <h6 class="card-title mb-0">{$category.category_name}</h6>
                    </div>
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
                    <div class="stat-item">
                      <i class="fa fa-utensils text-success mr-2"></i>
                      <span class="fw-bold">{$category.items_count}</span> món ăn
                    </div>
                    <div class="stat-item mt-2">
                      <i class="fa fa-sort text-info mr-2"></i>
                      Thứ tự: <span class="fw-bold">{$category.display_order}</span>
                    </div>
                  </div>
                  
                  <div class="category-progress mt-3">
                    <div class="d-flex justify-content-between">
                      <small class="text-muted">Độ phổ biến</small>
                      <small class="text-muted">{if $category.items_count > 0}{($category.items_count * 20)|min:100}%{else}0%{/if}</small>
                    </div>
                    <div class="progress" style="height: 4px;">
                      <div class="progress-bar bg-primary" style="width: {if $category.items_count > 0}{($category.items_count * 20)|min:100}%{else}0%{/if}"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          {/foreach}
        </div>
      {else}
        <div class="text-center py-5">
          <div class="empty-state">
            <i class="fa fa-folder-open fa-4x text-muted mb-4"></i>
            <h5 class="text-muted">Chưa có danh mục nào</h5>
            <p class="text-muted">Bắt đầu bằng cách thêm danh mục đầu tiên cho thực đơn của bạn</p>
            <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
              <i class="fa fa-plus mr5"></i>Thêm danh mục đầu tiên
            </button>
          </div>
        </div>
      {/if}
    </div>

  {elseif $menu_view == "settings"}
    <!-- Menu Settings -->
    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">
          <h4><i class="fa fa-cog mr10"></i>Cài đặt thực đơn</h4>
          <p class="text-muted">Cấu hình hiển thị và hoạt động của thực đơn</p>
          
          <form class="ajax-form" data-url="includes/ajax/pages/menu.php?do=update_settings&page_id={$spage['page_id']}">
            <div class="card mb-4">
              <div class="card-header">
                <h6 class="mb-0"><i class="fa fa-info-circle mr5"></i>Thông tin chung</h6>
              </div>
              <div class="card-body">
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
              </div>
            </div>
            
            <div class="card mb-4">
              <div class="card-header">
                <h6 class="mb-0"><i class="fa fa-eye mr5"></i>Hiển thị</h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-check form-switch mb-3">
                      <input class="form-check-input" type="checkbox" name="show_prices" id="show_prices" checked>
                      <label class="form-check-label" for="show_prices">
                        <strong>Hiển thị giá món ăn</strong>
                        <div class="text-muted small">Khách hàng sẽ thấy giá của từng món</div>
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-check form-switch mb-3">
                      <input class="form-check-input" type="checkbox" name="show_images" id="show_images" checked>
                      <label class="form-check-label" for="show_images">
                        <strong>Hiển thị ảnh món ăn</strong>
                        <div class="text-muted small">Thực đơn sẽ có ảnh minh họa</div>
                      </label>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-check form-switch mb-3">
                      <input class="form-check-input" type="checkbox" name="show_availability" id="show_availability" checked>
                      <label class="form-check-label" for="show_availability">
                        <strong>Hiển thị trạng thái món</strong>
                        <div class="text-muted small">Hiển thị "Còn hàng/Hết hàng"</div>
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-check form-switch mb-3">
                      <input class="form-check-input" type="checkbox" name="show_popular" id="show_popular" checked>
                      <label class="form-check-label" for="show_popular">
                        <strong>Hiển thị món hot</strong>
                        <div class="text-muted small">Đánh dấu món phổ biến với icon 🔥</div>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="card mb-4">
              <div class="card-header">
                <h6 class="mb-0"><i class="fa fa-shopping-cart mr5"></i>Đặt món</h6>
              </div>
              <div class="card-body">
                <div class="form-check form-switch mb-3">
                  <input class="form-check-input" type="checkbox" name="allow_ordering" id="allow_ordering">
                  <label class="form-check-label" for="allow_ordering">
                    <strong>Cho phép đặt món trực tuyến</strong>
                    <div class="text-muted small">Khách hàng có thể đặt món qua website</div>
                  </label>
                </div>
                
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Số điện thoại đặt món</label>
                      <input type="tel" class="form-control" name="order_phone" placeholder="0123456789">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Thời gian phục vụ</label>
                      <input type="text" class="form-control" name="service_hours" placeholder="7:00 - 22:00 hàng ngày">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="card mb-4">
              <div class="card-header">
                <h6 class="mb-0"><i class="fa fa-sticky-note mr5"></i>Ghi chú thêm</h6>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label class="form-label">Ghi chú về thực đơn</label>
                  <textarea class="form-control" name="menu_notes" rows="4" placeholder="Ghi chú về giờ phục vụ, điều kiện đặt món, chính sách...">Thực đơn có thể thay đổi theo mùa. Vui lòng liên hệ để biết thêm chi tiết về các món ăn đặc biệt.</textarea>
                </div>
            
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fa fa-save mr5"></i>Lưu tất cả cài đặt
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
        
        <div class="col-lg-4">
          <div class="card">
            <div class="card-header">
              <h6 class="mb-0"><i class="fa fa-info-circle mr5"></i>Thống kê nhanh</h6>
            </div>
            <div class="card-body">
              <div class="stat-box mb-3">
                <div class="stat-number text-primary">{if $menu_categories}{$menu_categories|count}{else}0{/if}</div>
                <div class="stat-label">Danh mục</div>
              </div>
              <div class="stat-box mb-3">
                <div class="stat-number text-success">
                  {assign var="total_items" value=0}
                  {if $menu_categories}
                    {foreach $menu_categories as $category}
                      {assign var="total_items" value=$total_items + $category.items_count}
                    {/foreach}
                  {/if}
                  {$total_items}
                </div>
                <div class="stat-label">Tổng món ăn</div>
              </div>
              <div class="stat-box mb-3">
                <div class="stat-number text-warning">
                  {assign var="popular_items" value=0}
                  {if $menu_categories}
                    {foreach $menu_categories as $category}
                      {if $category.items}
                        {foreach $category.items as $item}
                          {if $item.is_popular == '1'}
                            {assign var="popular_items" value=$popular_items + 1}
                          {/if}
                        {/foreach}
                      {/if}
                    {/foreach}
                  {/if}
                  {$popular_items}
                </div>
                <div class="stat-label">Món hot</div>
              </div>
            </div>
          </div>
          
          <div class="card mt-3">
            <div class="card-header">
              <h6 class="mb-0"><i class="fa fa-lightbulb mr5"></i>Gợi ý</h6>
            </div>
            <div class="card-body">
              <ul class="list-unstyled">
                <li class="mb-2"><i class="fa fa-check text-success mr-2"></i>Thêm ảnh đẹp cho món ăn</li>
                <li class="mb-2"><i class="fa fa-check text-success mr-2"></i>Viết mô tả hấp dẫn</li>
                <li class="mb-2"><i class="fa fa-check text-success mr-2"></i>Cập nhật giá thường xuyên</li>
                <li class="mb-2"><i class="fa fa-check text-success mr-2"></i>Đánh dấu món hot phù hợp</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

  {elseif $menu_view == "analytics"}
    <!-- Analytics -->
    <div class="card-body">
      <h4><i class="fa fa-chart-bar mr10"></i>Thống kê thực đơn</h4>
      <p class="text-muted">Xem thống kê về hiệu suất thực đơn của bạn</p>
      
      <div class="row">
        <div class="col-md-3">
          <div class="card bg-primary text-white">
            <div class="card-body text-center">
              <i class="fa fa-utensils fa-2x mb-2"></i>
              <h3>{if $menu_categories}{$menu_categories|count}{else}0{/if}</h3>
              <p class="mb-0">Danh mục</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card bg-success text-white">
            <div class="card-body text-center">
              <i class="fa fa-hamburger fa-2x mb-2"></i>
              <h3>
                {assign var="total_items" value=0}
                {if $menu_categories}
                  {foreach $menu_categories as $category}
                    {assign var="total_items" value=$total_items + $category.items_count}
                  {/foreach}
                {/if}
                {$total_items}
              </h3>
              <p class="mb-0">Tổng món</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card bg-warning text-white">
            <div class="card-body text-center">
              <i class="fa fa-fire fa-2x mb-2"></i>
              <h3>
                {assign var="popular_items" value=0}
                {if $menu_categories}
                  {foreach $menu_categories as $category}
                    {if $category.items}
                      {foreach $category.items as $item}
                        {if $item.is_popular == '1'}
                          {assign var="popular_items" value=$popular_items + 1}
                        {/if}
                      {/foreach}
                    {/if}
                  {/foreach}
                {/if}
                {$popular_items}
              </h3>
              <p class="mb-0">Món hot</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card bg-info text-white">
            <div class="card-body text-center">
              <i class="fa fa-check-circle fa-2x mb-2"></i>
              <h3>
                {assign var="available_items" value=0}
                {if $menu_categories}
                  {foreach $menu_categories as $category}
                    {if $category.items}
                      {foreach $category.items as $item}
                        {if $item.is_available == '1'}
                          {assign var="available_items" value=$available_items + 1}
                        {/if}
                      {/foreach}
                    {/if}
                  {/foreach}
                {/if}
                {$available_items}
              </h3>
              <p class="mb-0">Còn hàng</p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row mt-4">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h6 class="mb-0">Danh mục phổ biến nhất</h6>
            </div>
            <div class="card-body">
              {if $menu_categories}
                {foreach $menu_categories as $category}
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                      <i class="{$category.category_icon} mr-2"></i>
                      {$category.category_name}
                    </div>
                    <span class="badge bg-primary">{$category.items_count} món</span>
                  </div>
                {/foreach}
              {else}
                <p class="text-muted">Chưa có dữ liệu</p>
              {/if}
            </div>
          </div>
        </div>
        
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h6 class="mb-0">Món ăn giá cao nhất</h6>
            </div>
            <div class="card-body">
              {assign var="max_price" value=0}
              {assign var="max_item" value=null}
              {if $menu_categories}
                {foreach $menu_categories as $category}
                  {if $category.items}
                    {foreach $category.items as $item}
                      {if $item.item_price > $max_price}
                        {assign var="max_price" value=$item.item_price}
                        {assign var="max_item" value=$item}
                      {/if}
                    {/foreach}
                  {/if}
                {/foreach}
              {/if}
              
              {if $max_item}
                <div class="d-flex align-items-center">
                  <div class="me-3">
                    {if $max_item.item_image}
                      <img src="{$max_item.item_image}" class="rounded" width="50" height="50" style="object-fit: cover;">
                    {else}
                      <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fa fa-image text-muted"></i>
                      </div>
                    {/if}
                  </div>
                  <div>
                    <h6 class="mb-1">{$max_item.item_name}</h6>
                    <p class="text-primary mb-0 fw-bold">{$max_item.item_price|number_format:0:",":"."} đ</p>
                  </div>
                </div>
              {else}
                <p class="text-muted">Chưa có món ăn</p>
              {/if}
            </div>
          </div>
        </div>
      </div>
    </div>

  {else}
    <!-- Menu Items Management -->
    <div class="card-body">
      <div class="row mb-4">
        <div class="col-md-8">
          <h4><i class="fa fa-list mr10"></i>Danh sách món ăn</h4>
          <p class="text-muted">Thêm, sửa, xóa các món ăn trong thực đơn của bạn</p>
        </div>
        <div class="col-md-4 text-end">
          <div class="d-flex gap-2 justify-content-end mb-3">
            <div class="input-group" style="max-width: 200px;">
              <input type="text" class="form-control" id="search-items" placeholder="Tìm món ăn...">
              <button class="btn btn-outline-secondary" type="button" onclick="searchItems()">
                <i class="fa fa-search"></i>
              </button>
            </div>
            <select class="form-select" id="filter-category" onchange="filterByCategory(this.value)" style="max-width: 150px;">
              <option value="">Tất cả danh mục</option>
              {foreach $menu_categories as $category}
                <option value="{$category.category_id}">{$category.category_name}</option>
              {/foreach}
            </select>
          </div>
          <div class="d-flex gap-2 justify-content-end">
            <div class="dropdown">
              <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-filter mr-2"></i>Lọc
              </button>
              <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="#" onclick="filterByStatus('available')">
                  <i class="fa fa-check-circle text-success mr-2"></i>Chỉ món còn hàng
                </a>
                <a class="dropdown-item" href="#" onclick="filterByStatus('unavailable')">
                  <i class="fa fa-times-circle text-danger mr-2"></i>Chỉ món hết hàng
                </a>
                <a class="dropdown-item" href="#" onclick="filterByStatus('popular')">
                  <i class="fa fa-fire text-warning mr-2"></i>Chỉ món hot
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" onclick="clearAllFilters()">
                  <i class="fa fa-times mr-2"></i>Xóa bộ lọc
                </a>
              </div>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
              <i class="fa fa-plus mr5"></i>Thêm món mới
            </button>
          </div>
        </div>
      </div>

      {if $menu_categories}
        {foreach $menu_categories as $category}
          <div class="menu-category-section mb-5" data-category-id="{$category.category_id}">
            <div class="category-header mb-3">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                  <i class="{$category.category_icon} text-primary mr-2"></i>
                  {$category.category_name}
                  <span class="badge bg-light text-dark ms-2">{$category.items_count} món</span>
                </h5>
                <div class="dropdown">
                  <button class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-cog mr-1"></i>Hành động
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#" onclick="editCategory({$category.category_id})">
                      <i class="fa fa-edit mr-2"></i>Sửa danh mục
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="markAllAvailable({$category.category_id})">
                      <i class="fa fa-check-circle text-success mr-2"></i>Đánh dấu tất cả "Còn hàng"
                    </a>
                    <a class="dropdown-item" href="#" onclick="markAllUnavailable({$category.category_id})">
                      <i class="fa fa-times-circle text-warning mr-2"></i>Đánh dấu tất cả "Hết hàng"
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="#" onclick="deleteCategory({$category.category_id})">
                      <i class="fa fa-trash mr-2"></i>Xóa danh mục
                    </a>
                  </div>
                </div>
              </div>
            </div>
            
            {if $category.items}
              <div class="row">
                {foreach $category.items as $item}
                  <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="card menu-item-card h-100 {if $item.is_available == '0'}unavailable{/if}">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                          <div class="item-info flex-grow-1">
                            <h6 class="item-name mb-1">
                              {$item.item_name}
                              {if $item.is_popular == '1'}
                                <span class="badge bg-warning text-dark ms-1">
                                  <i class="fa fa-fire"></i> Hot
                                </span>
                              {/if}
                            </h6>
                            <p class="item-description text-muted small mb-2">{$item.item_description}</p>
                            <div class="item-price">
                              <strong class="text-primary h6">{$item.item_price|number_format:0:",":"."} đ</strong>
                            </div>
                          </div>
                          
                          {if $item.item_image}
                            <div class="item-image ms-3">
                              <img src="{$item.item_image}" class="rounded" width="60" height="60" style="object-fit: cover;">
                            </div>
                          {else}
                            <div class="item-image-placeholder ms-3 bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                              <i class="fa fa-image text-muted"></i>
                            </div>
                          {/if}
                        </div>
                        
                        <div class="item-actions d-flex justify-content-between align-items-center">
                          <div class="availability-toggle">
                            <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" {if $item.is_available == '1'}checked{/if} 
                                     onchange="toggleItemAvailability({$item.item_id}, this.checked)">
                              <label class="form-check-label small">
                                {if $item.is_available == '1'}
                                  <span class="text-success"><i class="fa fa-check-circle"></i> Còn hàng</span>
                                {else}
                                  <span class="text-danger"><i class="fa fa-times-circle"></i> Hết hàng</span>
                                {/if}
                              </label>
                            </div>
                          </div>
                          
                          <div class="action-buttons">
                            <div class="btn-group" role="group">
                              <button class="btn btn-sm btn-outline-info" onclick="editMenuItem({$item.item_id}, {
                                name: '{$item.item_name|escape:'javascript'}',
                                price: {$item.item_price},
                                description: '{$item.item_description|escape:'javascript'}',
                                image: '{$item.item_image|escape:'javascript'}',
                                is_popular: '{$item.is_popular}',
                                is_available: '{$item.is_available}',
                                category_id: '{$item.category_id}'
                              })" title="Sửa món">
                                <i class="fa fa-edit"></i>
                              </button>
                              <button class="btn btn-sm btn-outline-secondary" onclick="duplicateMenuItem({$item.item_id})" title="Nhân bản món">
                                <i class="fa fa-copy"></i>
                              </button>
                              <button class="btn btn-sm btn-outline-danger" onclick="deleteMenuItem({$item.item_id}, '{$item.item_name|escape:'javascript'}')" title="Xóa món">
                                <i class="fa fa-trash"></i>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                {/foreach}
              </div>
            {else}
              <div class="text-center py-4 bg-light rounded">
                <i class="fa fa-utensils fa-2x text-muted mb-2"></i>
                <p class="text-muted mb-0">Chưa có món nào trong danh mục này</p>
              </div>
            {/if}
          </div>
        {/foreach}
      {else}
        <div class="text-center py-5">
          <div class="empty-state">
            <i class="fa fa-utensils fa-4x text-muted mb-4"></i>
            <h5 class="text-muted">Chưa có món ăn nào</h5>
            <p class="text-muted">Hãy thêm danh mục và món ăn đầu tiên cho thực đơn của bạn</p>
            <div class="d-flex gap-2 justify-content-center">
              <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="fa fa-folder-plus mr5"></i>Thêm danh mục
              </button>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
                <i class="fa fa-plus mr5"></i>Thêm món đầu tiên
              </button>
            </div>
          </div>
        </div>
      {/if}
    </div>
  {/if}
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="fa fa-plus mr-2"></i>Thêm món mới</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form class="js_ajax-forms" data-url="includes/ajax/pages/menu.php?do=add_item&page_id={$spage['page_id']}">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold">Tên món ăn <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="item_name" required placeholder="Bánh mì thịt nướng">
                <small class="form-text text-muted">Tên món sẽ hiển thị trên thực đơn</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold">Giá (VNĐ) <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="item_price" required min="0" placeholder="25000">
                <small class="form-text text-muted">Giá bán của món ăn</small>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
            <select class="form-select" name="category_id" required>
              <option value="">Chọn danh mục</option>
              {foreach $menu_categories as $category}
                <option value="{$category.category_id}">
                  <i class="{$category.category_icon}"></i> {$category.category_name}
                </option>
              {/foreach}
            </select>
          </div>
          
          <div class="form-group">
            <label class="form-label fw-bold">Mô tả món ăn</label>
            <textarea class="form-control" name="item_description" rows="3" placeholder="Bánh mì với thịt heo nướng thơm ngon, rau sống tươi mát, sốt đặc biệt..."></textarea>
            <small class="form-text text-muted">Mô tả chi tiết về món ăn</small>
          </div>
          
          <div class="form-group">
            <label class="form-label fw-bold">Hình ảnh món ăn</label>
            <input type="url" class="form-control" name="item_image" placeholder="https://example.com/image.jpg">
            <small class="form-text text-muted">URL hình ảnh hoặc để trống để thêm sau</small>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold">Thứ tự hiển thị</label>
                <input type="number" class="form-control" name="display_order" value="1" min="1">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold">Tùy chọn</label>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="is_popular" id="add_is_popular">
                  <label class="form-check-label" for="add_is_popular">
                    🔥 Món hot (nổi bật)
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="is_available" id="add_is_available" checked>
                  <label class="form-check-label" for="add_is_available">
                    ✅ Còn hàng
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fa fa-times mr-2"></i>Hủy
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-save mr-2"></i>Thêm món
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title"><i class="fa fa-edit mr-2"></i>Sửa món ăn</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form class="js_ajax-forms" data-url="includes/ajax/pages/menu.php?do=edit_item" id="editItemForm">
        <input type="hidden" name="item_id" id="edit_item_id">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold">Tên món ăn <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="item_name" id="edit_item_name" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold">Giá (VNĐ) <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="item_price" id="edit_item_price" required min="0">
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label class="form-label fw-bold">Mô tả món ăn</label>
            <textarea class="form-control" name="item_description" id="edit_item_description" rows="3"></textarea>
          </div>
          
          <div class="form-group">
            <label class="form-label fw-bold">Hình ảnh món ăn</label>
            <input type="url" class="form-control" name="item_image" id="edit_item_image">
            <div id="edit_image_preview" class="mt-2" style="display: none;">
              <img id="edit_preview_img" src="" class="rounded" width="100" height="100" style="object-fit: cover;">
            </div>
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
                <input class="form-check-input" type="checkbox" name="is_available" id="edit_is_available">
                <label class="form-check-label" for="edit_is_available">
                  ✅ Còn hàng
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fa fa-times mr-2"></i>Hủy
          </button>
          <button type="submit" class="btn btn-info">
            <i class="fa fa-save mr-2"></i>Lưu thay đổi
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title"><i class="fa fa-folder-plus mr-2"></i>Thêm danh mục mới</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form class="js_ajax-forms" data-url="includes/ajax/pages/menu.php?do=add_category&page_id={$spage['page_id']}">
        <div class="modal-body">
          <div class="form-group">
            <label class="form-label fw-bold">Tên danh mục <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="category_name" required placeholder="Món chính, Tráng miệng, Đồ uống...">
            <small class="form-text text-muted">Tên danh mục sẽ hiển thị trên thực đơn</small>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold">Icon danh mục</label>
                <select class="form-select" name="category_icon">
                  <option value="fa-utensils">🍽️ Đồ ăn chung</option>
                  <option value="fa-hamburger">🍔 Burger/Bánh mì</option>
                  <option value="fa-pizza-slice">🍕 Pizza</option>
                  <option value="fa-coffee">☕ Đồ uống</option>
                  <option value="fa-ice-cream">🍦 Tráng miệng</option>
                  <option value="fa-wine-glass">🍷 Đồ uống có cồn</option>
                  <option value="fa-birthday-cake">🎂 Bánh ngọt</option>
                  <option value="fa-apple-alt">🍎 Trái cây</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold">Thứ tự hiển thị</label>
                <input type="number" class="form-control" name="display_order" value="1" min="1">
                <small class="form-text text-muted">Số nhỏ hơn sẽ hiển thị trước</small>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fa fa-times mr-2"></i>Hủy
          </button>
          <button type="submit" class="btn btn-success">
            <i class="fa fa-save mr-2"></i>Thêm danh mục
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
/* Menu Management Styles */
.menu-item-card {
  border: 1px solid #e9ecef;
  transition: all 0.3s ease;
}

.menu-item-card:hover {
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  transform: translateY(-2px);
}

.menu-item-card.unavailable {
  opacity: 0.6;
  background-color: #f8f9fa;
}

.category-card {
  border: 1px solid #e9ecef;
  border-radius: 12px;
  transition: all 0.3s ease;
}

.category-card:hover {
  box-shadow: 0 6px 20px rgba(0,0,0,0.1);
  transform: translateY(-3px);
}

.category-header {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  padding: 15px 20px;
  border-radius: 8px;
  border-left: 4px solid var(--primary);
}

.stat-box {
  text-align: center;
  padding: 15px;
  background: #f8f9fa;
  border-radius: 8px;
}

.stat-number {
  font-size: 2rem;
  font-weight: bold;
  margin-bottom: 5px;
}

.stat-label {
  font-size: 0.9rem;
  color: #6c757d;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.empty-state {
  padding: 60px 20px;
}

.item-image-placeholder {
  border: 2px dashed #dee2e6;
}

.availability-toggle .form-check-label {
  cursor: pointer;
}

.action-buttons .btn {
  border-radius: 20px;
}

.category-icon-title .category-icon {
  width: 60px;
  height: 60px;
  background: linear-gradient(135deg, var(--primary) 0%, var(--info) 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
}

.nav-tabs .nav-link {
  border-radius: 8px 8px 0 0;
  margin-right: 5px;
  border: none;
  background: #f8f9fa;
}

.nav-tabs .nav-link.active {
  background: var(--primary);
  color: white;
}

.nav-tabs .nav-link:hover {
  background: var(--primary);
  color: white;
  opacity: 0.8;
}

@media (max-width: 768px) {
  .menu-item-card .item-image,
  .menu-item-card .item-image-placeholder {
    width: 50px !important;
    height: 50px !important;
  }
  
  .category-icon-title .category-icon {
    width: 50px;
    height: 50px;
  }
  
  .stat-number {
    font-size: 1.5rem;
  }
}
</style>

<script src="{$system['system_url']}/js/page-menu.js"></script>

<script>
// Image preview for edit modal
$(document).on('input', '#edit_item_image', function() {
  var imageUrl = $(this).val();
  if (imageUrl && (imageUrl.startsWith('http://') || imageUrl.startsWith('https://'))) {
    $('#edit_preview_img').attr('src', imageUrl);
    $('#edit_image_preview').show();
  } else {
    $('#edit_image_preview').hide();
  }
});

// Auto-generate display order
$(document).ready(function() {
  // Set default display order for new items
  var maxOrder = 0;
  $('.menu-category-section').each(function() {
    var categoryOrder = $(this).find('.menu-item-card').length;
    if (categoryOrder > maxOrder) {
      maxOrder = categoryOrder;
    }
  });
  $('input[name="display_order"]').val(maxOrder + 1);
});

// Enhanced filter function
function filterByCategory(categoryId) {
  if (categoryId === '') {
    $('.menu-category-section').fadeIn();
  } else {
    $('.menu-category-section').fadeOut();
    $('.menu-category-section[data-category-id="' + categoryId + '"]').fadeIn();
  }
}

// Quick actions
function markAllAvailable(categoryId) {
  if (confirm('Đánh dấu tất cả món trong danh mục này là "Còn hàng"?')) {
    $('.menu-category-section[data-category-id="' + categoryId + '"] input[type="checkbox"]').each(function() {
      if (!$(this).is(':checked')) {
        $(this).click();
      }
    });
  }
}

function markAllUnavailable(categoryId) {
  if (confirm('Đánh dấu tất cả món trong danh mục này là "Hết hàng"?')) {
    $('.menu-category-section[data-category-id="' + categoryId + '"] input[type="checkbox"]').each(function() {
      if ($(this).is(':checked')) {
        $(this).click();
      }
    });
  }
}

// Search items function
function searchItems() {
  var searchTerm = $('#search-items').val().toLowerCase();
  if (searchTerm === '') {
    $('.menu-item-card').show();
    return;
  }
  
  $('.menu-item-card').each(function() {
    var itemName = $(this).find('.item-name').text().toLowerCase();
    var itemDescription = $(this).find('.item-description').text().toLowerCase();
    
    if (itemName.includes(searchTerm) || itemDescription.includes(searchTerm)) {
      $(this).show();
    } else {
      $(this).hide();
    }
  });
}

// Filter by status
function filterByStatus(status) {
  $('.menu-item-card').each(function() {
    var $card = $(this);
    var isAvailable = $card.find('input[type="checkbox"]').is(':checked');
    var isPopular = $card.find('.badge').length > 0;
    
    switch(status) {
      case 'available':
        if (isAvailable) {
          $card.show();
        } else {
          $card.hide();
        }
        break;
      case 'unavailable':
        if (!isAvailable) {
          $card.show();
        } else {
          $card.hide();
        }
        break;
      case 'popular':
        if (isPopular) {
          $card.show();
        } else {
          $card.hide();
        }
        break;
    }
  });
}

// Clear all filters
function clearAllFilters() {
  $('.menu-item-card').show();
  $('.menu-category-section').show();
  $('#search-items').val('');
  $('#filter-category').val('');
}

// Real-time search
$(document).on('input', '#search-items', function() {
  searchItems();
});

// Enhanced form validation
$(document).ready(function() {
  // Validate price input
  $('input[name="item_price"]').on('input', function() {
    var price = parseFloat($(this).val());
    if (price < 0) {
      $(this).val(0);
    }
    if (price > 10000000) {
      $(this).val(10000000);
    }
  });
  
  // Auto-format price display
  $('input[name="item_price"]').on('blur', function() {
    var price = parseFloat($(this).val());
    if (!isNaN(price)) {
      $(this).val(Math.round(price));
    }
  });
  
  // Validate item name
  $('input[name="item_name"]').on('input', function() {
    var name = $(this).val();
    if (name.length > 100) {
      $(this).val(name.substring(0, 100));
    }
  });
});

// Duplicate menu item
function duplicateMenuItem(itemId) {
  var itemName = $('.menu-item-card').find('button[onclick*="deleteMenuItem(' + itemId + ')"]')
                 .closest('.menu-item-card').find('.item-name').text().trim();
  
  if (confirm('Nhân bản món "' + itemName + '"?')) {
    // Get item data from the edit button
    var editButton = $('button[onclick*="editMenuItem(' + itemId + ')"]');
    var onclickAttr = editButton.attr('onclick');
    
    // Extract data from onclick attribute (simple approach)
    try {
      var itemData = eval('(' + onclickAttr.match(/editMenuItem\(\d+,\s*(\{[^}]+\})\)/)[1] + ')');
      
      // Pre-fill add form with duplicated data
      $('#addItemModal input[name="item_name"]').val(itemData.name + ' (Copy)');
      $('#addItemModal input[name="item_price"]').val(itemData.price);
      $('#addItemModal textarea[name="item_description"]').val(itemData.description || '');
      $('#addItemModal input[name="item_image"]').val(itemData.image || '');
      $('#addItemModal input[name="is_popular"]').prop('checked', itemData.is_popular == '1');
      $('#addItemModal input[name="is_available"]').prop('checked', itemData.is_available == '1');
      
      // Show add modal
      $('#addItemModal').modal('show');
    } catch (e) {
      alert('Có lỗi khi nhân bản món ăn');
    }
  }
}

// Keyboard shortcuts
$(document).keydown(function(e) {
  // Ctrl/Cmd + N = New item
  if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
    e.preventDefault();
    $('#addItemModal').modal('show');
  }
  
  // Escape = Close modals
  if (e.key === 'Escape') {
    $('.modal').modal('hide');
  }
});
</script>