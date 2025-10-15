/**
 * Gray Verification System - Frontend JavaScript
 * 
 * @package Sngine
 * @author TCSN Team
 */

// Global variables
let selectedVerificationLevel = null;

// Initialize verification system
$(document).ready(function() {
    initVerificationSystem();
});

function initVerificationSystem() {
    // Add click handlers for verification option cards
    $('.verification-option').on('click', function() {
        $('.verification-option').removeClass('selected border-primary');
        $(this).addClass('selected border-primary');
    });
    
    // Add hover effects
    $('.verification-option').hover(
        function() {
            if (!$(this).hasClass('selected')) {
                $(this).addClass('border-secondary');
            }
        },
        function() {
            if (!$(this).hasClass('selected')) {
                $(this).removeClass('border-secondary');
            }
        }
    );
}

// Select verification level
function selectVerificationLevel(level) {
    selectedVerificationLevel = level;
    
    // Hide selection screen
    $('.card-body').first().fadeOut(300, function() {
        // Show appropriate form
        if (level === 'gray') {
            $('#gray-verification-form').fadeIn(300);
        } else if (level === 'blue') {
            $('#blue-verification-form').fadeIn(300);
        }
    });
}

// Back to selection
function backToSelection() {
    $('.verification-form').fadeOut(300, function() {
        $('.card-body').first().fadeIn(300);
        selectedVerificationLevel = null;
        $('.verification-option').removeClass('selected border-primary');
    });
}

// Check page eligibility for gray verification
function checkGrayEligibility(pageId) {
    return $.post('/admin/verification.php', {
        action: 'check_eligibility',
        page_id: pageId
    });
}

// Show verification requirements based on admin settings
function showVerificationRequirements(level) {
    const requirements = {
        gray: [
            'Minimum page likes: 50',
            'Minimum posts: 5',
            'Active for at least 14 days',
            'Complete business information',
            'Page description required'
        ],
        blue: [
            'All gray verification requirements',
            'Company incorporation documents',
            'Tax registration documents',
            'Verified business address',
            'Professional business website',
            'Manual admin review'
        ]
    };
    
    const reqList = requirements[level] || [];
    let html = '<div class="alert alert-info"><h6>Requirements:</h6><ul class="mb-0">';
    
    reqList.forEach(req => {
        html += `<li>${req}</li>`;
    });
    
    html += '</ul></div>';
    
    return html;
}

// Validation functions
function validateGrayVerificationForm() {
    const message = $('textarea[name="message"]').val().trim();
    
    if (message.length < 50) {
        showError('Please provide at least 50 characters describing your business');
        return false;
    }
    
    return true;
}

function validateBlueVerificationForm() {
    const photo = $('input[name="photo"]').val();
    const passport = $('input[name="passport"]').val();
    const message = $('textarea[name="message"]').val().trim();
    
    if (!photo || !passport) {
        showError('Please upload both required documents');
        return false;
    }
    
    if (message.length < 100) {
        showError('Please provide at least 100 characters explaining why your page deserves blue verification');
        return false;
    }
    
    return true;
}

// Form submission handlers
$(document).on('submit', 'form[data-url*="level=gray"]', function(e) {
    if (!validateGrayVerificationForm()) {
        e.preventDefault();
        return false;
    }
});

$(document).on('submit', 'form[data-url*="level=blue"]', function(e) {
    if (!validateBlueVerificationForm()) {
        e.preventDefault();
        return false;
    }
});

// Upgrade form validation
$(document).on('submit', 'form[data-url*="upgrade=true"]', function(e) {
    const businessReg = $('input[name="business_registration"]').val();
    const taxDoc = $('input[name="tax_document"]').val();
    const upgradeMessage = $('textarea[name="upgrade_message"]').val().trim();
    
    if (!businessReg || !taxDoc) {
        showError('Please upload both required documents for blue verification');
        e.preventDefault();
        return false;
    }
    
    if (upgradeMessage.length < 100) {
        showError('Please provide at least 100 characters explaining why your page deserves blue verification');
        e.preventDefault();
        return false;
    }
});

// Utility functions
function showError(message) {
    // Create or update error alert
    let errorAlert = $('.alert-danger');
    if (errorAlert.length === 0) {
        errorAlert = $('<div class="alert alert-danger mt-3"></div>');
        $('form').append(errorAlert);
    }
    
    errorAlert.html('<i class="fa fa-exclamation-triangle mr-2"></i>' + message).show();
    
    // Scroll to error
    $('html, body').animate({
        scrollTop: errorAlert.offset().top - 100
    }, 500);
    
    // Hide after 5 seconds
    setTimeout(() => {
        errorAlert.fadeOut();
    }, 5000);
}

function showSuccess(message) {
    // Create or update success alert
    let successAlert = $('.alert-success');
    if (successAlert.length === 0) {
        successAlert = $('<div class="alert alert-success mt-3"></div>');
        $('form').append(successAlert);
    }
    
    successAlert.html('<i class="fa fa-check mr-2"></i>' + message).show();
    
    // Scroll to success message
    $('html, body').animate({
        scrollTop: successAlert.offset().top - 100
    }, 500);
}

// Character counter for textareas
$(document).on('input', 'textarea[name="message"], textarea[name="upgrade_message"]', function() {
    const current = $(this).val().length;
    const min = $(this).attr('name') === 'upgrade_message' ? 100 : 50;
    const max = 1000;
    
    let counterId = $(this).attr('id') + '-counter';
    let counter = $('#' + counterId);
    
    if (counter.length === 0) {
        counter = $(`<div id="${counterId}" class="form-text text-muted small mt-1"></div>`);
        $(this).after(counter);
    }
    
    let color = 'text-muted';
    if (current < min) {
        color = 'text-danger';
    } else if (current > max * 0.9) {
        color = 'text-warning';
    } else {
        color = 'text-success';
    }
    
    counter.removeClass('text-muted text-danger text-warning text-success').addClass(color);
    counter.text(`${current}/${max} characters (minimum: ${min})`);
});

// Preview uploaded documents
$(document).on('change', '.js_x-image-input', function() {
    const input = $(this);
    const preview = input.closest('.x-image');
    
    if (input.val()) {
        preview.addClass('has-file');
        
        // Add file name display
        let fileName = input.val().split('\\').pop();
        let fileDisplay = preview.find('.file-name');
        if (fileDisplay.length === 0) {
            fileDisplay = $('<div class="file-name small text-success mt-1"></div>');
            preview.append(fileDisplay);
        }
        fileDisplay.text('✓ ' + fileName);
    } else {
        preview.removeClass('has-file');
        preview.find('.file-name').remove();
    }
});

// Auto-save form data to localStorage (for user convenience)
function autoSaveFormData() {
    const formData = {};
    
    $('input[type="text"], textarea').each(function() {
        const name = $(this).attr('name');
        const value = $(this).val();
        if (name && value) {
            formData[name] = value;
        }
    });
    
    localStorage.setItem('verification_form_data', JSON.stringify(formData));
}

function restoreFormData() {
    const saved = localStorage.getItem('verification_form_data');
    if (saved) {
        try {
            const formData = JSON.parse(saved);
            Object.keys(formData).forEach(name => {
                $(`input[name="${name}"], textarea[name="${name}"]`).val(formData[name]);
            });
        } catch (e) {
            console.log('Error restoring form data:', e);
        }
    }
}

// Clear saved data on successful submission
$(document).on('ajax:success', 'form', function() {
    localStorage.removeItem('verification_form_data');
});

// Auto-save every 30 seconds
setInterval(autoSaveFormData, 30000);

// Restore data on page load
$(document).ready(function() {
    restoreFormData();
});
