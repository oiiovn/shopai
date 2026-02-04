<?php
/* Smarty version 4.3.4, created on 2026-02-04 07:01:25
  from '/Applications/XAMPP/xamppfiles/htdocs/shop-ai.vn/public_html/content/themes/default/templates/giao-dich-trung-gian-detail.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_6982eec5a81c47_69778432',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cd2d3b8040307e2e25538356e3520c84dcccbc43' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/shop-ai.vn/public_html/content/themes/default/templates/giao-dich-trung-gian-detail.tpl',
      1 => 1770188484,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_head.tpl' => 1,
    'file:_header.tpl' => 1,
    'file:__svg_icons.tpl' => 2,
    'file:_footer.tpl' => 1,
  ),
),false)) {
function content_6982eec5a81c47_69778432 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/Applications/XAMPP/xamppfiles/htdocs/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),1=>array('file'=>'/Applications/XAMPP/xamppfiles/htdocs/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),));
$_smarty_tpl->_subTemplateRender('file:_head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender('file:_header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<style>
.escrow-detail { background: #f0f2f5; min-height: 100vh; padding-bottom: 2rem; }
.escrow-detail .fa, .escrow-detail .fas, .escrow-detail .far, .escrow-detail .fab { margin-right: 0.5rem; }
.escrow-detail .fa:last-child, .escrow-detail .fas:last-child, .escrow-detail .far:last-child, .escrow-detail .fab:last-child { margin-right: 0; }
#confirm-complete-modal .fa, #confirm-complete-modal .fas { margin-right: 0.5rem; }
#confirm-complete-modal .modal-header .btn-close-custom { padding: 0.25rem 0.5rem; font-size: 1.25rem; line-height: 1; color: #6c757d; background: transparent; border: 0; cursor: pointer; }
#confirm-complete-modal .modal-header .btn-close-custom:hover { color: #212529; }
/* Sticky card dưới header */
.escrow-detail .aside-card.sticky-top,
.escrow-detail .sticky-top { z-index: 998 !important; }
/* Modal đè lên tất cả kể cả header, căn giữa màn hình (chỉ khi .show) */
.modal-backdrop { position: fixed !important; z-index: 9998 !important; top: 0; left: 0; right: 0; bottom: 0; }
#confirm-complete-modal, #dispute-modal { position: fixed !important; z-index: 9999 !important; top: 0; left: 0; right: 0; bottom: 0; }
#confirm-complete-modal.show, #dispute-modal.show { display: flex !important; align-items: center !important; justify-content: center !important; padding: 1rem; }
#confirm-complete-modal .modal-dialog, #dispute-modal .modal-dialog { margin: 0 auto; }
.escrow-detail .blur-secret { filter: blur(6px); user-select: none; transition: all 0.3s; }
.escrow-detail .blur-secret.reveal { filter: none; user-select: auto; }
.escrow-detail .card { border: none; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,.08); overflow: hidden; }
.escrow-detail .card-header-mod { border-radius: 12px; }
/* Step progress: line through icon centers, cumulative colors, animate only segment leading to active */
.escrow-detail .steps-bar {
  --color-completed: #28a745;
  --color-active: #007bff;
  --color-pending: #e9ecef;
  --step-dot-size: 40px;
  --line-height: 3px;
  position: relative;
  padding: 1.25rem 0.5rem;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 1px 3px rgba(0,0,0,.08);
  margin-bottom: 1.25rem;
}
.escrow-detail .steps-bar__track {
  position: absolute;
  left: 12.5%;
  right: 12.5%;
  top: 1.25rem;
  height: var(--step-dot-size);
  pointer-events: none;
  z-index: 0;
}
.escrow-detail .steps-bar__track .step-line {
  position: absolute;
  top: 50%;
  margin-top: calc(var(--line-height) / -2);
  height: var(--line-height);
  border-radius: 2px;
  transition: background-color 0.25s ease;
}
.escrow-detail .steps-bar__track .step-line--bg {
  left: 0;
  right: 0;
  background: var(--color-pending);
}
.escrow-detail .steps-bar__track .step-line--seg {
  width: 33.333%;
}
.escrow-detail .steps-bar__track .step-line--seg.step-seg-1 { left: 0; }
.escrow-detail .steps-bar__track .step-line--seg.step-seg-2 { left: 33.333%; }
.escrow-detail .steps-bar__track .step-line--seg.step-seg-3 { left: 66.666%; }
.escrow-detail .steps-bar__track .step-line--seg[data-state="completed"] { background: var(--color-completed); }
.escrow-detail .steps-bar__track .step-line--seg[data-state="active"] {
  background: linear-gradient(90deg, var(--color-completed) 0%, var(--color-active) 50%, var(--color-pending) 100%);
  background-size: 200% 100%;
  animation: escrow-line-flow 1.2s linear infinite;
}
.escrow-detail .steps-bar__track .step-line--seg[data-state="pending"] { background: var(--color-pending); }
@keyframes escrow-line-flow {
  0% { background-position: 100% 0; }
  100% { background-position: -100% 0; }
}
.escrow-detail .steps-bar__steps {
  display: flex;
  justify-content: space-between;
  position: relative;
  z-index: 1;
}
.escrow-detail .steps-bar__steps .step {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  min-width: 0;
  padding: 0 0.25rem;
}
.escrow-detail .steps-bar .step-dot {
  width: var(--step-dot-size);
  height: var(--step-dot-size);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  flex-shrink: 0;
  transition: background-color 0.25s ease, color 0.25s ease, box-shadow 0.25s ease;
}
.escrow-detail .steps-bar .step-dot.step-done { background: var(--color-completed); color: #fff; box-shadow: 0 2px 8px rgba(40,167,69,.35); }
.escrow-detail .steps-bar .step-dot.step-current { background: var(--color-active); color: #fff; box-shadow: 0 2px 8px rgba(0,123,255,.35); }
.escrow-detail .steps-bar .step-dot.step-pending { background: var(--color-pending); color: #6c757d; }
.escrow-detail .steps-bar .step-label { font-size: 0.875rem; font-weight: 600; margin-top: 0.25rem; }
.escrow-detail .steps-bar .step-label.step-label--done { color: var(--color-completed); }
.escrow-detail .steps-bar .step-label.step-label--active { color: var(--color-active); }
.escrow-detail .steps-bar .step-label.step-label--pending { color: #6c757d; }
.escrow-detail .step-waiting { background: linear-gradient(135deg, #ffc107, #e0a800); color: #fff; animation: escrow-blink 1.2s ease-in-out infinite; box-shadow: 0 2px 8px rgba(255,193,7,.4); }
@keyframes escrow-blink { 0%, 100% { opacity: 1; transform: scale(1); box-shadow: 0 2px 8px rgba(255,193,7,.4); } 50% { opacity: .9; transform: scale(1.05); box-shadow: 0 4px 12px rgba(255,193,7,.5); } }
.escrow-detail .alert-info-mod { border-radius: 10px; border: none; background: linear-gradient(135deg, #e7f3ff, #cce5ff); color: #004085; }
.escrow-detail .msg-bubble-seller { border-top-left-radius: 0; border-radius: 0 12px 12px 12px; }
.escrow-detail .msg-bubble-buyer { border-top-right-radius: 0; border-radius: 12px 0 12px 12px; background: linear-gradient(135deg, #d4edda, #c3e6cb); border-color: #b1dfbb; }
.escrow-detail .secret-box { background: #2d3238; color: #e9ecef; border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.15); }
.escrow-detail .secret-box .secret-head { background: #1e2226; padding: 10px 14px; border-bottom: 1px solid #3d4349; font-size: 12px; }
.escrow-detail .secret-box .secret-body { padding: 14px; position: relative; min-height: 60px; }
.escrow-detail .secret-box .secret-foot { background: rgba(0,0,0,.25); padding: 10px 14px; font-size: 11px; color: #adb5bd; border-top: 1px solid #3d4349; }
.escrow-detail .aside-card { border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.08); overflow: hidden; }
.escrow-detail .aside-card .card-body { padding: 1.25rem 1.5rem; }
.escrow-detail .aside-card .card-body + .card-body { padding-top: 1rem; }
.escrow-detail .aside-card .bg-light { background: #f8f9fa !important; }
.escrow-detail .btn { border-radius: 10px; font-weight: 600; transition: transform .05s, box-shadow .2s; }
.escrow-detail .btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,.12); }
.escrow-detail .btn:disabled { transform: none; }
.escrow-detail .form-control { border-radius: 10px; border-color: #dee2e6; }
.escrow-detail .alert-warning { border-radius: 10px; border: none; }
.escrow-detail .badge-escrow-status { font-size: 0.9rem; font-weight: 700; padding: 0.5rem 1rem; border-radius: 10px; text-transform: uppercase; letter-spacing: 0.04em; box-shadow: 0 2px 6px rgba(0,0,0,.2); }
.escrow-detail .badge-escrow-pending { background: #5a6268; color: #fff; }
.escrow-detail .badge-escrow-locked { background: #e0a800; color: #212529; }
.escrow-detail .badge-escrow-delivering { background: #17a2b8; color: #fff; }
.escrow-detail .badge-escrow-completed { background: #28a745; color: #fff; }
.escrow-detail .badge-escrow-disputed { background: #dc3545; color: #fff; }
.escrow-detail .escrow-parties { display: flex; flex-wrap: wrap; align-items: center; gap: 1rem; }
.escrow-detail .escrow-party { display: flex; align-items: center; gap: 0.75rem; }
.escrow-detail .escrow-party__avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
.escrow-detail .escrow-party__body { display: flex; flex-direction: column; align-items: flex-start; justify-content: center; gap: 0.25rem; }
.escrow-detail .escrow-party__name { font-weight: 700; color: #212529; display: flex; align-items: center; flex-wrap: wrap; gap: 0.35rem; }
.escrow-detail .escrow-party__role { font-size: 0.7rem; font-weight: 600; padding: 0.2rem 0.5rem; border-radius: 6px; }
.escrow-detail .escrow-party__role--seller { background: #e7f3ff; color: #0066cc; border: 1px solid #b3d7ff; }
.escrow-detail .escrow-party__role--buyer { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
.escrow-detail .escrow-parties-sep { width: 1px; height: 2rem; background: #dee2e6; flex-shrink: 0; }
</style>

<div class="escrow-detail">
  <div class="<?php if ($_smarty_tpl->tpl_vars['system']->value['fluid_design']) {?>container-fluid<?php } else { ?>container<?php }?> mt-4 pb-4 px-3 px-lg-0">
    <div class="card shadow-sm border-0 card-header-mod mb-4">
      <div class="card-body py-4 px-4 px-lg-5 bg-white">
        <div class="row align-items-start">
          <div class="col-12 col-lg-8">
            <h2 class="h5 mb-2 font-weight-bold text-dark">
              <?php echo htmlspecialchars((string)$_smarty_tpl->tpl_vars['escrow']->value['display_code'], ENT_QUOTES, 'UTF-8', true);?>
 : <?php echo htmlspecialchars((string)$_smarty_tpl->tpl_vars['escrow']->value['title'], ENT_QUOTES, 'UTF-8', true);?>

            </h2>
            <?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'pending_deposit') {?>
              <span class="badge badge-escrow-status badge-escrow-pending"><i class="fa fa-clock mr1"></i> Chờ cọc tiền</span>
            <?php } elseif ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'locked') {?>
              <span class="badge badge-escrow-status badge-escrow-locked"><i class="fa fa-lock mr1"></i> Tiền đang bị khóa</span>
            <?php } elseif ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'delivering') {?>
              <span class="badge badge-escrow-status badge-escrow-delivering"><i class="fa fa-hourglass-half mr1"></i> Chờ hoàn tất</span>
            <?php } elseif ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'completed') {?>
              <span class="badge badge-escrow-status badge-escrow-completed"><i class="fa fa-check mr1"></i> Hoàn tất</span>
            <?php } elseif ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'disputed') {?>
              <span class="badge badge-escrow-status badge-escrow-disputed"><i class="fa fa-flag mr1"></i> Đang tranh chấp</span>
            <?php } else { ?>
              <span class="badge badge-escrow-status badge-secondary"><?php echo $_smarty_tpl->tpl_vars['escrow']->value['status'];?>
</span>
            <?php }?>
            <div class="escrow-parties mt-3">
              <div class="escrow-party">
                <img src="<?php echo htmlspecialchars((string)$_smarty_tpl->tpl_vars['escrow']->value['seller_avatar'], ENT_QUOTES, 'UTF-8', true);?>
" alt="" class="escrow-party__avatar">
                <div class="escrow-party__body">
                  <div class="escrow-party__name"><?php echo htmlspecialchars((string)$_smarty_tpl->tpl_vars['escrow']->value['seller_name'], ENT_QUOTES, 'UTF-8', true);
if ($_smarty_tpl->tpl_vars['escrow']->value['seller_verified']) {?><span class="verified-badge d-inline-flex align-items-center" data-bs-toggle="tooltip" title="<?php echo __('Verified User');?>
"><?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"verified_badge",'width'=>"15px",'height'=>"15px"), 0, false);
?></span><?php }?></div>
                  <span class="escrow-party__role escrow-party__role--seller">Người bán</span>
                </div>
              </div>
              <span class="escrow-parties-sep d-none d-sm-block" aria-hidden="true"></span>
              <div class="escrow-party">
                <img src="<?php echo htmlspecialchars((string)$_smarty_tpl->tpl_vars['escrow']->value['buyer_avatar'], ENT_QUOTES, 'UTF-8', true);?>
" alt="" class="escrow-party__avatar">
                <div class="escrow-party__body">
                  <div class="escrow-party__name"><?php echo htmlspecialchars((string)$_smarty_tpl->tpl_vars['escrow']->value['buyer_name'], ENT_QUOTES, 'UTF-8', true);
if ($_smarty_tpl->tpl_vars['escrow']->value['buyer_verified']) {?><span class="verified-badge d-inline-flex align-items-center" data-bs-toggle="tooltip" title="<?php echo __('Verified User');?>
"><?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"verified_badge",'width'=>"15px",'height'=>"15px"), 0, true);
?></span><?php }?></div>
                  <span class="escrow-party__role escrow-party__role--buyer">Người mua</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-4 text-lg-right mt-3 mt-lg-0">
            <p class="text-muted small mb-0">Thời gian tạo</p>
            <p class="font-weight-bold text-primary mb-0"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['escrow']->value['created_at'],"%d/%m/%Y %H:%M");?>
</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row no-gutters mt-0">
      <main class="col-12 col-lg-8 order-2 order-lg-1 pr-lg-4">
        <div class="steps-bar px-3 px-sm-4">
          <div class="steps-bar__track" aria-hidden="true">
            <div class="step-line step-line--bg"></div>
            <div class="step-line step-line--seg step-seg-1" data-state="<?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'pending_deposit') {?>active<?php } else { ?>completed<?php }?>"></div>
            <div class="step-line step-line--seg step-seg-2" data-state="<?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'locked') {?>active<?php } elseif ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'delivering' || $_smarty_tpl->tpl_vars['escrow']->value['status'] == 'completed') {?>completed<?php } else { ?>pending<?php }?>"></div>
            <div class="step-line step-line--seg step-seg-3" data-state="<?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'delivering') {?>active<?php } elseif ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'completed') {?>completed<?php } else { ?>pending<?php }?>"></div>
          </div>
          <div class="steps-bar__steps">
            <div class="step">
              <div class="step-dot step-done"><i class="fas fa-check"></i></div>
              <span class="step-label step-label--done">Tạo HĐ</span>
            </div>
            <div class="step">
              <div class="step-dot <?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'pending_deposit') {?>step-waiting<?php } else { ?>step-done<?php }?>"><i class="fas <?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] != 'pending_deposit') {?>fa-check<?php } else { ?>fa-clock<?php }?>"></i></div>
              <span class="step-label <?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'pending_deposit') {?>step-label--active<?php } else { ?>step-label--done<?php }?>"><?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'pending_deposit') {?>Đợi cọc tiền<?php } else { ?>Đã cọc tiền<?php }?></span>
            </div>
            <div class="step">
              <div class="step-dot <?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'delivering' || $_smarty_tpl->tpl_vars['escrow']->value['status'] == 'completed') {?>step-done<?php } elseif ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'locked') {?>step-current<?php } else { ?>step-pending<?php }?>"><i class="fas <?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'delivering' || $_smarty_tpl->tpl_vars['escrow']->value['status'] == 'completed') {?>fa-check<?php } elseif ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'locked') {?>fa-sync fa-spin<?php } else { ?>fa-circle<?php }?>"></i></div>
              <span class="step-label <?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'delivering' || $_smarty_tpl->tpl_vars['escrow']->value['status'] == 'completed') {?>step-label--done<?php } elseif ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'locked') {?>step-label--active<?php } else { ?>step-label--pending<?php }?>"><?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'delivering' || $_smarty_tpl->tpl_vars['escrow']->value['status'] == 'completed') {?>Đã giao<?php } else { ?>Đang giao<?php }?></span>
            </div>
            <div class="step">
              <div class="step-dot <?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'delivering') {?>step-current<?php } elseif ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'completed') {?>step-done<?php } else { ?>step-pending<?php }?>"><span><?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'delivering') {?><i class="fas fa-hourglass-half"></i><?php } elseif ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'completed') {?><i class="fas fa-check"></i><?php } else { ?>4<?php }?></span></div>
              <span class="step-label <?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'delivering') {?>step-label--active<?php } elseif ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'completed') {?>step-label--done<?php } else { ?>step-label--pending<?php }?>"><?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'delivering') {?>Chờ hoàn tất<?php } else { ?>Hoàn tất<?php }?></span>
            </div>
          </div>
        </div>

        <?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'locked' || $_smarty_tpl->tpl_vars['escrow']->value['status'] == 'delivering') {?>
        <div class="mb-4">
          <div class="alert alert-info alert-info-mod py-3 px-4 mb-0">
            <i class="fa fa-shield-alt mr2"></i> Hệ thống đã nhận <b><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['escrow']->value['amount'],0,',','.');?>
 đ</b> từ Người mua. Số tiền đã được <strong>KHÓA</strong> an toàn. Người bán vui lòng giao hàng.
          </div>
        </div>
        <?php }?>

        <div class="mb-2 mt-4">
          <h6 class="text-muted font-weight-bold small text-uppercase">Tin nhắn & thông tin bảo mật</h6>
        </div>

        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['escrow_messages']->value, 'msg');
$_smarty_tpl->tpl_vars['msg']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['msg']->value) {
$_smarty_tpl->tpl_vars['msg']->do_else = false;
?>
        <div class="d-flex gap-2 mb-3 <?php if ($_smarty_tpl->tpl_vars['msg']->value['user_id'] == $_smarty_tpl->tpl_vars['escrow']->value['buyer_id']) {?>flex-row-reverse<?php }?>">
          <div class="flex-shrink-0 rounded-circle bg-light border d-flex align-items-center justify-content-center font-weight-bold text-primary" style="width:40px;height:40px;">
            <?php if ($_smarty_tpl->tpl_vars['msg']->value['user_id'] == $_smarty_tpl->tpl_vars['escrow']->value['seller_id']) {?>S<?php } else { ?>B<?php }?>
          </div>
          <div class="<?php if ($_smarty_tpl->tpl_vars['msg']->value['user_id'] == $_smarty_tpl->tpl_vars['escrow']->value['buyer_id']) {?>text-right<?php }?>" style="max-width:85%;">
            <?php if ($_smarty_tpl->tpl_vars['msg']->value['is_secret']) {?>
              <div class="secret-box rounded overflow-hidden">
                <div class="secret-head d-flex justify-content-between align-items-center">
                  <span class="text-success"><i class="fa fa-key mr1"></i> THÔNG TIN BẢO MẬT</span>
                  <span class="text-muted small">Chỉ người mua thấy</span>
                </div>
                <div class="secret-body">
                  <?php if ($_smarty_tpl->tpl_vars['escrow']->value['is_buyer']) {?>
                    <?php if ($_smarty_tpl->tpl_vars['escrow_secret_viewed']->value) {?>
                      <div id="secret-content-<?php echo $_smarty_tpl->tpl_vars['msg']->value['id'];?>
" class="font-monospace small"><?php echo htmlspecialchars((string)nl2br((string) $_smarty_tpl->tpl_vars['msg']->value['secret_content'], (bool) 1), ENT_QUOTES, 'UTF-8', true);?>
</div>
                    <?php } else { ?>
                      <div id="secret-overlay-<?php echo $_smarty_tpl->tpl_vars['msg']->value['id'];?>
" class="position-absolute inset-0 d-flex align-items-center justify-content-center bg-dark" style="z-index:10;cursor:pointer;">
                        <button type="button" class="btn btn-primary btn-sm js-reveal-secret" data-msg-id="<?php echo $_smarty_tpl->tpl_vars['msg']->value['id'];?>
">
                          <i class="fa fa-eye mr1"></i> Bấm để xem thông tin
                        </button>
                      </div>
                      <div id="secret-content-<?php echo $_smarty_tpl->tpl_vars['msg']->value['id'];?>
" class="font-monospace small" style="min-height:40px;"></div>
                    <?php }?>
                  <?php } else { ?>
                    <span class="text-muted small">Nội dung bảo mật (chỉ người mua xem được)</span>
                  <?php }?>
                </div>
                <div class="secret-foot">
                  <i class="fa fa-info-circle mr1"></i> Hệ thống đã lưu log thời điểm bạn xem thông tin này.
                </div>
              </div>
            <?php } else { ?>
              <div class="border rounded p-3 shadow-sm <?php if ($_smarty_tpl->tpl_vars['msg']->value['user_id'] == $_smarty_tpl->tpl_vars['escrow']->value['buyer_id']) {?>msg-bubble-buyer<?php } else { ?>msg-bubble-seller<?php }?>">
                <span class="small"><?php echo htmlspecialchars((string)nl2br((string) $_smarty_tpl->tpl_vars['msg']->value['message'], (bool) 1), ENT_QUOTES, 'UTF-8', true);?>
</span>
              </div>
            <?php }?>
          </div>
        </div>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

        <?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] != 'completed' && $_smarty_tpl->tpl_vars['escrow']->value['status'] != 'cancelled' && $_smarty_tpl->tpl_vars['escrow']->value['status'] != 'disputed') {?>
        <div class="card mt-4">
          <div class="card-body p-4">
            <h6 class="card-title font-weight-bold mb-3">Gửi tin nhắn</h6>
            <div class="form-group mb-3">
              <textarea class="form-control js-msg-text" rows="3" placeholder="Nhập tin nhắn..."></textarea>
            </div>
            <div class="form-group mb-3 form-check">
              <input type="checkbox" class="form-check-input js-msg-secret" id="chkSecret">
              <label class="form-check-label" for="chkSecret">Tin nhắn bảo mật (chỉ người mua xem được, VD: tài khoản/mật khẩu)</label>
            </div>
            <div class="js-secret-content-wrap d-none mb-3">
              <textarea class="form-control js-secret-content" rows="4" placeholder="Nội dung bảo mật (URL, email, pass...)"></textarea>
            </div>
            <button type="button" class="btn btn-primary px-4 js-send-msg"><i class="fa fa-paper-plane mr1"></i> Gửi</button>
          </div>
        </div>
        <?php }?>
      </main>

      <aside class="col-12 col-lg-4 order-1 order-lg-2">
        <div class="card aside-card bg-white sticky-top">
          <div class="card-body border-bottom">
            <h6 class="text-uppercase text-muted small font-weight-bold mb-3">Chi tiết thanh toán</h6>
            <?php if ((isset($_smarty_tpl->tpl_vars['escrow']->value['total_buyer_pays']))) {?>
            <div class="d-flex justify-content-between small mb-2">
              <span class="text-muted">Tổng bên mua trả:</span>
              <span class="font-weight-bold"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['escrow']->value['total_buyer_pays'],0,',','.');?>
 đ</span>
            </div>
            <?php }?>
            <div class="d-flex justify-content-between small mb-2">
              <span class="text-muted">Giá trị đơn hàng:</span>
              <span class="font-weight-medium"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['escrow']->value['amount'],0,',','.');?>
 đ</span>
            </div>
            <div class="d-flex justify-content-between small mb-2">
              <span class="text-muted">Phí trung gian (5%):</span>
              <span class="font-weight-medium text-danger">- <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['escrow']->value['fee_amount'],0,',','.');?>
 đ</span>
            </div>
            <div class="d-flex justify-content-between pt-3 mt-2 border-top mb-0">
              <span class="font-weight-bold">Thực nhận (người bán):</span>
              <span class="font-weight-bold text-success"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['escrow']->value['seller_receives'],0,',','.');?>
 đ</span>
            </div>
          </div>
          <div class="card-body">
            <h6 class="text-uppercase text-muted small font-weight-bold mb-3">Điều kiện hoàn tất</h6>
            <ul class="list-unstyled mb-0">
              <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['escrow_conditions']->value, 'c');
