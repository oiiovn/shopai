<div class="card">
  <div class="card-header">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h4><i class="fa fa-utensils mr-2"></i>Quản lý thực đơn</h4>
        <p class="text-muted mb-0">Tạo và quản lý thực đơn cho {$spage['page_title']}</p>
      </div>
      <a href="{$system['system_url']}/pages/{$spage['page_name']}" class="btn btn-outline-primary">
        <i class="fa fa-eye mr-2"></i>Xem thực đơn công khai
      </a>
    </div>
    
    <ul class="nav nav-tabs mt-3">
      <li class="nav-item">
        <a class="nav-link {if $menu_view == "" || $menu_view == "items"}active{/if}" href="{$system['system_url']}/pages/{$spage['page_name']}?view=menu&menu_view=items">
          <i class="fa fa-list mr-2"></i>Danh sách món
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {if $menu_view == "categories"}active{/if}" href="{$system['system_url']}/pages/{$spage['page_name']}?view=menu&menu_view=categories">
          <i class="fa fa-folder mr-2"></i>Danh mục
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {if $menu_view == "settings"}active{/if}" href="{$system['system_url']}/pages/{$spage['page_name']}?view=menu&menu_view=settings">
          <i class="fa fa-cog mr-2"></i>Cài đặt
        </a>
      </li>
    </ul>
  </div>

  <div class="card-body">
    {if $menu_view == "categories"}
      {include file='page_menu_categories.tpl'}
      
    {elseif $menu_view == "settings"}
      {include file='page_menu_settings.tpl'}
      
    {else}
      {include file='page_menu_items.tpl'}
    {/if}
  </div>
</div>

{include file='page_menu_modals.tpl'}

<!-- Ensure jQuery is loaded -->
<script>
// Check if jQuery is loaded, if not load it
if (typeof $ === 'undefined') {
    console.log('jQuery not found, loading...');
    var script = document.createElement('script');
    script.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
    script.onload = function() {
        console.log('jQuery loaded successfully');
    };
    document.head.appendChild(script);
}
</script>

<script src="{$system['system_url']}/js/page-menu.js?v={$smarty.now}"></script>

<script>
// Override editMenuItem function to ensure it works
function editMenuItem(itemId, itemData) {
    console.log('Edit item called:', itemId, itemData);
    
    // Populate edit form with current data
    $('#edit_item_id').val(itemId);
    $('#edit_item_name').val(itemData.name);
    $('#edit_item_price').val(itemData.price);
    $('#edit_item_description').val(itemData.description || '');
    $('#edit_item_image').val(itemData.image || '');
    $('#edit_item_image_url').val(itemData.image || '');
    $('#edit_is_popular').prop('checked', itemData.is_popular == '1');
    $('#edit_is_available').prop('checked', itemData.is_available == '1');
    
    // Show current image if exists
    if (itemData.image) {
        $('#editItemPreviewImg').attr('src', itemData.image);
        $('#editItemImagePreview').show();
    } else {
        $('#editItemImagePreview').hide();
    }
    
    // Set item_id in hidden field (this is what AJAX handler expects)
    $('#edit_item_id').val(itemId);
    console.log('Item ID set to:', itemId);
    
    // Show modal
    $('#editItemModal').modal('show');
}

// Wait for jQuery to be available
function waitForJQuery(callback) {
    if (typeof $ !== 'undefined' && typeof $.fn.modal !== 'undefined') {
        callback();
    } else {
        setTimeout(function() { waitForJQuery(callback); }, 100);
    }
}

// Image preview and file handling functions
function setupImagePreview() {
    // Add item image preview
    $('#addItemImageFile').on('change', function() {
        handleImagePreview(this, 'addItem');
    });
    
    // Edit item image preview
    $('#editItemImageFile').on('change', function() {
        handleImagePreview(this, 'editItem');
    });
}

function handleImagePreview(input, prefix) {
    var file = input.files[0];
    if (file) {
        // Validate file type
        if (!file.type.match('image.*')) {
            showNotification('Vui lòng chọn file ảnh hợp lệ (JPG, PNG, GIF)', 'error');
            input.value = '';
            return;
        }
        
        // Validate file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            showNotification('File ảnh quá lớn. Vui lòng chọn ảnh nhỏ hơn 5MB', 'error');
            input.value = '';
            return;
        }
        
        // Show preview
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#' + prefix + 'PreviewImg').attr('src', e.target.result);
            $('#' + prefix + 'ImagePreview').show();
        };
        reader.readAsDataURL(file);
    }
}

function clearAddItemImage() {
    $('#addItemImageFile').val('');
    $('#addItemPreviewImg').attr('src', '');
    $('#addItemImagePreview').hide();
}

function clearEditItemImage() {
    $('#editItemImageFile').val('');
    $('#editItemPreviewImg').attr('src', '');
    $('#edit_item_image').val('');
    $('#editItemImagePreview').hide();
}

