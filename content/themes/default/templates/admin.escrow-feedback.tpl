<div class="card">
  <div class="card-header with-icon">
    <i class="fa fa-handshake mr10"></i>{__("Phản hồi Giao dịch trung gian")}
  </div>
  <div class="card-body">
    <div class="row mb20">
      <div class="col-md-4">
        <div class="card bg-primary text-white">
          <div class="card-body text-center">
            <h3 class="mb0">{$escrow_stats.total}</h3>
            <small>{__("Tổng phản hồi")}</small>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card bg-success text-white">
          <div class="card-body text-center">
            <h3 class="mb0">{$escrow_stats.interest}</h3>
            <small>{__("Quan tâm & muốn sử dụng")}</small>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card bg-info text-white">
          <div class="card-body text-center">
            <h3 class="mb0">{$escrow_stats.feedback}</h3>
            <small>{__("Góp ý hệ thống")}</small>
          </div>
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>{__("Người gửi")}</th>
            <th>{__("Loại")}</th>
            <th>{__("Nội dung")}</th>
            <th>{__("Thời gian")}</th>
          </tr>
        </thead>
        <tbody>
          {if $escrow_rows}
            {foreach $escrow_rows as $row}
              <tr>
                <td>{$row.id}</td>
                <td>
                  <a target="_blank" href="{$system['system_url']}/{$row.user_name}">
                    <img class="tbl-image" src="{$row.user_picture}" alt="">
                    {if $system['show_usernames_enabled']}{$row.user_name}{else}{$row.user_firstname} {$row.user_lastname}{/if}
                  </a>
                </td>
                <td>
                  {if $row.type == 'interest'}
                    <span class="badge bg-success">{$row.type_label}</span>
                  {else}
                    <span class="badge bg-info">{$row.type_label}</span>
                  {/if}
                </td>
                <td>{if $row.message}{$row.message|nl2br}{else}&mdash;{/if}</td>
                <td>{$row.created_at|date_format:"%d/%m/%Y %H:%M"}</td>
              </tr>
            {/foreach}
          {else}
            <tr>
              <td colspan="5" class="text-center text-muted">{__("Chưa có phản hồi nào.")}</td>
            </tr>
          {/if}
        </tbody>
      </table>
    </div>
  </div>
</div>