$_smarty_tpl->tpl_vars['c']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['c']->value) {
$_smarty_tpl->tpl_vars['c']->do_else = false;
?>
              <li class="d-flex align-items-start mb-2 small form-check">
                <input type="checkbox" class="form-check-input mt-1 me-2 js-condition-check" data-id="<?php echo $_smarty_tpl->tpl_vars['c']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['c']->value['is_checked']) {?>checked<?php }?> <?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'completed' || !$_smarty_tpl->tpl_vars['escrow']->value['is_buyer'] || $_smarty_tpl->tpl_vars['c']->value['is_checked']) {?>disabled<?php }?>>
                <span class="form-check-label ms-1"><?php echo htmlspecialchars((string)$_smarty_tpl->tpl_vars['c']->value['label'], ENT_QUOTES, 'UTF-8', true);?>
</span>
              </li>
              <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </ul>
            <?php if ($_smarty_tpl->tpl_vars['escrow']->value['is_buyer'] && $_smarty_tpl->tpl_vars['escrow']->value['status'] != 'completed') {?>
            <div class="alert alert-warning small mt-3 py-3 px-3 mb-0 rounded">
              <i class="fa fa-exclamation-triangle mr1"></i> Chỉ bấm "Hoàn tất" khi đã kiểm tra đủ các mục trên. Sau khi bấm, tiền sẽ chuyển ngay cho người bán.
            </div>
            <?php }?>
          </div>
          <?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] != 'completed' && $_smarty_tpl->tpl_vars['escrow']->value['status'] != 'cancelled' && $_smarty_tpl->tpl_vars['escrow']->value['status'] != 'disputed') {?>
          <div class="card-body bg-light border-top py-4">
            <?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'pending_deposit' && $_smarty_tpl->tpl_vars['escrow']->value['is_buyer']) {?>
              <?php $_smarty_tpl->_assignInScope('buyer_bal', (($tmp = $_smarty_tpl->tpl_vars['user']->value->_data['user_wallet_balance'] ?? null)===null||$tmp==='' ? 0 ?? null : $tmp));?>
              <div class="mb-3">
                <p class="small text-muted mb-1">Yêu cầu thanh toán</p>
                <p class="mb-2">Số dư của bạn: <strong><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['buyer_bal']->value,0,',','.');?>
 đ</strong></p>
                <p class="mb-2">Cần thanh toán: <strong class="text-primary"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['escrow']->value['total_buyer_pays'],0,',','.');?>
 đ</strong></p>
                <?php if ($_smarty_tpl->tpl_vars['buyer_bal']->value >= $_smarty_tpl->tpl_vars['escrow']->value['total_buyer_pays']) {?>
                  <button type="button" class="btn btn-success btn-block font-weight-bold py-3 js-pay-from-balance"><i class="fa fa-lock mr1"></i> Đặt cọc</button>
                <?php } else { ?>
                  <div class="alert alert-warning small py-2 mb-3 rounded">
                    <i class="fa fa-exclamation-triangle mr1"></i> Số dư không đủ. Vui lòng nạp thêm tiền để thanh toán giao dịch này.
                  </div>
                  <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/finance/recharge" class="btn btn-primary btn-block font-weight-bold py-3"><i class="fa fa-plus-circle mr1"></i> Nạp tiền</a>
                <?php }?>
              </div>
              <p class="small text-muted mb-2">Hoặc đã chuyển tiền bên ngoài:</p>
              <button type="button" class="btn btn-outline-secondary btn-block btn-sm js-set-deposit"><i class="fa fa-check-circle mr1"></i> Xác nhận đã nạp tiền</button>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'locked' && $_smarty_tpl->tpl_vars['escrow']->value['is_seller']) {?>
              <button type="button" class="btn btn-info btn-block font-weight-bold py-3 js-set-delivering"><i class="fa fa-truck mr1"></i> Đang giao hàng</button>
            <?php }?>
            <?php if (($_smarty_tpl->tpl_vars['escrow']->value['status'] == 'delivering' || $_smarty_tpl->tpl_vars['escrow']->value['status'] == 'locked') && $_smarty_tpl->tpl_vars['escrow']->value['is_buyer']) {?>
              <button type="button" class="btn btn-success btn-block font-weight-bold py-3 js-confirm-complete" id="btn-confirm-complete" disabled><i class="fa fa-check-circle mr1"></i> Xác nhận giao dịch an toàn</button>
            <?php }?>
            <button type="button" class="btn btn-outline-danger btn-block mt-3 py-2 js-open-dispute"><i class="fa fa-flag mr1"></i> Báo cáo admin</button>
          </div>
          <?php }?>
        </div>
      </aside>
    </div>
  </div>
