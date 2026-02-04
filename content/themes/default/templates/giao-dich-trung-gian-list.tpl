{include file='_head.tpl'}
{include file='_header.tpl'}

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
  <div class="{if $system['fluid_design']}container-fluid{else}container{/if} mt-4 pb-4">
    <div class="row">
      <div class="col-12 d-block d-md-none sg-offcanvas-sidebar mt-3">
        {include file='_sidebar.tpl'}
      </div>
      <div class="col-12 sg-offcanvas-mainbar">
        <div class="gdtg-tabs-bar mb-4">
          <nav class="gdtg-tabs nav nav-fill" role="tablist">
            <a class="nav-link" href="{$system['system_url']}/giao-dich-trung-gian"><i class="fa fa-info-circle gdtg-tabs-ico"></i> Giới thiệu</a>
            <a class="nav-link active" href="{$system['system_url']}/giao-dich-trung-gian/list"><i class="fa fa-list-ul gdtg-tabs-ico"></i> Danh sách giao dịch</a>
            <a class="nav-link" href="{$system['system_url']}/giao-dich-trung-gian/create"><i class="fa fa-plus-circle gdtg-tabs-ico"></i> Tạo giao dịch</a>
          </nav>
        </div>

        <div class="card">
          <div class="card-header card-header-list">
            <i class="fa fa-list-alt mr-2 text-primary"></i> Giao dịch trung gian của tôi
          </div>
          <div class="card-body p-0">
            {if $escrow_list|@count == 0}
              <div class="empty-state">
                <i class="fa fa-folder-open"></i>
                <p class="text-muted mb-3">Bạn chưa có giao dịch nào.</p>
                <a href="{$system['system_url']}/giao-dich-trung-gian/create" class="btn btn-success"><i class="fa fa-plus mr-2"></i> Tạo giao dịch đầu tiên</a>
              </div>
            {else}
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
                    {foreach $escrow_list as $e}
                    <tr>
                      <td data-label="Mã"><span class="gdtg-code">{$e.display_code|escape}</span></td>
                      <td data-label="Tiêu đề"><span class="font-weight-medium text-dark">{$e.title|escape}</span></td>
                      <td data-label="Giá trị" class="amount-cell">{$e.amount|number_format:0:',':'.'} đ</td>
                      <td data-label="Vai trò">
                        {if $e.is_seller}<span class="badge badge-role-seller">Người bán</span>{/if}
                        {if $e.is_buyer}<span class="badge badge-role-buyer">Người mua</span>{/if}
                      </td>
                      <td data-label="Trạng thái">
                        {if $e.status == 'pending_deposit'}<span class="badge badge-status badge-secondary">Chờ cọc tiền</span>
                        {elseif $e.status == 'locked'}<span class="badge badge-status badge-warning text-dark">Đã khóa</span>
                        {elseif $e.status == 'delivering'}<span class="badge badge-status badge-info">Chờ hoàn tất</span>
                        {elseif $e.status == 'completed'}<span class="badge badge-status badge-success">Hoàn tất</span>
                        {elseif $e.status == 'disputed'}<span class="badge badge-status badge-danger">Tranh chấp</span>
                        {else}<span class="badge badge-status badge-secondary">{$e.status}</span>{/if}
                      </td>
                      <td data-label="Thời gian"><span class="text-muted small">{$e.created_at|date_format:"%d/%m/%Y %H:%M"}</span></td>
                      <td data-label="">
                        <a href="{$system['system_url']}/giao-dich-trung-gian/detail/{$e.id}" class="btn btn-primary btn-view"><i class="fa fa-arrow-right mr-1"></i> Xem</a>
                      </td>
                    </tr>
                    {/foreach}
                  </tbody>
                </table>
              </div>
            {/if}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{include file='_footer.tpl'}
