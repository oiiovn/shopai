<!-- ads -->
{include file='_ads.tpl' _ads=$ads_master['footer'] _master=true}
<!-- ads -->

{if !in_array($page, ['index', 'profile', 'page', 'group', 'event'])}
  {include file='_footer.links.tpl'}
{/if}

</div>
<!-- main wrapper -->

<!-- Dependencies CSS [Twemoji-Awesome] -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zamblektech/twemoji-amazing@latest/twemoji-amazing.css">
<!-- Dependencies CSS [Twemoji-Awesome] -->

<!-- Prefetch & InstantPage: tăng tốc chuyển trang -->
<script src="https://instant.page/5.2.0" type="module" integrity="sha384-jnZyxPjiipYXnSU0ygqeac2q7CVYMbh84q0uHVRRxEtvFPiQYbXWUorga2aqZJ0z" crossorigin></script>
<!-- Prefetch & InstantPage -->

<!-- JS Files -->
{include file='_js_files.tpl'}
<!-- JS Files -->

<!-- JS Templates -->
{include file='_js_templates.tpl'}
<!-- JS Templates -->

<!-- Footer Custom JavaScript -->
{if $system['custome_js_footer']}
  <script>
    {html_entity_decode($system['custome_js_footer'], ENT_QUOTES)}
  </script>
{/if}

<!-- Phương Nhi Chat Widget -->
{include file='phuong_nhi_widget.tpl'}
<!-- Footer Custom JavaScript -->

<!-- Analytics Code -->
{if $system['analytics_code']}{html_entity_decode($system['analytics_code'], ENT_QUOTES)}{/if}
<!-- Analytics Code -->

<!-- Sounds -->
{if $user->_logged_in}
  <!-- Notification -->
  <audio id="notification-sound" preload="auto">
    <source src="{$system['system_url']}/includes/assets/sounds/notification.mp3" type="audio/mpeg">
  </audio>
  <!-- Notification -->
  <!-- Chat -->
  <audio id="chat-sound" preload="auto">
    <source src="{$system['system_url']}/includes/assets/sounds/chat.mp3" type="audio/mpeg">
  </audio>
  <!-- Chat -->
  <!-- Call -->
  <audio id="chat-calling-sound" preload="auto" loop="true">
    <source src="{$system['system_url']}/includes/assets/sounds/calling.mp3" type="audio/mpeg">
  </audio>
  <!-- Call -->
  <!-- Video -->
  <audio id="chat-ringing-sound" preload="auto" loop="true">
    <source src="{$system['system_url']}/includes/assets/sounds/ringing.mp3" type="audio/mpeg">
  </audio>
  <!-- Video -->
{/if}
<!-- Sounds -->

<!-- Check Profile Images -->
{if $user->_logged_in && $page != 'profile'}
  <script>
    $(document).ready(function() {
      // Get user data from server
      var userPictureDefault = {if $user->_data['user_picture_default']}true{else}false{/if};
      var userCover = '{$user->_data['user_cover']}';
      var username = '{$user->_data['user_name']}';
      
      // Check if avatar or cover is missing
      var missingAvatar = userPictureDefault;
      var missingCover = !userCover || userCover === '';
      
      // Show modal if images are missing
      if (missingAvatar || missingCover) {
        // Mark that we're showing the profile images modal
        $('#modal').attr('data-profile-images-required', 'true');
        
        // Show modal immediately
        modal('#modal-upload-profile-images', {
          username: username,
          missing_avatar: missingAvatar,
          missing_cover: missingCover,
          missing_both: missingAvatar && missingCover
        });
        
        // Prevent modal from closing by any means
        $('#modal').off('hide.bs.modal.profileImages').on('hide.bs.modal.profileImages', function(e) {
          // Check if it's the profile images modal
          if ($(this).attr('data-profile-images-required') === 'true') {
            // Prevent modal from closing
            e.preventDefault();
            e.stopPropagation();
            return false;
          }
        });
        
        // Force backdrop to be static after modal is shown
        $('#modal').off('shown.bs.modal.profileImages').on('shown.bs.modal.profileImages', function() {
          if ($(this).data('bs.modal') && $(this).attr('data-profile-images-required') === 'true') {
            var modalInstance = $(this).data('bs.modal');
            modalInstance._config.backdrop = 'static';
            modalInstance._config.keyboard = false;
            
            // Prevent backdrop click only for this modal
            $('.modal-backdrop').off('click.profileImages').on('click.profileImages', function(e) {
              if ($('#modal').attr('data-profile-images-required') === 'true') {
                e.preventDefault();
                e.stopPropagation();
                return false;
              }
            });
          }
        });
        
        // Cleanup when other modals are shown
        $('#modal').on('show.bs.modal', function() {
          if ($(this).attr('data-profile-images-required') !== 'true') {
            // Remove the flag and event handlers when showing other modals
            $(this).removeAttr('data-profile-images-required');
            $(this).off('hide.bs.modal.profileImages');
            $(this).off('shown.bs.modal.profileImages');
            $('.modal-backdrop').off('click.profileImages');
          }
        });
      }
    });
  </script>
{/if}
<!-- Check Profile Images -->