</div>

<div id="confirm-complete-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmCompleteTitle" aria-hidden="true" data-backdrop="true" data-keyboard="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow-lg overflow-hidden">
      <div class="modal-header border-0 pb-0 pt-4 px-4 d-flex align-items-center w-100">
        <div class="flex-grow-1">
          <h5 class="modal-title font-weight-bold text-dark mb-0" id="confirmCompleteTitle">Xác nhận hoàn tất giao dịch</h5>
          <p class="text-muted small mb-0 mt-1">Hành động không thể hoàn tác</p>
        </div>
        <button type="button" class="btn-close-custom ml-auto js-close-confirm-complete" data-dismiss="modal" aria-label="Đóng" title="Đóng"><i class="fas fa-times"></i></button>
      </div>
      <div class="modal-body px-4 pt-3 pb-2">
        <p class="text-dark mb-0">Bạn chắc chắn giao dịch đã an toàn đối với bạn chứ?</p>
        <div class="alert alert-warning border-0 mt-3 mb-0 py-2 px-3 small d-flex align-items-start">
          <i class="fas fa-info-circle mt-1 mr-2"></i>
          <span><strong>Lưu ý:</strong> Sau khi xác nhận, tiền sẽ được chuyển ngay cho người bán và <strong>không thể đảo ngược</strong>. Nếu có vấn đề, hãy dùng "Báo cáo admin" trước khi bấm hoàn tất.</span>
        </div>
      </div>
      <div class="modal-footer border-0 bg-light px-4 py-3">
        <button type="button" class="btn btn-secondary px-3" data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-success px-4 js-confirm-complete-submit">
          <span class="js-confirm-complete-text"><i class="fas fa-check-circle"></i> Xác nhận giao dịch an toàn</span>
          <span class="js-confirm-complete-loading d-none"><i class="fas fa-spinner fa-spin"></i> Đang xử lý...</span>
        </button>
      </div>
    </div>
  </div>
