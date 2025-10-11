<div class="card">
  <div class="card-header with-icon">
    <i class="fa fa-robot mr10"></i>{__("Shop-AI Admin Dashboard")}
  </div>
  <div class="card-body">
    
    <!-- Biểu đồ 7 ngày gần nhất -->
    <div class="chart-section mb30">
      <div class="heading-small mb15">
        <i class="fa fa-chart-bar mr5"></i> Thống kê 7 ngày gần nhất
      </div>
      
      <div class="chart-container">
        <canvas id="shopAiChart" width="400" height="200"></canvas>
      </div>
    </div>
    
    <!-- Thống kê Check Số -->
    <div class="heading-small mb15">
      <i class="fa fa-search mr5"></i> Thống kê Check Số Điện Thoại
    </div>
    
    <div class="row mb20">
      <!-- Check Thành Công -->
      <div class="col-md-4">
        <div class="stat-panel bg-gradient-success">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-check-circle"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">{$shop_ai_stats['total_success']|number_format}</div>
              <div class="stat-title">Check Thành Công (Tổng)</div>
              <div class="stat-meta">
                <span><i class="fa fa-calendar-day"></i> Hôm nay:</span>
                <strong>{$shop_ai_stats['today_success']|number_format}</strong>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Đang Check -->
      <div class="col-md-4">
        <div class="stat-panel bg-gradient-warning">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-clock"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">{$shop_ai_stats['total_pending']|number_format}</div>
              <div class="stat-title">Đang Check (Tổng)</div>
              <div class="stat-meta">
                <span><i class="fa fa-calendar-day"></i> Hôm nay:</span>
                <strong>{$shop_ai_stats['today_pending']|number_format}</strong>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Check Thất Bại -->
      <div class="col-md-4">
        <div class="stat-panel bg-gradient-danger">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-times-circle"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">{$shop_ai_stats['total_failed']|number_format}</div>
              <div class="stat-title">Check Thất Bại (Tổng)</div>
              <div class="stat-meta">
                <span><i class="fa fa-calendar-day"></i> Hôm nay:</span>
                <strong>{$shop_ai_stats['today_failed']|number_format}</strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Separator -->
    <hr class="mb20">

    <!-- Thống kê Người Dùng -->
    <div class="heading-small mb15">
      <i class="fa fa-users mr5"></i> Thống kê Người Dùng
    </div>

    <div class="row mb20">
      <!-- Tổng Người Dùng -->
      <div class="col-md-4">
        <div class="stat-panel bg-gradient-purple">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-user-check"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">{$shop_ai_stats['total_users']|number_format}</div>
              <div class="stat-title">Người Dùng Đã Check Số</div>
              <div class="stat-meta">
                <span><i class="fa fa-calendar-day"></i> Hôm nay:</span>
                <strong>{$shop_ai_stats['today_users']|number_format}</strong>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Người Dùng Đã Nạp Tiền -->
      <div class="col-md-4">
        <div class="stat-panel bg-gradient-teal">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-user-plus"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">{$shop_ai_stats['users_recharged']|number_format}</div>
              <div class="stat-title">Người Dùng Đã Nạp Tiền</div>
              <div class="stat-meta">
                <span><i class="fa fa-percentage"></i> Tỷ lệ:</span>
                <strong>
                  {if $shop_ai_stats['total_users'] > 0}
                    {(($shop_ai_stats['users_recharged'] / $shop_ai_stats['total_users']) * 100)|number_format:1}%
                  {else}
                    0%
                  {/if}
                </strong>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tổng Số Check -->
      <div class="col-md-4">
        <div class="stat-panel bg-gradient-cyan">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-search-plus"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">
                {($shop_ai_stats['total_success'] + $shop_ai_stats['total_pending'] + $shop_ai_stats['total_failed'])|number_format}
              </div>
              <div class="stat-title">Tổng Số Lượt Check</div>
              <div class="stat-meta">
                <span><i class="fa fa-chart-line"></i> TB/User:</span>
                <strong>
                  {if $shop_ai_stats['total_users'] > 0}
                    {(($shop_ai_stats['total_success'] + $shop_ai_stats['total_pending'] + $shop_ai_stats['total_failed']) / $shop_ai_stats['total_users'])|number_format:1}
                  {else}
                    0
                  {/if}
                </strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Separator -->
    <hr class="mb20">

    <!-- Thống kê Rút Tiền -->
    <div class="heading-small mb15">
      <i class="fa fa-money-bill-wave mr5"></i> Thống kê Rút Tiền
    </div>

    <div class="row mb20">
      <!-- Đang Chờ Xử Lý -->
      <div class="col-md-3">
        <div class="stat-panel bg-gradient-warning">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-clock"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">{$shop_ai_stats['pending_withdrawals_count']|number_format}</div>
              <div class="stat-title">Đang Chờ Xử Lý</div>
              <div class="stat-meta">
                <span><i class="fa fa-check-circle"></i> Đã hoàn thành:</span>
                <strong>{$shop_ai_stats['completed_withdrawals']|number_format}</strong>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tổng Đã Rút -->
      <div class="col-md-3">
        <div class="stat-panel bg-gradient-success">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-hand-holding-usd"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">{($shop_ai_stats['total_withdrawn']/1000000)|number_format:1}M</div>
              <div class="stat-title">Tổng Đã Rút</div>
              <div class="stat-meta">
                <span><i class="fa fa-calendar-day"></i> Hôm nay:</span>
                <strong>{($shop_ai_stats['today_withdrawals_amount']/1000)|number_format:0}K</strong>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tổng Phí Thu -->
      <div class="col-md-3">
        <div class="stat-panel bg-gradient-info">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-percentage"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">{($shop_ai_stats['total_withdrawal_fees']/1000)|number_format:0}K</div>
              <div class="stat-title">Tổng Phí Thu (1%)</div>
              <div class="stat-meta">
                <span><i class="fa fa-chart-line"></i> Lợi nhuận:</span>
                <strong>{$shop_ai_stats['total_withdrawal_fees']|number_format:0} VNĐ</strong>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tỷ Lệ Thành Công -->
      <div class="col-md-3">
        <div class="stat-panel bg-gradient-primary">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-chart-pie"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">
                {if $shop_ai_stats['total_withdrawals'] > 0}
                  {(($shop_ai_stats['completed_withdrawals']/$shop_ai_stats['total_withdrawals'])*100)|number_format:1}%
                {else}
                  0%
                {/if}
              </div>
              <div class="stat-title">Tỷ Lệ Thành Công</div>
              <div class="stat-meta">
                <span><i class="fa fa-times-circle"></i> Thất bại:</span>
                <strong>{$shop_ai_stats['cancelled_withdrawals']|number_format}</strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Separator -->
    <hr class="mb20">

    <!-- Thống kê Google Maps Reviews -->
    <div class="heading-small mb15">
      <i class="fa fa-map-marked-alt mr5"></i> Thống kê Google Maps Reviews
    </div>

    <div class="row mb20">
      <!-- Tổng Chiến Dịch -->
      <div class="col-md-3">
        <div class="stat-panel bg-gradient-indigo">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-bullhorn"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">{$shop_ai_stats['gmr_total_campaigns']|number_format}</div>
              <div class="stat-title">Tổng Chiến Dịch</div>
              <div class="stat-meta">
                <span><i class="fa fa-calendar-day"></i> Hôm nay:</span>
                <strong>{$shop_ai_stats['gmr_today_campaigns']|number_format}</strong>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Chiến Dịch Đang Chạy -->
      <div class="col-md-3">
        <div class="stat-panel bg-gradient-success">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-play-circle"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">{$shop_ai_stats['gmr_active_campaigns']|number_format}</div>
              <div class="stat-title">Đang Hoạt Động</div>
              <div class="stat-meta">
                <span><i class="fa fa-check-circle"></i> Hoàn thành:</span>
                <strong>{$shop_ai_stats['gmr_completed_campaigns']|number_format}</strong>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tổng Nhiệm Vụ -->
      <div class="col-md-3">
        <div class="stat-panel bg-gradient-blue">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-tasks"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">{$shop_ai_stats['gmr_total_tasks']|number_format}</div>
              <div class="stat-title">Tổng Nhiệm Vụ</div>
              <div class="stat-meta">
                <span><i class="fa fa-calendar-day"></i> Hôm nay:</span>
                <strong>{$shop_ai_stats['gmr_today_tasks']|number_format}</strong>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Nhiệm Vụ Hoàn Thành -->
      <div class="col-md-3">
        <div class="stat-panel bg-gradient-success">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-check-double"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">{$shop_ai_stats['gmr_completed_tasks']|number_format}</div>
              <div class="stat-title">Nhiệm Vụ Hoàn Thành</div>
              <div class="stat-meta">
                <span><i class="fa fa-percentage"></i> Tỷ lệ:</span>
                <strong>
                  {if $shop_ai_stats['gmr_total_tasks'] > 0}
                    {(($shop_ai_stats['gmr_completed_tasks'] / $shop_ai_stats['gmr_total_tasks']) * 100)|number_format:1}%
                  {else}
                    0%
                  {/if}
                </strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mb20">
      <!-- Nhiệm Vụ Đang Giao -->
      <div class="col-md-3">
        <div class="stat-panel bg-gradient-warning">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-hand-paper"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">{$shop_ai_stats['gmr_assigned_tasks']|number_format}</div>
              <div class="stat-title">Đang Thực Hiện</div>
              <div class="stat-meta">
                <span><i class="fa fa-shield-alt"></i> Đang xác minh:</span>
                <strong>{$shop_ai_stats['gmr_verified_tasks']|number_format}</strong>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Nhiệm Vụ Hết Hạn -->
      <div class="col-md-3">
        <div class="stat-panel bg-gradient-danger">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-times-circle"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">{$shop_ai_stats['gmr_expired_tasks']|number_format}</div>
              <div class="stat-title">Nhiệm Vụ Hết Hạn</div>
              <div class="stat-meta">
                <span><i class="fa fa-percentage"></i> Tỷ lệ thất bại:</span>
                <strong>
                  {if $shop_ai_stats['gmr_total_tasks'] > 0}
                    {(($shop_ai_stats['gmr_expired_tasks'] / $shop_ai_stats['gmr_total_tasks']) * 100)|number_format:1}%
                  {else}
                    0%
                  {/if}
                </strong>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Người Dùng Tham Gia -->
      <div class="col-md-3">
        <div class="stat-panel bg-gradient-purple">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-users"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">{$shop_ai_stats['gmr_total_users']|number_format}</div>
              <div class="stat-title">Người Tham Gia</div>
              <div class="stat-meta">
                <span><i class="fa fa-calendar-day"></i> Hôm nay:</span>
                <strong>{$shop_ai_stats['gmr_today_users']|number_format}</strong>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tổng Tiền Thưởng -->
      <div class="col-md-3">
        <div class="stat-panel bg-gradient-primary">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-gift"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">
                {($shop_ai_stats['gmr_total_rewards']/1000)|number_format:0}K
              </div>
              <div class="stat-title">Tổng Tiền Thưởng Đã Trả</div>
              <div class="stat-meta">
                <span><i class="fa fa-calendar-day"></i> Hôm nay:</span>
                <strong>{($shop_ai_stats['gmr_today_rewards']/1000)|number_format:0}K VNĐ</strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Biểu đồ Google Maps 7 ngày -->
    <div class="chart-section mb30">
      <div class="heading-small mb15">
        <i class="fa fa-chart-line mr5"></i> Thống kê Google Maps Reviews 7 ngày gần nhất
      </div>
      
      <div class="chart-container">
        <canvas id="gmrChart" width="400" height="200"></canvas>
      </div>
    </div>

    <!-- Separator -->
    <hr class="mb20">

    <!-- YÊU CẦU RÚT TIỀN ĐANG CHỜ XỬ LÝ -->
    {if $pending_withdrawals_count > 0}
    <div class="card mb30">
      <div class="card-header with-icon bg-warning">
        <i class="fa fa-exclamation-triangle mr10"></i>
        <strong>Yêu cầu Rút Tiền Chờ Xử Lý</strong>
        <span class="badge badge-danger ml10">{$pending_withdrawals_count}</span>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-striped table-hover mb-0">
            <thead class="thead-light">
              <tr>
                <th width="8%">QR Code</th>
                <th width="12%">User</th>
                <th width="12%">Ngân Hàng</th>
                <th width="12%">STK</th>
                <th width="15%">Tên Chủ TK</th>
                <th width="10%">Số Tiền</th>
                <th width="8%">Phí</th>
                <th width="10%">Thực Nhận</th>
                <th width="8%">Hết Hạn</th>
                <th width="5%">Action</th>
              </tr>
            </thead>
            <tbody>
              {foreach $pending_withdrawals as $wd}
              <tr class="{if $wd.is_urgent}table-danger{/if}">
                <td>
                  <code class="badge badge-primary font-weight-bold">{$wd.qr_code}</code>
                </td>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="{$wd.user_picture}" class="rounded-circle mr-2" width="32" height="32">
                    <div>
                      <a href="{$system['system_url']}/{$wd.user_name}" target="_blank" class="font-weight-bold">
                        {$wd.user_firstname} {$wd.user_lastname}
                      </a>
                      {if $wd.user_verified}
                        <i class="fa fa-check-circle text-primary ml-1" title="Verified"></i>
                      {/if}
                      <br><small class="text-muted">@{$wd.user_name}</small>
                    </div>
                  </div>
                </td>
                <td>
                  <strong>{$wd.withdrawal_bank_name}</strong>
                  <br><small class="text-muted">{$wd.withdrawal_bank_code}</small>
                </td>
                <td>
                  <span class="badge badge-info font-weight-bold">{$wd.withdrawal_account_number}</span>
                  <button class="btn btn-xs btn-outline-secondary ml-1" onclick="copyText('{$wd.withdrawal_account_number}')" title="Copy STK">
                    <i class="fa fa-copy"></i>
                  </button>
                </td>
                <td>
                  <strong>{$wd.withdrawal_account_holder}</strong>
                  <button class="btn btn-xs btn-outline-secondary ml-1" onclick="copyText('{$wd.withdrawal_account_holder}')" title="Copy tên">
                    <i class="fa fa-copy"></i>
                  </button>
                </td>
                <td>
                  <span class="text-danger font-weight-bold">{$wd.amount|number_format:0}</span>
                  <br><small class="text-muted">VNĐ</small>
                </td>
                <td>
                  <span class="text-muted">{$wd.fee|number_format:0}</span>
                  <br><small class="text-muted">VNĐ</small>
                </td>
                <td>
                  <span class="text-success font-weight-bold">{$wd.actual_amount|number_format:0}</span>
                  <br><small class="text-muted">VNĐ</small>
                </td>
                <td>
                  <span class="countdown {if $wd.is_urgent}text-danger font-weight-bold{else}text-warning{/if}" 
                        data-expires="{$wd.expires_at}" 
                        data-qr="{$wd.qr_code}">
                    {$wd.time_left_formatted}
                  </span>
                </td>
                <td>
                  <button class="btn btn-sm btn-primary" 
                          onclick="showWithdrawalQR('{$wd.qr_code}', '{$wd.qr_image_url|escape}', '{$wd.withdrawal_bank_name|escape}', '{$wd.withdrawal_account_number}', '{$wd.withdrawal_account_holder|escape}', {$wd.actual_amount}, '{$wd.qr_code}')"
                          title="Xem QR Code">
                    <i class="fa fa-qrcode"></i>
                  </button>
                </td>
              </tr>
              {/foreach}
            </tbody>
          </table>
        </div>
      </div>
    </div>
    {/if}

    <!-- Separator -->
    <hr class="mb20">

    <!-- Thống kê Nạp Tiền -->
    <div class="heading-small mb15">
      <i class="fa fa-wallet mr5"></i> Thống kê Nạp Tiền
    </div>

    <div class="row">
      <!-- Tổng Tiền Nạp -->
      <div class="col-md-6">
        <div class="stat-panel bg-gradient-primary">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">
                {$shop_ai_stats['total_recharge']|number_format:0:',':'.'} VNĐ
              </div>
              <div class="stat-title">Tổng Tiền Nạp (Tất Cả)</div>
              <div class="stat-meta two-cols">
                <div><i class="fa fa-receipt"></i> Số giao dịch: <strong>{$shop_ai_stats['total_recharge_count']|number_format}</strong></div>
                <div><i class="fa fa-calendar-day"></i> Hôm nay: <strong>{$shop_ai_stats['today_recharge']|number_format:0:',':'.'} VNĐ</strong></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Giao Dịch Hôm Nay -->
      <div class="col-md-6">
        <div class="stat-panel bg-gradient-info">
          <div class="stat-inner">
            <div class="stat-icon">
              <i class="fa fa-credit-card"></i>
            </div>
            <div class="stat-content">
              <div class="stat-value">{$shop_ai_stats['today_recharge_count']|number_format}</div>
              <div class="stat-title">Giao Dịch Hôm Nay</div>
              <div class="stat-meta two-cols">
                <div><i class="fa fa-chart-line"></i> Trung bình:</div>
                <div>
                  <strong>
                    {if $shop_ai_stats['today_recharge_count'] > 0}
                      {($shop_ai_stats['today_recharge'] / $shop_ai_stats['today_recharge_count'])|number_format:0:',':'.'} VNĐ
                    {else}
                      0 VNĐ
                    {/if}
                  </strong>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tổng Quan -->
    <div class="row mt20">
      <div class="col-12">
        <div class="alert alert-info" style="padding: 10px 15px;">
          <i class="fa fa-info-circle mr5"></i>
          <strong>Ghi chú:</strong> Dữ liệu được cập nhật theo thời gian thực. 
          <ul class="mb0 mt3" style="font-size: 11px; padding-left: 18px;">
            <li style="margin-bottom: 2px;"><strong>Check Số:</strong> Số liệu check thất bại bao gồm cả status 'failed' và 'not_found'. Tổng số check = Thành công + Đang check + Thất bại</li>
            <li style="margin-bottom: 2px;"><strong>Google Maps Reviews:</strong> Nhiệm vụ hết hạn bao gồm cả status 'expired' và 'timeout'. Tỷ lệ hoàn thành = Nhiệm vụ hoàn thành / Tổng nhiệm vụ</li>
            <li style="margin-bottom: 2px;"><strong>Người Dùng:</strong> Check số - tính nếu đã check ít nhất 1 lần. Google Maps - tính nếu đã nhận ít nhất 1 nhiệm vụ</li>
            <li><strong>Nạp Tiền:</strong> Chỉ tính giao dịch type='recharge' có mã RZ trong description (VD: RZ12345ABC)</li>
          </ul>
        </div>
      </div>
    </div>

  </div>
