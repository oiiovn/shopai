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
            <li style="margin-bottom: 2px;">Số liệu check thất bại bao gồm cả status 'failed' và 'not_found'</li>
            <li style="margin-bottom: 2px;">Tổng số check = Thành công + Đang check + Thất bại</li>
            <li style="margin-bottom: 2px;">Người dùng được tính nếu đã thực hiện ít nhất 1 lần check số</li>
            <li>Thống kê nạp tiền: Chỉ tính giao dịch type='recharge' có mã RZ trong description (VD: RZ12345ABC)</li>
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
});
</script>
