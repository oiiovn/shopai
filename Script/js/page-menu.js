/**
 * Page Menu Management JavaScript
 */

// Show notification function
function showNotification(type, message) {
    // Create notification element
    var notification = $('<div class="alert alert-' + (type === 'success' ? 'success' : 'danger') + ' alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">' +
        '<i class="fa fa-' + (type === 'success' ? 'check-circle' : 'exclamation-circle') + ' mr-2"></i>' +
        message +
        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
        '</div>');
    
    // Add to body
    $('body').append(notification);
    
    // Auto remove after 3 seconds
    setTimeout(function() {
        notification.alert('close');
    }, 3000);
}

// Toggle item availability
function toggleItemAvailability(itemId, isAvailable) {
    $.ajax({
        url: 'includes/ajax/pages/menu.php?do=toggle_availability&item_id=' + itemId,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Update status text next to the toggle
                var $checkbox = $('input[onchange*="' + itemId + '"]');
                var $label = $checkbox.next('label');
                
                if (response.new_status == '1') {
                    $label.html('<span class="text-success"><i class="fa fa-check-circle"></i> Còn hàng</span>');
                    showNotification('success', 'Món ăn đã được đánh dấu "Còn hàng"');
                } else {
                    $label.html('<span class="text-danger"><i class="fa fa-times-circle"></i> Hết hàng</span>');
                    showNotification('success', 'Món ăn đã được đánh dấu "Hết hàng"');
                }
                
                // Update card visual state
                var $card = $checkbox.closest('.menu-item-card');
                if (response.new_status == '1') {
                    $card.removeClass('unavailable');
                } else {
                    $card.addClass('unavailable');
                }
            } else {
                showNotification('error', 'Có lỗi xảy ra: ' + (response.message || 'Unknown error'));
                // Revert checkbox
                $('input[onchange*="' + itemId + '"]').prop('checked', !isAvailable);
            }
        },
        error: function() {
            alert('Có lỗi kết nối xảy ra');
            // Revert checkbox
            $('input[onchange*="' + itemId + '"]').prop('checked', !isAvailable);
        }
    });
}

// Edit menu item
function editMenuItem(itemId, itemData) {
    // Populate edit form with current data
    $('#edit_item_id').val(itemId);
    $('#edit_item_name').val(itemData.name);
    $('#edit_item_price').val(itemData.price);
    $('#edit_item_description').val(itemData.description || '');
    $('#edit_item_image').val(itemData.image || '');
    $('#edit_is_popular').prop('checked', itemData.is_popular == '1');
    $('#edit_is_available').prop('checked', itemData.is_available == '1');
    
    // Show image preview if exists
    if (itemData.image && (itemData.image.startsWith('http://') || itemData.image.startsWith('https://'))) {
        $('#edit_preview_img').attr('src', itemData.image);
        $('#edit_image_preview').show();
    } else {
        $('#edit_image_preview').hide();
    }
    
    // Update form action URL
    $('#editItemForm').attr('data-url', 'includes/ajax/pages/menu.php?do=edit_item&item_id=' + itemId);
    
    // Show modal
    $('#editItemModal').modal('show');
}

// Delete menu item
function deleteMenuItem(itemId, itemName) {
    // Get item name from DOM if not provided
    if (!itemName) {
        itemName = $('button[onclick*="deleteMenuItem(' + itemId + ')"]')
                   .closest('.menu-item-card').find('.item-name').text().trim();
    }
    
    if (confirm('Bạn có chắc muốn xóa món "' + itemName + '"?\n\nHành động này không thể hoàn tác.')) {
        // Show loading state
        var $deleteBtn = $('button[onclick*="deleteMenuItem(' + itemId + ')"]');
        var originalText = $deleteBtn.html();
        $deleteBtn.html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);
        
        $.ajax({
            url: 'includes/ajax/pages/menu.php?do=delete_item&item_id=' + itemId,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success || response.callback) {
                    // Show success message
                    showNotification('success', 'Đã xóa món "' + itemName + '" thành công!');
                    // Fade out the item card before reload
                    $deleteBtn.closest('.menu-item-card').fadeOut(300, function() {
                        window.location.reload();
                    });
                } else {
                    alert('Có lỗi xảy ra: ' + (response.message || 'Unknown error'));
                    $deleteBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function() {
                alert('Có lỗi kết nối xảy ra');
                $deleteBtn.html(originalText).prop('disabled', false);
            }
        });
    }
}