// All form submissions - bind after modal is shown
waitForJQuery(function() {
    console.log('jQuery loaded, setting up handlers');
    
    // Setup image preview
    setupImagePreview();
    
    $(document).on('shown.bs.modal', '#editItemModal', function() {
    console.log('Edit modal shown, binding form handler');
    
    // Remove any existing handlers to avoid duplicates
    $('#editItemForm').off('submit');
    
    // Bind new handler
    $('#editItemForm').on('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        // Create FormData for file upload
        var formData = new FormData(this);
        var itemId = $('#edit_item_id').val();
        var formUrl = '{$system.system_url}/includes/ajax/pages/menu.php?do=edit_item&item_id=' + itemId;
        
        console.log('Submitting edit form with file upload:', formUrl);
        
        // Show loading
        var $submitBtn = $(this).find('button[type="submit"]');
        var originalText = $submitBtn.html();
        $submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Đang lưu...').prop('disabled', true);
        
        $.ajax({
            url: formUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                console.log('Edit response:', response);
                if (response.success || response.callback) {
                    // Show toast notification
                    showNotification('Đã lưu thay đổi thành công!', 'success');
                    $('#editItemModal').modal('hide');
                    // Reload page content
                    setTimeout(function() {
                        location.reload(true); // Force reload from server
                    }, 500);
                } else {
                    showNotification('Có lỗi xảy ra: ' + (response.message || 'Unknown error'), 'error');
                    $submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.log('Edit error:', xhr.responseText);
                showNotification('Có lỗi kết nối xảy ra: ' + error, 'error');
                $submitBtn.html(originalText).prop('disabled', false);
            }
        });
        
        return false;
    });
    });

    // Add item form - bind when modal shown
    $(document).on('shown.bs.modal', '#addItemModal', function() {
    console.log('Add item modal shown, binding form handler');
    
    $('#addItemForm').off('submit');
    
    // Add item form submission
    $('#addItemForm').on('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        // Create FormData for file upload
        var formData = new FormData(this);
        var formUrl = '{$system.system_url}/includes/ajax/pages/menu.php?do=add_item&page_id={$spage['page_id']}';
        
        console.log('Submitting add form with file upload:', formUrl);
        
        // Show loading
        var $submitBtn = $(this).find('button[type="submit"]');
        var originalText = $submitBtn.html();
        $submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Đang thêm...').prop('disabled', true);
        
        $.ajax({
            url: formUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                console.log('Add response:', response);
                if (response.success || response.callback) {
                    showNotification('Đã thêm món thành công!', 'success');
                    $('#addItemModal').modal('hide');
                    // Reset form
                    $('#addItemForm')[0].reset();
                    $('#addItemImagePreview').hide();
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                } else {
                    showNotification('Có lỗi xảy ra: ' + (response.message || 'Unknown error'), 'error');
                    $submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.log('Add error:', xhr.responseText);
                showNotification('Có lỗi kết nối xảy ra: ' + error, 'error');
                $submitBtn.html(originalText).prop('disabled', false);
            }
        });
        
        return false;
    });
    });

    // Add category form - bind when modal shown
    $(document).on('shown.bs.modal', '#addCategoryModal', function() {
    console.log('Add category modal shown, binding form handler');
    
    $('#addCategoryForm').off('submit');
    
    // Add category form submission
    $('#addCategoryForm').on('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var formData = $(this).serialize();
        var formUrl = $(this).attr('data-url');
        
        console.log('Submitting category form:', formUrl, formData);
        
        // Show loading
        var $submitBtn = $(this).find('button[type="submit"]');
        var originalText = $submitBtn.html();
        $submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Đang thêm...').prop('disabled', true);
        
        $.ajax({
            url: formUrl,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                console.log('Category response:', response);
                if (response.success || response.callback) {
                    showNotification('Đã thêm danh mục thành công!', 'success');
                    $('#addCategoryModal').modal('hide');
                    window.location.reload();
                } else {
                    showNotification('Có lỗi xảy ra: ' + (response.message || 'Unknown error'), 'error');
                    $submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.log('Category error:', xhr.responseText);
                showNotification('Có lỗi kết nối xảy ra: ' + error, 'error');
                $submitBtn.html(originalText).prop('disabled', false);
            }
        });
        
        return false;
    });
    });
});