</div>

<div id="dispute-modal" class="modal fade" tabindex="-1" data-backdrop="true" data-keyboard="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-bottom d-flex align-items-center">
        <h5 class="modal-title text-danger mb-0">Báo cáo Admin</h5>
        <button type="button" class="close ml-auto p-2 border-0 bg-transparent" style="font-size:1.5rem;line-height:1;color:#6c757d;cursor:pointer;" data-dismiss="modal" aria-label="Đóng" title="Đóng">&times;</button>
      </div>
      <div class="modal-body">
        <p class="small font-weight-bold text-primary mb-2"><i class="fa fa-phone mr1"></i> Liên hệ Admin qua Zalo: <a href="tel:0934584939">0934584939</a></p>
        <p class="small text-muted">Hệ thống sẽ đóng băng tiền và mời Admin tham gia. Vui lòng cung cấp bằng chứng.</p>
        <div class="form-group">
          <label class="small font-weight-bold">Lý do chính</label>
          <select class="form-control form-control-sm js-dispute-reason">
            <option>Không đăng nhập được (Sai pass)</option>
            <option>Tài khoản không đúng mô tả</option>
            <option>Người bán không phản hồi</option>
          </select>
        </div>
        <div class="form-group">
          <label class="small font-weight-bold">Mô tả & Link video bằng chứng</label>
          <textarea class="form-control form-control-sm js-dispute-desc" rows="3" placeholder="Tôi đã thử login lúc 10:45 nhưng báo sai pass. Video quay lại tại link..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Hủy bỏ</button>
        <button type="button" class="btn btn-danger btn-sm js-submit-dispute">Gửi báo cáo</button>
      </div>
    </div>
  </div>