<!-- Check Phone Requirement -->
{if $user->_logged_in && $require_phone_number}
    <script>
      $(document).ready(function() {
        // Đợi một chút để đảm bảo modal upload images đã đóng (nếu có)
        setTimeout(function() {
          // Mark that we're showing the phone requirement modal
          $('#modal').attr('data-phone-required', 'true');
          
          // Show modal immediately
          modal('#modal-require-phone');
          
          // Prevent modal from closing by any means
          $('#modal').off('hide.bs.modal.phoneRequired').on('hide.bs.modal.phoneRequired', function(e) {
            // Check if it's the phone required modal
            if ($(this).attr('data-phone-required') === 'true') {
              // Prevent modal from closing
              e.preventDefault();
              e.stopPropagation();
              return false;
            }
          });
          
          // Force backdrop to be static after modal is shown
          $('#modal').off('shown.bs.modal.phoneRequired').on('shown.bs.modal.phoneRequired', function() {
            if ($(this).data('bs.modal') && $(this).attr('data-phone-required') === 'true') {
              var modalInstance = $(this).data('bs.modal');
              modalInstance._config.backdrop = 'static';
              modalInstance._config.keyboard = false;
              
              // Prevent backdrop click
              $('.modal-backdrop').off('click.phoneRequired').on('click.phoneRequired', function(e) {
                if ($('#modal').attr('data-phone-required') === 'true') {
                  e.preventDefault();
                  e.stopPropagation();
                  return false;
                }
              });
            }
          });
          
          // Handle phone update form submission manually
          $(document).off('submit', '#phone-update-form').on('submit', '#phone-update-form', function(e) {
            e.preventDefault();
            
            var form = $(this);
            var phone = form.find('#phone-input').val();
            var submitBtn = form.find('#phone-submit-btn');
            var successMsg = form.find('#phone-success-msg');
            var errorMsg = form.find('#phone-error-msg');
            
            // Disable submit button
            submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr5"></i>{__("Đang xử lý...")}');
            
            // Hide previous messages
            successMsg.addClass('x-hidden');
            errorMsg.addClass('x-hidden');
            
            // Send AJAX request
            $.ajax({
              type: 'POST',
              url: '{$system['system_url']}/includes/ajax/users/update_phone.php',
              data: { phone: phone },
              dataType: 'json',
              success: function(response) {
                console.log('Response:', response);
                
                if (response.success) {
                  // Show success message
                  successMsg.removeClass('x-hidden').html('<i class="fa fa-check mr5"></i>' + response.message);
                  
                  // Remove the phone required flag
                  $('#modal').removeAttr('data-phone-required');
                  $('#modal').off('hide.bs.modal.phoneRequired');
                  $('#modal').off('shown.bs.modal.phoneRequired');
                  $('.modal-backdrop').off('click.phoneRequired');
                  
                  // Close modal and reload after 1.5s
                  setTimeout(function() {
                    $('#modal').modal('hide');
                    location.reload();
                  }, 1500);
                } else {
                  // Show error message
                  errorMsg.removeClass('x-hidden').html('<i class="fa fa-times mr5"></i>' + (response.message || 'Đã xảy ra lỗi!'));
                  submitBtn.prop('disabled', false).html('<i class="fa fa-check mr5"></i>{__("Xác nhận")}');
                }
              },
              error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr);
                errorMsg.removeClass('x-hidden').html('<i class="fa fa-times mr5"></i>Lỗi kết nối! Vui lòng thử lại.');
                submitBtn.prop('disabled', false).html('<i class="fa fa-check mr5"></i>{__("Xác nhận")}');
              }
            });
          });
        }, 500);
      });
    </script>
{/if}
<!-- Check Phone Requirement -->

</body>

</html>