</div>

<style>
/* ===== Base Card Spacing ===== */
.card-body { padding: 15px !important; }
.container, .container-fluid,
.card, .card-body {
  padding-left: 15px !important;
  padding-right: 15px !important;
}

/* ===== Headings ===== */
.heading-small {
  font-size: 16px;
  font-weight: 600;
  color: #495057;
  border-bottom: 2px solid #e9ecef;
  padding-bottom: 8px;
  margin-bottom: 0;
}

/* ===== Stat Panel (No overlay, no fixed height) ===== */
.stat-panel {
  position: relative;
  color: #fff;
  border-radius: 10px;
  margin-bottom: 15px;
  padding: 14px 14px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

.stat-inner {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  min-width: 0; /* allow text ellipsis */
}

.stat-icon {
  flex: 0 0 44px;
  line-height: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: 2px;
}

.stat-icon i {
  font-size: 34px;
  opacity: .25; /* vẫn có cảm giác "bg" nhẹ, nhưng không che text */
}

.stat-content {
  flex: 1 1 auto;
  min-width: 0;
}

.stat-value {
  font-weight: 700;
  line-height: 1.1;
  /* Responsive size: 20px -> 26px tùy viewport */
  font-size: clamp(20px, 2.2vw, 26px);
  margin-bottom: 2px;
  word-break: break-word;
}

.stat-title {
  font-size: 12px;
  line-height: 1.2;
  font-weight: 500;
  opacity: .95;
  margin-bottom: 6px;
}

.stat-meta {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 11px;
  line-height: 1.2;
  opacity: .95;
  flex-wrap: wrap;
}

.stat-meta i {
  font-size: 10px;
  margin-right: 4px;
}

.stat-meta.two-cols {
  justify-content: space-between;
  gap: 8px 12px;
}

.stat-content strong { font-weight: 700; }

/* ===== Gradients ===== */
.bg-gradient-success { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); }
.bg-gradient-warning { background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); }
.bg-gradient-danger  { background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); }
.bg-gradient-primary { background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); }
.bg-gradient-info    { background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); }
.bg-gradient-purple  { background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%); }
.bg-gradient-teal    { background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%); }
.bg-gradient-cyan    { background: linear-gradient(135deg, #17a2b8 0%, #0e7c8c 100%); }
.bg-gradient-indigo  { background: linear-gradient(135deg, #6610f2 0%, #4e0bc4 100%); }
.bg-gradient-blue    { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); }

/* ===== Utilities ===== */
.mb20 { margin-bottom: 20px !important; }
.mt20 { margin-top: 20px !important; }
.mr5  { margin-right: 5px !important; }
.mr10 { margin-right: 10px !important; }

/* ===== Responsive Tweaks ===== */
@media (max-width: 991.98px) {
  .stat-icon { flex-basis: 40px; }
  .stat-icon i { font-size: 30px; }
  .stat-value { font-size: clamp(18px, 3vw, 24px); }
  .stat-title { font-size: 12px; }
  .stat-meta { font-size: 11px; }
}

@media (max-width: 575.98px) {
  .stat-inner { gap: 10px; }
  .stat-icon { flex-basis: 36px; }
  .stat-icon i { font-size: 26px; }
  .stat-title { font-size: 11px; }
  .stat-meta { font-size: 10.5px; }
}

/* Giữ nguyên alert compact style */
.alert-info { margin-bottom: 0; }
.alert-info strong { font-size: 13px; }

/* ===== Chart Section ===== */
.chart-section {
  background: #f8f9fa;
  border-radius: 8px;
  padding: 20px;
  margin-bottom: 25px;
}

.chart-container {
  position: relative;
  height: 300px;
  width: 100%;
}

.chart-container canvas {
  max-height: 300px;
}

.mb30 { margin-bottom: 30px !important; }
</style>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dữ liệu từ PHP
    const chartData = {$shop_ai_stats['chart_data']|@json_encode};
    
    // Chuẩn bị dữ liệu cho Chart.js
    const labels = chartData.map(item => item.day_name);
    const successData = chartData.map(item => item.success);
    const failedData = chartData.map(item => item.failed);
    const pendingData = chartData.map(item => item.pending);
    
    // Tạo biểu đồ
    const ctx = document.getElementById('shopAiChart').getContext('2d');
    const shopAiChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Thành công',
                    data: successData,
                    backgroundColor: 'rgba(40, 167, 69, 0.8)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Thất bại',
                    data: failedData,
                    backgroundColor: 'rgba(220, 53, 69, 0.8)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Đang check',
                    data: pendingData,
                    backgroundColor: 'rgba(255, 193, 7, 0.8)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12
                        }
                    }
                },
                title: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
    
    // === BIỂU ĐỒ GOOGLE MAPS REVIEWS ===
    const gmrChartData = {$shop_ai_stats['gmr_chart_data']|@json_encode};
    
    // Chuẩn bị dữ liệu cho Chart.js
    const gmrLabels = gmrChartData.map(item => item.day_name);
    const gmrCampaignsData = gmrChartData.map(item => item.campaigns);
    const gmrCompletedData = gmrChartData.map(item => item.completed);
    const gmrAssignedData = gmrChartData.map(item => item.assigned);
    const gmrRewardsData = gmrChartData.map(item => item.rewards / 1000); // Chia 1000 để hiển thị theo K
    
    // Tạo biểu đồ Google Maps Reviews
    const gmrCtx = document.getElementById('gmrChart').getContext('2d');
    const gmrChart = new Chart(gmrCtx, {
        type: 'line',
        data: {
            labels: gmrLabels,
            datasets: [
                {
                    label: 'Chiến dịch mới',
                    data: gmrCampaignsData,
                    backgroundColor: 'rgba(102, 16, 242, 0.1)',
                    borderColor: 'rgba(102, 16, 242, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Nhiệm vụ hoàn thành',
                    data: gmrCompletedData,
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Nhiệm vụ giao mới',
                    data: gmrAssignedData,
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Tiền thưởng (K VNĐ)',
                    data: gmrRewardsData,
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: {
                            size: 11
                        }
                    }
                },
                title: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                if (context.dataset.label === 'Tiền thưởng (K VNĐ)') {
                                    label += context.parsed.y.toFixed(0) + ' K VNĐ';
                                } else {
                                    label += context.parsed.y;
                                }
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 11
                        },
                        callback: function(value) {
                            return value + 'K';
                        }
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
});
</script>

