{* Template danh sách món ăn *}
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5>Danh sách món ăn</h5>
  <div>
    <select class="form-select d-inline-block me-2" id="filter-category" onchange="filterByCategory(this.value)" style="width: auto;">
      <option value="">Tất cả danh mục</option>
      {foreach $menu_categories as $category}
        <option value="{$category.category_id}">{$category.category_name}</option>
      {/foreach}
    </select>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
      <i class="fa fa-plus mr-2"></i>Thêm món mới
    </button>
  </div>
</div>

{if $menu_categories}
  {foreach $menu_categories as $category}
    <div class="menu-category-section mb-4" data-category-id="{$category.category_id}">
      <h6 class="border-bottom pb-2 mb-3">
        <i class="{$category.category_icon} text-primary mr-2"></i>
        {$category.category_name}
        <span class="badge bg-light text-dark ms-2">{$category.items_count} món</span>
      </h6>
      
      {if $category.items}
        <div class="row">
          {foreach $category.items as $item}
            <div class="col-lg-6 mb-3">
              <div class="card menu-item-card" data-item-id="{$item.item_id}">
                <div class="card-body">
                  <div class="item-category d-none">{$category.category_name}</div>
                  <div class="d-flex justify-content-between">
                    <div class="flex-grow-1">
                      <h6 class="item-name">
                        {$item.item_name}
                        {if $item.is_popular == '1'}
                          <span class="badge bg-warning text-dark ms-1">
                            <i class="fa fa-fire"></i> Hot
                          </span>
                        {/if}
                      </h6>
                      <p class="item-description text-muted small">{$item.item_description}</p>
                      <strong class="text-primary item-price">{$item.item_price|number_format:0:",":"."} đ</strong>
                    </div>
                    
                    {if $item.item_image}
                      <img src="{$item.item_image}" class="rounded ms-3" width="60" height="60" style="object-fit: cover;">
                    {/if}
                  </div>
                  
                  <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" {if $item.is_available == '1'}checked{/if} 
                             onchange="toggleItemAvailability({$item.item_id}, this.checked)">
                      <label class="form-check-label small">
                        {if $item.is_available == '1'}Còn hàng{else}Hết hàng{/if}
                      </label>
                    </div>
                    
                    <div>
                      <button class="btn btn-sm btn-outline-info me-1" onclick="editMenuItem({$item.item_id}, {
                        name: '{$item.item_name|escape:'javascript'}',
                        price: {$item.item_price},
                        description: '{$item.item_description|escape:'javascript'}',
                        image: '{$item.item_image|escape:'javascript'}',
                        is_popular: '{$item.is_popular}',
                        is_available: '{$item.is_available}'
                      })" title="Sửa món">
                        <i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-outline-danger" onclick="deleteMenuItem({$item.item_id}, '{$item.item_name|escape:'javascript'}')" title="Xóa món">
                        <i class="fa fa-trash"></i>
                      </button>
                    </div>
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
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
      <i class="fa fa-plus mr-2"></i>Thêm món đầu tiên
    </button>
  </div>
{/if}
