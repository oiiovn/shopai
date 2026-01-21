<?php
/* Smarty version 4.3.4, created on 2025-10-16 10:54:43
  from '/Applications/XAMPP/xamppfiles/htdocs/shopai1/Script/content/themes/default/templates/my-system.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68f0cef354e4b7_88501475',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '01884fe5351265fd15541212d8a59833b80ba533' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/shopai1/Script/content/themes/default/templates/my-system.tpl',
      1 => 1760611796,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_head.tpl' => 1,
    'file:_header.tpl' => 1,
    'file:my-system-transactions.tpl' => 1,
    'file:_ads_campaigns.tpl' => 1,
    'file:_footer.tpl' => 1,
  ),
),false)) {
function content_68f0cef354e4b7_88501475 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:_head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender('file:_header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<!-- page content -->
<div class="container-fluid mt30">
  <div class="row">

    <!-- left sidebar menu -->
    <div class="col-lg-3 col-md-4">
      <div class="card sticky-top" style="top: 80px; z-index: 999;">
        <div class="card-header bg-primary text-white">
          <strong><i class="fa fa-list mr10"></i><?php echo __("Menu Quản Lý");?>
</strong>
        </div>
        <div class="card-body with-nav p-0">
          <ul class="side-nav">
            <li <?php if ($_smarty_tpl->tpl_vars['view']->value == '') {?>class="active"<?php }?>>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/my-system">
                <i class="fa fa-dashboard fa-fw mr10"></i><?php echo __("Tổng Quan");?>

              </a>
            </li>
            <li <?php if ($_smarty_tpl->tpl_vars['view']->value == "transactions") {?>class="active"<?php }?>>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/my-system/transactions">
                <i class="fa fa-exchange-alt fa-fw mr10"></i><?php echo __("Quản Lý Giao Dịch");?>

              </a>
            </li>
            <li <?php if ($_smarty_tpl->tpl_vars['view']->value == "number-check") {?>class="active"<?php }?>>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/my-system/number-check">
                <i class="fa fa-mobile-alt fa-fw mr10"></i><?php echo __("Quản Lý Check Số");?>

              </a>
            </li>
            <li <?php if ($_smarty_tpl->tpl_vars['view']->value == "google-maps") {?>class="active"<?php }?>>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/my-system/google-maps">
                <i class="fa fa-map-marked-alt fa-fw mr10"></i><?php echo __("Google Maps Campaigns");?>

              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- left sidebar menu -->

    <!-- main content -->
    <div class="col-lg-9 col-md-8">
      
      <?php if ($_smarty_tpl->tpl_vars['view']->value == '') {?>
        <!-- dashboard -->
        
        <!-- Stats Cards -->
        <div class="row mb20">
          <div class="col-sm-6 col-md-3">
            <div class="card bg-gradient-primary text-white">
              <div class="card-body text-center" style="padding: 30px;">
                <i class="fa fa-users fa-3x mb20"></i>
                <h2 class="mb5">0</h2>
                <span><?php echo __("Tổng Người Dùng");?>
</span>
              </div>
            </div>
          </div>
          
          <div class="col-sm-6 col-md-3">
            <div class="card bg-gradient-info text-white">
              <div class="card-body text-center" style="padding: 30px;">
                <i class="fa fa-check-circle fa-3x mb20"></i>
                <h2 class="mb5">0</h2>
                <span><?php echo __("Hoạt Động");?>
</span>
              </div>
            </div>
          </div>

          <div class="col-sm-6 col-md-3">
            <div class="card bg-gradient-success text-white">
              <div class="card-body text-center" style="padding: 30px;">
                <i class="fa fa-dollar-sign fa-3x mb20"></i>
                <h2 class="mb5">0</h2>
                <span><?php echo __("Doanh Thu");?>
</span>
              </div>
            </div>
          </div>

          <div class="col-sm-6 col-md-3">
            <div class="card bg-gradient-warning text-white">
              <div class="card-body text-center" style="padding: 30px;">
                <i class="fa fa-chart-line fa-3x mb20"></i>
                <h2 class="mb5">0%</h2>
                <span><?php echo __("Tăng Trưởng");?>
</span>
              </div>
            </div>
          </div>
        </div>
        <!-- Stats Cards -->

        <!-- Welcome Message -->
        <div class="alert alert-info mb20">
          <div class="row align-items-center">
            <div class="col-auto">
              <i class="fa fa-info-circle fa-3x"></i>
            </div>
            <div class="col">
              <h5 class="mb5"><?php echo __("Chào mừng bạn đến với hệ thống quản lý!");?>
</h5>
              <p class="mb0"><?php echo __("Đây là trang tổng quan hệ thống của bạn. Bạn có thể quản lý và theo dõi mọi thứ từ đây.");?>
</p>
            </div>
          </div>
        </div>
        <!-- Welcome Message -->

        <!-- Main Content Card -->
        <div class="card">
          <div class="card-header">
            <strong><i class="fa fa-th-large mr10"></i><?php echo __("Nội Dung Hệ Thống");?>
</strong>
          </div>
          <div class="card-body">
            <h5 class="mb20"><?php echo __("Khu Vực Nội Dung Tùy Chỉnh");?>
</h5>
            <p><?php echo __("Bạn có thể thêm bất kỳ nội dung nào vào đây để quản lý hệ thống của mình.");?>
</p>
            <p><?php echo __("Trang này hiển thị full màn hình với header và footer đầy đủ, sẵn sàng để bạn tùy chỉnh theo nhu cầu.");?>
</p>
            
            <div class="divider"></div>
            
            <div class="row mt20">
              <div class="col-md-6">
                <div class="text-center p-3" style="background: #f8f9fa; border-radius: 8px;">
                  <i class="fa fa-cogs fa-3x text-muted mb10"></i>
                  <h6><?php echo __("Tích Hợp Dễ Dàng");?>
</h6>
                  <small class="text-muted"><?php echo __("Dễ dàng tích hợp với các module khác");?>
</small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="text-center p-3" style="background: #f8f9fa; border-radius: 8px;">
                  <i class="fa fa-mobile-alt fa-3x text-muted mb10"></i>
                  <h6><?php echo __("Responsive Design");?>
</h6>
                  <small class="text-muted"><?php echo __("Hoạt động tốt trên mọi thiết bị");?>
</small>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- dashboard -->
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['view']->value == "transactions") {?>
        <?php $_smarty_tpl->_subTemplateRender('file:my-system-transactions.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['view']->value == "number-check") {?>
        <!-- number check management -->
        <div class="card">
          <div class="card-header bg-gradient-info text-white">
            <div class="row align-items-center">
              <div class="col">
                <strong><i class="fa fa-mobile-alt mr10"></i><?php echo __("Quản Lý Check Số");?>
</strong>
              </div>
              <div class="col-auto">
                <span class="badge badge-warning badge-lg">
                  <i class="fa fa-tools mr5"></i><?php echo __("Đang Phát Triển");?>

                </span>
              </div>
            </div>
          </div>
          <div class="card-body text-center" style="padding: 60px 20px;">
            
            <!-- Under Development Icon -->
            <div class="mb30">
              <i class="fa fa-mobile-alt fa-5x text-muted mb20" style="opacity: 0.3;"></i>
              <i class="fa fa-search fa-3x text-info" style="position: relative; top: -40px; left: -10px;"></i>
            </div>
            
            <!-- Message -->
            <h3 class="mb20"><?php echo __("Tính Năng Check Số Đang Được Phát Triển");?>
</h3>
            <p class="text-xlg text-muted mb30">
              <?php echo __("Hệ thống kiểm tra và quản lý số điện thoại hiện đang được xây dựng và sẽ sớm ra mắt.");?>

            </p>
            
            <!-- Info Box -->
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <div class="alert alert-info text-left">
                  <h5 class="mb15">
                    <i class="fa fa-info-circle mr10"></i><?php echo __("Tính năng sẽ bao gồm:");?>

                  </h5>
                  <ul class="mb0" style="list-style: none; padding-left: 0;">
                    <li class="mb10">
                      <i class="fa fa-check-circle text-success mr10"></i>
                      <?php echo __("Kiểm tra số điện thoại có tồn tại");?>

                    </li>
                    <li class="mb10">
                      <i class="fa fa-check-circle text-success mr10"></i>
                      <?php echo __("Xác minh số điện thoại qua SMS");?>

                    </li>
                    <li class="mb10">
                      <i class="fa fa-check-circle text-success mr10"></i>
                      <?php echo __("Quản lý danh sách số đã check");?>

                    </li>
                    <li class="mb10">
                      <i class="fa fa-check-circle text-success mr10"></i>
                      <?php echo __("Lọc số theo nhà mạng (Viettel, Vinaphone, Mobifone)");?>

                    </li>
                    <li class="mb10">
                      <i class="fa fa-check-circle text-success mr10"></i>
                      <?php echo __("Thống kê tỷ lệ số hợp lệ");?>

                    </li>
                    <li class="mb10">
                      <i class="fa fa-check-circle text-success mr10"></i>
                      <?php echo __("Xuất báo cáo danh sách số");?>

                    </li>
                    <li class="mb10">
                      <i class="fa fa-check-circle text-success mr10"></i>
                      <?php echo __("Tích hợp API check số thứ 3");?>

                    </li>
                    <li class="mb10">
                      <i class="fa fa-check-circle text-success mr10"></i>
                      <?php echo __("Lưu trữ lịch sử check số");?>

                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- Features Preview -->
            <div class="divider mtb30"></div>
            <div class="row justify-content-center">
              <div class="col-lg-10">
                <h5 class="mb20"><?php echo __("Tính Năng Nổi Bật");?>
</h5>
                <div class="row">
                  <div class="col-md-4 mb20">
                    <div class="p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #17a2b8;">
                      <i class="fa fa-search text-info fa-2x mb10"></i>
                      <h6 class="mb5"><?php echo __("Check Số Nhanh");?>
</h6>
                      <small class="text-muted"><?php echo __("Kiểm tra hàng loạt số điện thoại");?>
</small>
                    </div>
                  </div>
                  <div class="col-md-4 mb20">
                    <div class="p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #28a745;">
                      <i class="fa fa-shield-alt text-success fa-2x mb10"></i>
                      <h6 class="mb5"><?php echo __("Bảo Mật Cao");?>
</h6>
                      <small class="text-muted"><?php echo __("Mã hóa và bảo vệ dữ liệu");?>
</small>
                    </div>
                  </div>
                  <div class="col-md-4 mb20">
                    <div class="p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #ffc107;">
                      <i class="fa fa-chart-line text-warning fa-2x mb10"></i>
                      <h6 class="mb5"><?php echo __("Thống Kê Chi Tiết");?>
</h6>
                      <small class="text-muted"><?php echo __("Báo cáo và phân tích dữ liệu");?>
</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Progress Timeline -->
            <div class="divider mtb30"></div>
            <div class="row justify-content-center">
              <div class="col-lg-10">
                <h5 class="mb20"><?php echo __("Tiến Độ Phát Triển");?>
</h5>
                <div class="row">
                  <div class="col-md-3 mb20">
                    <div class="p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #28a745;">
                      <i class="fa fa-check-circle text-success fa-2x mb10"></i>
                      <h6 class="mb5"><?php echo __("Giai Đoạn 1");?>
</h6>
                      <small class="text-muted"><?php echo __("Thiết kế UI/UX");?>
</small>
                      <div class="progress mt10" style="height: 5px;">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 mb20">
                    <div class="p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #ffc107;">
                      <i class="fa fa-spinner fa-spin text-warning fa-2x mb10"></i>
                      <h6 class="mb5"><?php echo __("Giai Đoạn 2");?>
</h6>
                      <small class="text-muted"><?php echo __("API Integration");?>
</small>
                      <div class="progress mt10" style="height: 5px;">
                        <div class="progress-bar bg-warning" style="width: 40%"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 mb20">
                    <div class="p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #6c757d;">
                      <i class="fa fa-clock text-muted fa-2x mb10"></i>
                      <h6 class="mb5"><?php echo __("Giai Đoạn 3");?>
</h6>
                      <small class="text-muted"><?php echo __("Database Design");?>
</small>
                      <div class="progress mt10" style="height: 5px;">
                        <div class="progress-bar bg-secondary" style="width: 20%"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 mb20">
                    <div class="p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #6c757d;">
                      <i class="fa fa-clock text-muted fa-2x mb10"></i>
                      <h6 class="mb5"><?php echo __("Giai Đoạn 4");?>
</h6>
                      <small class="text-muted"><?php echo __("Testing & Launch");?>
</small>
                      <div class="progress mt10" style="height: 5px;">
                        <div class="progress-bar bg-secondary" style="width: 0%"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt30">
              <button class="btn btn-light btn-lg" onclick="window.location.reload();">
                <i class="fa fa-sync mr10"></i><?php echo __("Làm Mới Trang");?>

              </button>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/my-system" class="btn btn-info btn-lg">
                <i class="fa fa-arrow-left mr10"></i><?php echo __("Quay Lại Tổng Quan");?>

              </a>
            </div>

            <!-- Sample Preview -->
            <div class="divider mtb30"></div>
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <h6 class="mb15"><?php echo __("Giao Diện Mẫu (Preview)");?>
</h6>
                <div class="card border" style="background: #f8f9fa;">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label"><?php echo __("Nhập số điện thoại:");?>
</label>
                          <input type="text" class="form-control" placeholder="0123456789" disabled>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label"><?php echo __("Kết quả:");?>
</label>
                          <div class="text-muted" style="padding: 8px 12px; background: white; border: 1px solid #ddd; border-radius: 4px;">
                            <i class="fa fa-clock text-warning mr5"></i><?php echo __("Đang chờ phát triển...");?>

                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="text-center mt10">
                      <button class="btn btn-info btn-sm" disabled>
                        <i class="fa fa-search mr5"></i><?php echo __("Check Số");?>

                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- number check management -->
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['view']->value == "google-maps") {?>
        <!-- google maps campaigns management -->
        <div class="card">
          <div class="card-header bg-gradient-success text-white">
            <div class="row align-items-center">
              <div class="col">
                <strong><i class="fa fa-map-marked-alt mr10"></i><?php echo __("Quản Lý Chiến Dịch Google Maps");?>
</strong>
              </div>
              <div class="col-auto">
                <span class="badge badge-warning badge-lg">
                  <i class="fa fa-tools mr5"></i><?php echo __("Đang Phát Triển");?>

                </span>
              </div>
            </div>
          </div>
          <div class="card-body text-center" style="padding: 60px 20px;">
            
            <!-- Under Development Icon -->
            <div class="mb30">
              <i class="fa fa-map-marked-alt fa-5x text-muted mb20" style="opacity: 0.3;"></i>
              <i class="fa fa-star fa-3x text-warning" style="position: relative; top: -40px; left: -10px;"></i>
            </div>
            
            <!-- Message -->
            <h3 class="mb20"><?php echo __("Hệ Thống Quản Lý Google Maps Đang Được Phát Triển");?>
</h3>
            <p class="text-xlg text-muted mb30">
              <?php echo __("Hệ thống quản lý chiến dịch Google Maps Reviews hiện đang được xây dựng và sẽ sớm ra mắt.");?>

            </p>
            
            <!-- Info Box -->
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <div class="alert alert-success text-left">
                  <h5 class="mb15">
                    <i class="fa fa-info-circle mr10"></i><?php echo __("Tính năng sẽ bao gồm:");?>

                  </h5>
                  <ul class="mb0" style="list-style: none; padding-left: 0;">
                    <li class="mb10">
                      <i class="fa fa-check-circle text-success mr10"></i>
                      <?php echo __("Tạo và quản lý chiến dịch Google Maps");?>

                    </li>
                    <li class="mb10">
                      <i class="fa fa-check-circle text-success mr10"></i>
                      <?php echo __("Thêm địa điểm và thông tin doanh nghiệp");?>

                    </li>
                    <li class="mb10">
                      <i class="fa fa-check-circle text-success mr10"></i>
                      <?php echo __("Phân công nhiệm vụ review cho user");?>

                    </li>
                    <li class="mb10">
                      <i class="fa fa-check-circle text-success mr10"></i>
                      <?php echo __("Theo dõi tiến độ và trạng thái reviews");?>

                    </li>
                    <li class="mb10">
                      <i class="fa fa-check-circle text-success mr10"></i>
                      <?php echo __("Quản lý thanh toán và hoa hồng");?>

                    </li>
                    <li class="mb10">
                      <i class="fa fa-check-circle text-success mr10"></i>
                      <?php echo __("Thống kê hiệu quả chiến dịch");?>

                    </li>
                    <li class="mb10">
                      <i class="fa fa-check-circle text-success mr10"></i>
                      <?php echo __("Xuất báo cáo chi tiết");?>

                    </li>
                    <li class="mb10">
                      <i class="fa fa-check-circle text-success mr10"></i>
                      <?php echo __("Tích hợp API Google Maps");?>

                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- Features Preview -->
            <div class="divider mtb30"></div>
            <div class="row justify-content-center">
              <div class="col-lg-10">
                <h5 class="mb20"><?php echo __("Tính Năng Nổi Bật");?>
</h5>
                <div class="row">
                  <div class="col-md-4 mb20">
                    <div class="p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #28a745;">
                      <i class="fa fa-map-marker-alt text-success fa-2x mb10"></i>
                      <h6 class="mb5"><?php echo __("Quản Lý Địa Điểm");?>
</h6>
                      <small class="text-muted"><?php echo __("Thêm, sửa, xóa địa điểm doanh nghiệp");?>
</small>
                    </div>
                  </div>
                  <div class="col-md-4 mb20">
                    <div class="p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #17a2b8;">
                      <i class="fa fa-users text-info fa-2x mb10"></i>
                      <h6 class="mb5"><?php echo __("Phân Công User");?>
</h6>
                      <small class="text-muted"><?php echo __("Giao nhiệm vụ review cho từng user");?>
</small>
                    </div>
                  </div>
                  <div class="col-md-4 mb20">
                    <div class="p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #ffc107;">
                      <i class="fa fa-chart-pie text-warning fa-2x mb10"></i>
                      <h6 class="mb5"><?php echo __("Thống Kê Chi Tiết");?>
</h6>
                      <small class="text-muted"><?php echo __("Báo cáo hiệu quả chiến dịch");?>
</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Progress Timeline -->
            <div class="divider mtb30"></div>
            <div class="row justify-content-center">
              <div class="col-lg-10">
                <h5 class="mb20"><?php echo __("Tiến Độ Phát Triển");?>
</h5>
                <div class="row">
                  <div class="col-md-3 mb20">
                    <div class="p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #28a745;">
                      <i class="fa fa-check-circle text-success fa-2x mb10"></i>
                      <h6 class="mb5"><?php echo __("Giai Đoạn 1");?>
</h6>
                      <small class="text-muted"><?php echo __("Thiết kế Database");?>
</small>
                      <div class="progress mt10" style="height: 5px;">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 mb20">
                    <div class="p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #ffc107;">
                      <i class="fa fa-spinner fa-spin text-warning fa-2x mb10"></i>
                      <h6 class="mb5"><?php echo __("Giai Đoạn 2");?>
</h6>
                      <small class="text-muted"><?php echo __("Backend API");?>
</small>
                      <div class="progress mt10" style="height: 5px;">
                        <div class="progress-bar bg-warning" style="width: 70%"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 mb20">
                    <div class="p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #6c757d;">
                      <i class="fa fa-clock text-muted fa-2x mb10"></i>
                      <h6 class="mb5"><?php echo __("Giai Đoạn 3");?>
</h6>
                      <small class="text-muted"><?php echo __("Frontend UI");?>
</small>
                      <div class="progress mt10" style="height: 5px;">
                        <div class="progress-bar bg-secondary" style="width: 30%"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 mb20">
                    <div class="p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #6c757d;">
                      <i class="fa fa-clock text-muted fa-2x mb10"></i>
                      <h6 class="mb5"><?php echo __("Giai Đoạn 4");?>
</h6>
                      <small class="text-muted"><?php echo __("Testing & Launch");?>
</small>
                      <div class="progress mt10" style="height: 5px;">
                        <div class="progress-bar bg-secondary" style="width: 0%"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt30">
              <button class="btn btn-light btn-lg" onclick="window.location.reload();">
                <i class="fa fa-sync mr10"></i><?php echo __("Làm Mới Trang");?>

              </button>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/my-system" class="btn btn-success btn-lg">
                <i class="fa fa-arrow-left mr10"></i><?php echo __("Quay Lại Tổng Quan");?>

              </a>
            </div>

            <!-- Sample Preview -->
            <div class="divider mtb30"></div>
            <div class="row justify-content-center">
              <div class="col-lg-10">
                <h6 class="mb15"><?php echo __("Giao Diện Mẫu (Preview)");?>
</h6>
                <div class="row">
                  <div class="col-md-6 mb20">
                    <div class="card border" style="background: #f8f9fa;">
                      <div class="card-body">
                        <h6 class="mb10"><?php echo __("Tạo Chiến Dịch Mới");?>
</h6>
                        <div class="form-group">
                          <input type="text" class="form-control" placeholder="<?php echo __('Tên chiến dịch');?>
" disabled>
                        </div>
                        <div class="form-group">
                          <input type="text" class="form-control" placeholder="<?php echo __('Địa chỉ Google Maps');?>
" disabled>
                        </div>
                        <button class="btn btn-success btn-sm" disabled>
                          <i class="fa fa-plus mr5"></i><?php echo __("Tạo Chiến Dịch");?>

                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 mb20">
                    <div class="card border" style="background: #f8f9fa;">
                      <div class="card-body">
                        <h6 class="mb10"><?php echo __("Danh Sách Chiến Dịch");?>
</h6>
                        <div class="text-center text-muted p-3">
                          <i class="fa fa-list fa-2x mb10"></i>
                          <div><?php echo __("Chưa có chiến dịch nào");?>
</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- google maps campaigns management -->
      <?php }?>

      <?php $_smarty_tpl->_subTemplateRender('file:_ads_campaigns.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
      
    </div>
    <!-- main content -->

  </div>
</div>
<!-- page content -->

<?php $_smarty_tpl->_subTemplateRender('file:_footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
