<?php
/* Smarty version 4.3.4, created on 2026-02-04 05:51:22
  from '/Applications/XAMPP/xamppfiles/htdocs/shop-ai.vn/public_html/content/themes/default/templates/giao-dich-trung-gian-list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_6982de5a29bc33_10533635',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4c35294181be8a886c781824630eb9408e0371dd' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/shop-ai.vn/public_html/content/themes/default/templates/giao-dich-trung-gian-list.tpl',
      1 => 1770184279,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_head.tpl' => 1,
    'file:_header.tpl' => 1,
    'file:_sidebar.tpl' => 1,
    'file:_footer.tpl' => 1,
  ),
),false)) {
function content_6982de5a29bc33_10533635 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/Applications/XAMPP/xamppfiles/htdocs/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.count.php','function'=>'smarty_modifier_count',),1=>array('file'=>'/Applications/XAMPP/xamppfiles/htdocs/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),2=>array('file'=>'/Applications/XAMPP/xamppfiles/htdocs/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
$_smarty_tpl->_subTemplateRender('file:_head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender('file:_header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<style>
.escrow-list-page { background: #f0f2f5; min-height: 100vh; padding-bottom: 2rem; }
.gdtg-tabs-bar { background: #f1f5f9; border-radius: 12px; padding: 6px; box-shadow: 0 1px 3px rgba(0,0,0,.06); }
.gdtg-tabs { display: flex; flex-wrap: wrap; gap: 4px; border: none; }
.gdtg-tabs .nav-link { border: none; border-radius: 10px; padding: 0.65rem 1.1rem; font-weight: 500; color: #64748b; transition: background .2s, color .2s; }
.gdtg-tabs .nav-link:hover { color: #1e40af; background: rgba(255,255,255,.9); }
.gdtg-tabs .nav-link.active { background: #2563eb; color: #fff; font-weight: 600; }
.gdtg-tabs-ico { margin-right: 0.4rem; opacity: .9; }
@media (max-width: 575px) { .gdtg-tabs .nav-link { padding: 0.5rem 0.75rem; font-size: 0.9rem; } .gdtg-tabs-ico { margin-right: 0.25rem; } }
.escrow-list-page .card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.08); overflow: hidden; }
.escrow-list-page .card-header-list { background: #fff; border-bottom: 1px solid #eee; padding: 1rem 1.5rem; font-weight: 700; font-size: 1.1rem; color: #212529; }
.escrow-list-page .table { margin-bottom: 0; }
.escrow-list-page .table thead th { border-bottom: 2px solid #e9ecef; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.02em; color: #6c757d; padding: 1rem 1rem; }
.escrow-list-page .table tbody td { padding: 1rem; vertical-align: middle; }
.escrow-list-page .table tbody tr { transition: background .15s; }
.escrow-list-page .table tbody tr:hover { background: #f8f9fa; }
.escrow-list-page .gdtg-code { font-family: ui-monospace, monospace; font-weight: 600; color: #5a67d8; font-size: 0.9rem; }
.escrow-list-page .amount-cell { font-weight: 600; color: #212529; }
.escrow-list-page .badge-role-seller { background: #e7f3ff; color: #0066cc; border: none; font-size: 0.75rem; font-weight: 600; padding: 0.25rem 0.5rem; }
.escrow-list-page .badge-role-buyer { background: #e8f5e9; color: #2e7d32; border: none; font-size: 0.75rem; font-weight: 600; padding: 0.25rem 0.5rem; }
.escrow-list-page .badge-status { font-size: 0.8rem; font-weight: 700; padding: 0.4rem 0.85rem; border-radius: 8px; text-transform: uppercase; letter-spacing: 0.03em; box-shadow: 0 1px 3px rgba(0,0,0,.15); white-space: nowrap; }
.escrow-list-page .badge-status.badge-secondary { background: #5a6268 !important; color: #fff !important; }
.escrow-list-page .badge-status.badge-warning { background: #e0a800 !important; color: #212529 !important; }
.escrow-list-page .badge-status.badge-info { background: #17a2b8 !important; color: #fff !important; }
.escrow-list-page .badge-status.badge-success { background: #28a745 !important; color: #fff !important; }
.escrow-list-page .badge-status.badge-danger { background: #dc3545 !important; color: #fff !important; }
.escrow-list-page .empty-state { padding: 3rem 2rem; text-align: center; }
.escrow-list-page .empty-state .fa-folder-open { font-size: 3rem; color: #dee2e6; margin-bottom: 1rem; }
.escrow-list-page .empty-state .btn { border-radius: 10px; font-weight: 600; padding: 0.6rem 1.5rem; }
.escrow-list-page .btn-view { border-radius: 8px; font-weight: 600; padding: 0.35rem 0.9rem; font-size: 0.875rem; }
@media (max-width: 767px) {
  .escrow-list-page .table thead { display: none; }
  .escrow-list-page .table tbody tr { display: block; border-bottom: 1px solid #eee; padding: 1rem 0; }
  .escrow-list-page .table tbody td { display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; border: none; }
  .escrow-list-page .table tbody td::before { content: attr(data-label); font-weight: 600; color: #6c757d; font-size: 0.8rem; margin-right: 0.5rem; }
  .escrow-list-page .table tbody td:last-child { justify-content: flex-end; margin-top: 0.5rem; padding-top: 0.75rem; border-top: 1px solid #f0f0f0; }
  .escrow-list-page .table tbody td:last-child::before { display: none; }
}
</style>

<div class="escrow-list-page">
  <div class="<?php if ($_smarty_tpl->tpl_vars['system']->value['fluid_design']) {?>container-fluid<?php } else { ?>container<?php }?> mt-4 pb-4">
    <div class="row">
      <div class="col-12 d-block d-md-none sg-offcanvas-sidebar mt-3">
        <?php $_smarty_tpl->_subTemplateRender('file:_sidebar.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
      </div>
      <div class="col-12 sg-offcanvas-mainbar">
        <div class="gdtg-tabs-bar mb-4">
          <nav class="gdtg-tabs nav nav-fill" role="tablist">
            <a class="nav-link" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/giao-dich-trung-gian"><i class="fa fa-info-circle gdtg-tabs-ico"></i> Giới thiệu</a>
            <a class="nav-link active" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/giao-dich-trung-gian/list"><i class="fa fa-list-ul gdtg-tabs-ico"></i> Danh sách giao dịch</a>
            <a class="nav-link" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/giao-dich-trung-gian/create"><i class="fa fa-plus-circle gdtg-tabs-ico"></i> Tạo giao dịch</a>
          </nav>
        </div>

        <div class="card">
          <div class="card-header card-header-list">
            <i class="fa fa-list-alt mr-2 text-primary"></i> Giao dịch trung gian của tôi
          </div>
          <div class="card-body p-0">
            <?php if (smarty_modifier_count($_smarty_tpl->tpl_vars['escrow_list']->value) == 0) {?>
              <div class="empty-state">
                <i class="fa fa-folder-open"></i>
                <p class="text-muted mb-3">Bạn chưa có giao dịch nào.</p>
                <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/giao-dich-trung-gian/create" class="btn btn-success"><i class="fa fa-plus mr-2"></i> Tạo giao dịch đầu tiên</a>
              </div>
            <?php } else { ?>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Mã</th>
                      <th>Tiêu đề</th>
                      <th>Giá trị</th>
                      <th>Vai trò</th>
                      <th>Trạng thái</th>
                      <th>Thời gian</th>
                      <th width="100"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['escrow_list']->value, 'e');
$_smarty_tpl->tpl_vars['e']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['e']->value) {
$_smarty_tpl->tpl_vars['e']->do_else = false;
?>
                    <tr>
                      <td data-label="Mã"><span class="gdtg-code"><?php echo htmlspecialchars((string)$_smarty_tpl->tpl_vars['e']->value['display_code'], ENT_QUOTES, 'UTF-8', true);?>
</span></td>
                      <td data-label="Tiêu đề"><span class="font-weight-medium text-dark"><?php echo htmlspecialchars((string)$_smarty_tpl->tpl_vars['e']->value['title'], ENT_QUOTES, 'UTF-8', true);?>
</span></td>
                      <td data-label="Giá trị" class="amount-cell"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['e']->value['amount'],0,',','.');?>
 đ</td>
                      <td data-label="Vai trò">
                        <?php if ($_smarty_tpl->tpl_vars['e']->value['is_seller']) {?><span class="badge badge-role-seller">Người bán</span><?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['e']->value['is_buyer']) {?><span class="badge badge-role-buyer">Người mua</span><?php }?>
                      </td>
                      <td data-label="Trạng thái">
                        <?php if ($_smarty_tpl->tpl_vars['e']->value['status'] == 'pending_deposit') {?><span class="badge badge-status badge-secondary">Chờ cọc tiền</span>
                        <?php } elseif ($_smarty_tpl->tpl_vars['e']->value['status'] == 'locked') {?><span class="badge badge-status badge-warning text-dark">Đã khóa</span>
                        <?php } elseif ($_smarty_tpl->tpl_vars['e']->value['status'] == 'delivering') {?><span class="badge badge-status badge-info">Chờ hoàn tất</span>
                        <?php } elseif ($_smarty_tpl->tpl_vars['e']->value['status'] == 'completed') {?><span class="badge badge-status badge-success">Hoàn tất</span>
                        <?php } elseif ($_smarty_tpl->tpl_vars['e']->value['status'] == 'disputed') {?><span class="badge badge-status badge-danger">Tranh chấp</span>
                        <?php } else { ?><span class="badge badge-status badge-secondary"><?php echo $_smarty_tpl->tpl_vars['e']->value['status'];?>
</span><?php }?>
                      </td>
                      <td data-label="Thời gian"><span class="text-muted small"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['e']->value['created_at'],"%d/%m/%Y %H:%M");?>
</span></td>
                      <td data-label="">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/giao-dich-trung-gian/detail/<?php echo $_smarty_tpl->tpl_vars['e']->value['id'];?>
" class="btn btn-primary btn-view"><i class="fa fa-arrow-right mr-1"></i> Xem</a>
                      </td>
                    </tr>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                  </tbody>
                </table>
              </div>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $_smarty_tpl->_subTemplateRender('file:_footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