</div>

<?php echo '<script'; ?>
>
(function() {
  var txId = <?php echo $_smarty_tpl->tpl_vars['escrow']->value['id'];?>
;
  var baseUrl = '<?php echo $_smarty_tpl->tpl_vars['system']->value["system_url"];?>
';
  var ajaxUrl = (baseUrl && baseUrl.indexOf('http') === 0) ? (baseUrl + '/includes/ajax/escrow-transaction.php') : ((typeof location !== 'undefined' && location.pathname) ? (location.origin + location.pathname.replace(/\/giao-dich-trung-gian\/detail\/\d+.*$/i, '').replace(/\/$/, '') + '/includes/ajax/escrow-transaction.php') : '../../includes/ajax/escrow-transaction.php');

  function post(data, cb) {
    var fd = new FormData();
    fd.append('transaction_id', txId);
    for (var k in data) fd.append(k, data[k]);
    var controller = new AbortController();
    var timeoutId = setTimeout(function() { controller.abort(); }, 20000);
    fetch(ajaxUrl, { method: 'POST', body: fd, credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' }, signal: controller.signal })
      .then(function(r) {
        clearTimeout(timeoutId);
        return r.text().then(function(t) {
          if (!r.ok) return { error: true, message: 'Máy chủ trả lỗi ' + r.status + (t && t.length < 200 ? ': ' + t : '') };
          try { return JSON.parse(t); } catch (e) { return { error: true, message: 'Phản hồi không hợp lệ. ' + (t ? t.substring(0, 100) : '') }; }
        });
      })
      .then(cb)
      .catch(function(err) {
        clearTimeout(timeoutId);
        if (err && err.name === 'AbortError') cb({ error: true, message: 'Hết thời gian chờ. Thử lại.' });
        else cb({ error: true, message: 'Lỗi kết nối. Thử lại hoặc kiểm tra đường dẫn: ' + ajaxUrl });
      });
  }

  document.querySelectorAll('.js-reveal-secret').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var msgId = this.getAttribute('data-msg-id');
      post({ action: 'reveal_secret', message_id: msgId }, function(res) {
        if (res.success) {
          var content = document.getElementById('secret-content-' + msgId);
          var overlay = document.getElementById('secret-overlay-' + msgId);
          if (content && res.secret_content !== undefined) {
            var s = String(res.secret_content).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
            content.innerHTML = s.replace(/\n/g, '<br>');
          }
          if (overlay) overlay.classList.add('d-none');
        }
      });
    });
  });

  var sendMsg = document.querySelector('.js-send-msg');
  if (sendMsg) {
    var secretCheck = document.querySelector('.js-msg-secret');
    var secretWrap = document.querySelector('.js-secret-content-wrap');
    if (secretCheck) secretCheck.addEventListener('change', function() { secretWrap.classList.toggle('d-none', !this.checked); });
    sendMsg.addEventListener('click', function() {
      var text = document.querySelector('.js-msg-text').value.trim();
      var isSecret = document.querySelector('.js-msg-secret').checked;
      var secretContent = document.querySelector('.js-secret-content').value.trim();
      if (!text && !isSecret) { alert('Nhập nội dung hoặc gửi tin bảo mật.'); return; }
      if (isSecret && !secretContent) { alert('Nhập nội dung bảo mật.'); return; }
      post({ action: 'send_message', message: text, is_secret: isSecret ? 1 : 0, secret_content: secretContent }, function(res) {
        if (res.success) window.location.reload();
        else alert(res.message || 'Lỗi');
      });
    });
  }

  function allConditionsChecked() {
    var chks = document.querySelectorAll('.js-condition-check');
    if (!chks.length) return true;
    for (var i = 0; i < chks.length; i++) { if (!chks[i].checked) return false; }
    return true;
  }
  function updateConfirmCompleteButton() {
    var btn = document.getElementById('btn-confirm-complete');
    if (!btn) return;
    btn.disabled = !allConditionsChecked();
  }
  document.querySelectorAll('.js-condition-check').forEach(function(el) {
    if (el.disabled) return;
    el.addEventListener('change', function() {
      var self = this;
      if (self.checked) {
        post({ action: 'toggle_condition', condition_id: self.getAttribute('data-id') }, function(res) {
          if (res.success) { self.disabled = true; updateConfirmCompleteButton(); }
          else self.checked = false;
        });
      }
    });
  });
  updateConfirmCompleteButton();

  var payFromBalance = document.querySelector('.js-pay-from-balance');
  if (payFromBalance) {
    payFromBalance.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      var btn = payFromBalance;
      var oldText = btn.innerHTML;
      btn.disabled = true;
      btn.innerHTML = '<i class="fa fa-spinner fa-spin mr1"></i> Đang xử lý...';
      post({ action: 'pay_from_balance' }, function(res) {
        btn.disabled = false;
        btn.innerHTML = oldText;
        if (!res) { alert('Không có phản hồi.'); return; }
        if (res.error && res.message) {
          var msg = res.message;
          if (msg.indexOf('<a href') !== -1) document.body.insertAdjacentHTML('beforeend', '<div class="alert alert-danger m-3">' + msg + '</div>');
          else alert(msg);
          return;
        }
        alert(res.message || 'Đặt cọc thành công.');
        if (res.success) location.reload();
      });
    });
  }

  var setDeposit = document.querySelector('.js-set-deposit');
  if (setDeposit) setDeposit.addEventListener('click', function() {
    if (!confirm('Bạn xác nhận đã chuyển đủ tiền vào escrow (bên ngoài hệ thống)?')) return;
    post({ action: 'set_deposit_done' }, function(res) { alert(res.message || ''); if (res.success) location.reload(); });
  });

  var setDelivering = document.querySelector('.js-set-delivering');
  if (setDelivering) setDelivering.addEventListener('click', function() {
    post({ action: 'set_delivering' }, function(res) { alert(res.message || ''); if (res.success) location.reload(); });
  });

  function showModal(el) {
    if (el.parentNode !== document.body) document.body.appendChild(el);
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
      var m = bootstrap.Modal.getOrCreateInstance(el);
      m.show();
    } else {
      el.classList.add('show');
      el.style.display = 'block';
      document.body.classList.add('modal-open');
      var bg = document.createElement('div');
      bg.className = 'modal-backdrop fade show';
      bg.setAttribute('data-modal-backdrop', '1');
      document.body.appendChild(bg);
    }
  }
  function hideModal(el) {
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
      var m = bootstrap.Modal.getInstance(el);
      if (m) m.hide();
    } else {
      el.classList.remove('show');
      el.style.display = 'none';
      document.body.classList.remove('modal-open');
      var bg = document.querySelector('[data-modal-backdrop="1"]');
      if (bg) bg.remove();
    }
  }

  var confirmComplete = document.querySelector('.js-confirm-complete');
  var confirmCompleteModal = document.getElementById('confirm-complete-modal');
  var confirmCompleteSubmit = document.querySelector('.js-confirm-complete-submit');
  var confirmCompleteText = document.querySelector('.js-confirm-complete-text');
  var confirmCompleteLoading = document.querySelector('.js-confirm-complete-loading');
  if (confirmComplete && confirmCompleteModal) {
    confirmComplete.addEventListener('click', function() { showModal(confirmCompleteModal); });
    document.querySelectorAll('#confirm-complete-modal .js-close-confirm-complete, #confirm-complete-modal [data-dismiss="modal"]').forEach(function(btn) {
      if (btn) btn.addEventListener('click', function() {
        hideModal(confirmCompleteModal);
        if (confirmCompleteSubmit) confirmCompleteSubmit.disabled = false;
        if (confirmCompleteLoading) confirmCompleteLoading.classList.add('d-none');
        if (confirmCompleteText) confirmCompleteText.classList.remove('d-none');
      });
    });
    confirmCompleteModal.addEventListener('hidden.bs.modal', function() {
      if (confirmCompleteSubmit) confirmCompleteSubmit.disabled = false;
      if (document.querySelector('.js-confirm-complete-loading')) document.querySelector('.js-confirm-complete-loading').classList.add('d-none');
      if (document.querySelector('.js-confirm-complete-text')) document.querySelector('.js-confirm-complete-text').classList.remove('d-none');
    });
    if (confirmCompleteSubmit) {
      confirmCompleteSubmit.addEventListener('click', function() {
        if (confirmCompleteText) confirmCompleteText.classList.add('d-none');
        if (confirmCompleteLoading) confirmCompleteLoading.classList.remove('d-none');
        confirmCompleteSubmit.disabled = true;
        post({ action: 'confirm_complete' }, function(res) {
          if (confirmCompleteText) confirmCompleteText.classList.remove('d-none');
          if (confirmCompleteLoading) confirmCompleteLoading.classList.add('d-none');
          confirmCompleteSubmit.disabled = false;
          alert(res.message || '');
          if (res.success) { hideModal(confirmCompleteModal); location.reload(); }
        });
      });
    }
  }

  var openDispute = document.querySelector('.js-open-dispute');
  var disputeModal = document.getElementById('dispute-modal');
  if (openDispute && disputeModal) openDispute.addEventListener('click', function() { showModal(disputeModal); });

  var submitDispute = document.querySelector('.js-submit-dispute');
  if (submitDispute) submitDispute.addEventListener('click', function() {
    var reason = document.querySelector('.js-dispute-reason').value;
    var desc = document.querySelector('.js-dispute-desc').value;
    post({ action: 'open_dispute', reason: reason, description: desc }, function(res) {
      alert(res.message || '');
      if (res.success) { hideModal(disputeModal); location.reload(); }
    });
  });
})();
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:_footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