// Override deleteMenuItem function - also wait for jQuery
waitForJQuery(function() {
    window.deleteMenuItem = function(itemId, itemName) {
        // Get item details from the DOM
        var $itemCard = $('[data-item-id="' + itemId + '"]');
        var itemPrice = $itemCard.find('.item-price').text() || 'N/A';
        var itemCategory = $itemCard.find('.item-category').text() || 'N/A';
        
        // Populate modal with item details
        $('#delete-item-name').text(itemName);
        $('#delete-item-price').text(itemPrice);
        $('#delete-item-category').text(itemCategory);
        
        // Store item ID for deletion
        $('#confirmDeleteBtn').data('item-id', itemId);
        $('#confirmDeleteBtn').data('item-name', itemName);
        
        // Show modal
        $('#deleteItemModal').modal('show');
    };
    
    // Handle confirm delete button click
    $('#confirmDeleteBtn').on('click', function() {
        var itemId = $(this).data('item-id');
        var itemName = $(this).data('item-name');
        
        // Disable button and show loading
        var $btn = $(this);
        var originalText = $btn.html();
        $btn.html('<i class="fa fa-spinner fa-spin me-1"></i>Đang xóa...').prop('disabled', true);
        
        $.ajax({
            url: '{$system.system_url}/includes/ajax/pages/menu.php?do=delete_item&item_id=' + itemId,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success || response.callback) {
                    showNotification('Đã xóa món "' + itemName + '" thành công!', 'success');
                    $('#deleteItemModal').modal('hide');
                    setTimeout(function() {
                        location.reload(true);
                    }, 500);
                } else {
                    showNotification('Có lỗi xảy ra: ' + (response.message || 'Unknown error'), 'error');
                    $btn.html(originalText).prop('disabled', false);
                }
            },
            error: function() {
                showNotification('Có lỗi kết nối xảy ra', 'error');
                $btn.html(originalText).prop('disabled', false);
            }
        });
    });
});

// Override toggleItemAvailability function  
waitForJQuery(function() {
    window.toggleItemAvailability = function(itemId, isAvailable) {
    $.ajax({
        url: '{$system.system_url}/includes/ajax/pages/menu.php?do=toggle_availability&item_id=' + itemId,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                var $checkbox = $('input[onchange*="' + itemId + '"]');
                var $label = $checkbox.next('label');
                
                if (response.new_status == '1') {
                    $label.html('<span class="text-success"><i class="fa fa-check-circle"></i> Còn hàng</span>');
                    showNotification('Đã đánh dấu "Còn hàng"', 'success');
                } else {
                    $label.html('<span class="text-danger"><i class="fa fa-times-circle"></i> Hết hàng</span>');
                    showNotification('Đã đánh dấu "Hết hàng"', 'warning');
                }
                
                var $card = $checkbox.closest('.menu-item-card');
                if (response.new_status == '1') {
                    $card.removeClass('unavailable');
                } else {
                    $card.addClass('unavailable');
                }
            } else {
                showNotification('Có lỗi xảy ra', 'error');
                $('input[onchange*="' + itemId + '"]').prop('checked', !isAvailable);
            }
        },
        error: function() {
            alert('Có lỗi kết nối xảy ra');
            $('input[onchange*="' + itemId + '"]').prop('checked', !isAvailable);
        }
    });
    };
});

// Test function to debug edit submission
waitForJQuery(function() {
    window.testEditSubmit = function() {
    var itemId = $('#edit_item_id').val();
    var formData = $('#editItemForm').serialize();
    var formUrl = '{$system.system_url}/includes/ajax/pages/menu.php?do=edit_item&item_id=' + itemId;
    
    console.log('TEST - Item ID:', itemId);
    console.log('TEST - Form data:', formData);
    console.log('TEST - URL:', formUrl);
    
    $.ajax({
        url: formUrl,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            console.log('TEST - Success response:', response);
            showNotification('Test thành công! Response: ' + JSON.stringify(response), 'success');
        },
        error: function(xhr, status, error) {
            console.log('TEST - Error:', xhr.responseText);
            showNotification('Test lỗi: ' + xhr.responseText, 'error');
        }
    });
    };
});

function filterByCategory(categoryId) {
  if (categoryId === '') {
    $('.menu-category-section').show();
  } else {
    $('.menu-category-section').hide();
    $('.menu-category-section[data-category-id="' + categoryId + '"]').show();
  }
}

function editCategory(categoryId) {
  var newName = prompt('Nhập tên danh mục mới:');
  if (newName) {
    $.ajax({
      url: '{$system.system_url}/includes/ajax/pages/menu.php?do=edit_category&category_id=' + categoryId,
      type: 'POST',
      data: { category_name: newName, category_icon: 'fa-utensils', display_order: 1 },
      success: function() { window.location.reload(); },
      error: function() { showNotification('Có lỗi xảy ra', 'error'); }
    });
  }
}


// Toast notification function
function showNotification(message, type = 'info') {
    // Create toast container if not exists
    if (!$('#toast-container').length) {
        $('body').append('<div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>');
    }
    
    // Create toast element
    var toastClass = 'alert-success';
    var iconClass = 'fa-check-circle';
    if (type === 'error') {
        toastClass = 'alert-danger';
        iconClass = 'fa-exclamation-circle';
    } else if (type === 'warning') {
        toastClass = 'alert-warning';
        iconClass = 'fa-exclamation-triangle';
    }
    
    var toastId = 'toast-' + Date.now();
    var toastHtml = '<div id="' + toastId + '" class="alert ' + toastClass + ' alert-dismissible fade show" role="alert" style="min-width: 300px; margin-bottom: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">' +
        '<i class="fa ' + iconClass + ' me-2"></i>' +
        message +
        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
        '</div>';
    
    // Add toast to container
    $('#toast-container').append(toastHtml);
    
    // Auto remove after 3 seconds
    setTimeout(function() {
        $('#' + toastId).fadeOut(300, function() {
            $(this).remove();
        });
    }, 3000);
}
</script>