// Edit category
function editCategory(categoryId) {
    // Get category data from DOM or make AJAX call
    var categoryName = $('.menu-category-section[data-category-id="' + categoryId + '"] h5').text().trim();
    
    // Simple prompt for now - can be enhanced with modal later
    var newName = prompt('Nhập tên danh mục mới:', categoryName.replace(/.*\s/, ''));
    if (newName && newName !== categoryName) {
        $.ajax({
            url: 'includes/ajax/pages/menu.php?do=edit_category&category_id=' + categoryId,
            type: 'POST',
            data: {
                category_name: newName,
                category_icon: 'fa-utensils',
                display_order: 1
            },
            dataType: 'json',
            success: function(response) {
                if (response.success || response.callback) {
                    window.location.reload();
                } else {
                    alert('Có lỗi xảy ra: ' + (response.message || 'Unknown error'));
                }
            },
            error: function() {
                alert('Có lỗi kết nối xảy ra');
            }
        });
    }
}

// Delete category
function deleteCategory(categoryId) {
    if (confirm('Bạn có chắc muốn xóa danh mục này? (Chỉ có thể xóa danh mục không có món nào)')) {
        $.ajax({
            url: 'includes/ajax/pages/menu.php?do=delete_category&category_id=' + categoryId,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success || response.callback) {
                    window.location.reload();
                } else {
                    alert('Có lỗi xảy ra: ' + (response.message || 'Unknown error'));
                }
            },
            error: function() {
                alert('Có lỗi kết nối xảy ra');
            }
        });
    }
}

// Filter by category
function filterByCategory(categoryId) {
    if (categoryId === '') {
        // Show all categories
        $('.menu-category-section').show();
    } else {
        // Hide all, show selected
        $('.menu-category-section').hide();
        $('.menu-category-section[data-category-id="' + categoryId + '"]').show();
    }
}

// Order item (for public menu)
$(document).on('click', '.js_order-item', function() {
    var itemId = $(this).data('item-id');
    var itemName = $(this).data('item-name');
    var itemPrice = $(this).data('item-price');
    
    // TODO: Implement order functionality
    alert('Đặt món: ' + itemName + ' - ' + itemPrice.toLocaleString() + 'đ\n\nTính năng đặt món đang được phát triển.');
});

// Auto-generate slug from name
$(document).on('input', 'input[name="item_name"]', function() {
    var name = $(this).val();
    var slug = name.toLowerCase()
        .replace(/[àáạảãâầấậẩẫăằắặẳẵ]/g, 'a')
        .replace(/[èéẹẻẽêềếệểễ]/g, 'e')
        .replace(/[ìíịỉĩ]/g, 'i')
        .replace(/[òóọỏõôồốộổỗơờớợởỡ]/g, 'o')
        .replace(/[ùúụủũưừứựửữ]/g, 'u')
        .replace(/[ỳýỵỷỹ]/g, 'y')
        .replace(/đ/g, 'd')
        .replace(/[^a-z0-9\s]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    
    // Update slug field if exists
    $('input[name="item_slug"]').val(slug);
});

// Auto-generate category slug
$(document).on('input', 'input[name="category_name"]', function() {
    var name = $(this).val();
    var slug = name.toLowerCase()
        .replace(/[àáạảãâầấậẩẫăằắặẳẵ]/g, 'a')
        .replace(/[èéẹẻẽêềếệểễ]/g, 'e')
        .replace(/[ìíịỉĩ]/g, 'i')
        .replace(/[òóọỏõôồốộổỗơờớợởỡ]/g, 'o')
        .replace(/[ùúụủũưừứựửữ]/g, 'u')
        .replace(/[ỳýỵỷỹ]/g, 'y')
        .replace(/đ/g, 'd')
        .replace(/[^a-z0-9\s]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    
    // Update slug field if exists
    $('input[name="category_slug"]').val(slug);
});

// Form success handling
$(document).on('ajax:success', '.js_ajax-forms', function(e, data) {
    if (data.callback && data.callback.includes('reload')) {
        showNotification('success', 'Thao tác thành công!');
        setTimeout(function() {
            window.location.reload();
        }, 1000);
    }
});

// Form error handling
$(document).on('ajax:error', '.js_ajax-forms', function(e, xhr) {
    var errorMsg = 'Có lỗi xảy ra';
    try {
        var response = JSON.parse(xhr.responseText);
        if (response.message) {
            errorMsg = response.message;
        }
    } catch(e) {}
    
    showNotification('error', errorMsg);
});

// Enhanced form validation
$(document).ready(function() {
    // Real-time price formatting
    $(document).on('input', 'input[name="item_price"]', function() {
        var value = $(this).val().replace(/[^0-9]/g, '');
        if (value) {
            $(this).val(parseInt(value));
        }
    });
    
    // Auto-focus first input in modals
    $('.modal').on('shown.bs.modal', function() {
        $(this).find('input:first').focus();
    });
    
    // Clear form when modal closes
    $('.modal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $(this).find('.is-invalid').removeClass('is-invalid');
    });
});