<!-- Modal QR Code Rút Tiền -->
<div class="modal fade" id="withdrawalQRModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">
          <i class="fa fa-qrcode mr-2"></i>
          QR Chuyển Tiền - <span id="modalQRCode"></span>
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <!-- QR Code Image -->
        <div class="mb-3">
          <img id="modalQRImage" src="" class="img-fluid" style="max-width: 350px; border: 3px solid #007bff; border-radius: 10px;">
        </div>
        
        <!-- Transfer Info Card -->
        <div class="card bg-light">
          <div class="card-body">
            <div class="row text-left">
              <div class="col-md-6 mb-2">
                <small class="text-muted">Ngân hàng:</small>
                <br><strong id="modalBankName"></strong>
              </div>
              <div class="col-md-6 mb-2">
                <small class="text-muted">Số tài khoản:</small>
                <br>
                <strong id="modalAccountNumber"></strong>
                <button class="btn btn-xs btn-secondary ml-1" onclick="copyText(document.getElementById('modalAccountNumber').textContent)">
                  <i class="fa fa-copy"></i>
                </button>
              </div>
              <div class="col-md-12 mb-2">
                <small class="text-muted">Chủ tài khoản:</small>
                <br>
                <strong id="modalAccountHolder"></strong>
                <button class="btn btn-xs btn-secondary ml-1" onclick="copyText(document.getElementById('modalAccountHolder').textContent)">
                  <i class="fa fa-copy"></i>
                </button>
              </div>
              <div class="col-md-6 mb-2">
                <small class="text-muted">Số tiền chuyển:</small>
                <br><strong class="text-success" id="modalAmount"></strong>
              </div>
              <div class="col-md-6 mb-2">
                <small class="text-muted">Nội dung CK:</small>
                <br>
                <code id="modalContent"></code>
                <button class="btn btn-xs btn-secondary ml-1" onclick="copyText(document.getElementById('modalContent').textContent)">
                  <i class="fa fa-copy"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Instructions -->
        <div class="alert alert-info mt-3 text-left">
          <i class="fa fa-info-circle mr-2"></i>
          <strong>Hướng dẫn:</strong>
          <ol class="mb-0 pl-3" style="font-size: 13px;">
            <li>Mở app ngân hàng trên điện thoại</li>
            <li>Scan QR code phía trên</li>
            <li>Kiểm tra thông tin tự động điền</li>
            <li>Xác nhận chuyển tiền</li>
            <li>Hệ thống sẽ tự động cập nhật trong vài giây</li>
          </ol>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="copyAllWithdrawalInfo()">
          <i class="fa fa-copy mr-1"></i> Copy Tất Cả
        </button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<script>
