{* Template quản lý danh mục *}
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5>Quản lý danh mục</h5>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
    <i class="fa fa-plus mr-2"></i>Thêm danh mục
  </button>
</div>

{if $menu_categories}
  <div class="row">
    {foreach $menu_categories as $category}
      <div class="col-md-4 mb-3">
        <div class="card">
          <div class="card-body">
            <h6><i class="{$category.category_icon} mr-2"></i>{$category.category_name}</h6>
            <p><small class="text-muted">{$category.items_count} món ăn</small></p>
            <button class="btn btn-sm btn-info mr-2" onclick="editCategory({$category.category_id})">Sửa</button>
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
      <i class="fa fa-plus mr-2"></i>Thêm danh mục đầu tiên
    </button>
  </div>
{/if}