// Global variable lưu thông tin withdrawal hiện tại
var currentWithdrawalData = null;

// Show withdrawal QR modal
function showWithdrawalQR(qrCode, qrImageUrl, bankName, accountNumber, accountHolder, actualAmount, content) {
    currentWithdrawalData = {
        qrCode: qrCode,
        qrImageUrl: qrImageUrl,
        bankName: bankName,
        accountNumber: accountNumber,
        accountHolder: accountHolder,
        actualAmount: actualAmount,
        content: content
    };
    
    document.getElementById('modalQRCode').textContent = qrCode;
    document.getElementById('modalQRImage').src = qrImageUrl;
    document.getElementById('modalBankName').textContent = bankName;
    document.getElementById('modalAccountNumber').textContent = accountNumber;
    document.getElementById('modalAccountHolder').textContent = accountHolder;
    document.getElementById('modalAmount').textContent = numberFormat(actualAmount) + ' VNĐ';
    document.getElementById('modalContent').textContent = content;
    
    $('#withdrawalQRModal').modal('show');
}

// Copy text to clipboard
function copyText(text) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(function() {
            alert('Đã copy: ' + text);
        }).catch(function(err) {
            fallbackCopy(text);
        });
    } else {
        fallbackCopy(text);
    }
}

// Fallback copy method
function fallbackCopy(text) {
    var textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.position = "fixed";
    textArea.style.top = 0;
    textArea.style.left = 0;
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        document.execCommand('copy');
        alert('Đã copy: ' + text);
    } catch (err) {
        alert('Không thể copy. Vui lòng copy thủ công: ' + text);
    }
    
    document.body.removeChild(textArea);
}

// Copy all withdrawal info
function copyAllWithdrawalInfo() {
    if (!currentWithdrawalData) return;
    
    var text = 'THÔNG TIN CHUYỂN KHOẢN\n' +
               '━━━━━━━━━━━━━━━━━━━━━━\n' +
               'Ngân hàng: ' + currentWithdrawalData.bankName + '\n' +
               'STK: ' + currentWithdrawalData.accountNumber + '\n' +
               'Chủ TK: ' + currentWithdrawalData.accountHolder + '\n' +
               'Số tiền: ' + numberFormat(currentWithdrawalData.actualAmount) + ' VNĐ\n' +
               'Nội dung: ' + currentWithdrawalData.content + '\n' +
               '━━━━━━━━━━━━━━━━━━━━━━';
    
    copyText(text);
}

// Format number
function numberFormat(number) {
    return new Intl.NumberFormat('vi-VN').format(number);
}

// Auto refresh countdown timer
setInterval(function() {
    document.querySelectorAll('.countdown').forEach(function(element) {
        var expires = element.getAttribute('data-expires');
        var qrCode = element.getAttribute('data-qr');
        
        if (!expires) return;
        
        var expiresTime = new Date(expires).getTime();
        var now = new Date().getTime();
        var timeLeft = Math.floor((expiresTime - now) / 1000);
        
        if (timeLeft <= 0) {
            element.textContent = 'Đã hết hạn';
            element.classList.add('text-danger');
            element.classList.remove('text-warning');
            
            // Mark row as expired
            var row = element.closest('tr');
            if (row) {
                row.classList.add('table-danger');
                row.style.opacity = '0.6';
            }
        } else {
            var minutes = Math.floor(timeLeft / 60);
            var seconds = timeLeft % 60;
            element.textContent = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
            
            // Urgent warning
            if (timeLeft < 300) {
                element.classList.add('text-danger', 'font-weight-bold');
                element.classList.remove('text-warning');
            }
        }
    });
}, 1000);

// Auto reload page khi có withdrawal completed
var lastPendingCount = {$pending_withdrawals_count|default:0};
setInterval(function() {
    fetch('{$system['system_url']}/includes/ajax/admin/shop-ai.php?action=check_withdrawal_updates')
        .then(response => response.json())
        .then(data => {
            if (data.pending_count !== lastPendingCount) {
                console.log('Withdrawal updates detected, reloading...');
                location.reload();
            }
        })
        .catch(err => console.error('Error checking updates:', err));
}, 10000); // Check every 10 seconds
</script>

<style>
.mb30 { margin-bottom: 30px !important; }
.table-danger { background-color: #f8d7da !important; }
.bg-warning { background-color: #ffc107 !important; color: #000 !important; }
.thead-light th { background-color: #e9ecef; font-weight: 600; font-size: 12px; }
.table-hover tbody tr:hover { background-color: #f1f3f5; }
.btn-xs { padding: 2px 6px; font-size: 11px; }
</style>
