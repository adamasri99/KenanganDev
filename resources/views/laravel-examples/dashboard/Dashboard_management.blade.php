@extends('layouts.user_type.auth')

@section('content')

  <!-- Generate Report Button - Top Section -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-body p-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h5 class="mb-0 font-weight-bolder">Business Dashboard</h5>
              <p class="text-sm mb-0 text-muted">Comprehensive overview of your business performance</p>
            </div>
            <button class="btn btn-primary btn-lg" onclick="generatePDFReport()">
              <i class="fas fa-file-pdf me-2"></i>Generate PDF Report
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Key Metrics Cards -->
  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Sales</p>
                <h5 class="font-weight-bolder mb-0">
                  RM <span id="totalSales">125,430</span>
                  <span class="text-success text-sm font-weight-bolder">+12%</span>
                </h5>
                <p class="text-xs text-muted mb-0">This Month</p>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Expenses</p>
                <h5 class="font-weight-bolder mb-0">
                  RM <span id="totalExpenses">78,250</span>
                  <span class="text-warning text-sm font-weight-bolder">+5%</span>
                </h5>
                <p class="text-xs text-muted mb-0">This Month</p>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">ROI (Profit)</p>
                <h5 class="font-weight-bolder mb-0">
                  RM <span id="roiAmount">47,180</span>
                </h5>
                <p class="text-xs mb-0">
                  <span class="text-success font-weight-bold" id="roiPercentage">60.3%</span> Margin
                </p>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="ni ni-chart-pie-35 text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Top Product</p>
                <h5 class="font-weight-bolder mb-0" id="topProduct">
                  Laptop Pro X1
                </h5>
                <p class="text-xs text-muted mb-0">
                  <span class="font-weight-bold" id="topProductSales">342</span> units sold
                </p>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="ni ni-trophy text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts Section -->
  <div class="row mt-4">
    <div class="col-lg-8">
      <div class="card z-index-2">
        <div class="card-header pb-0">
          <h6>Sales Trend</h6>
          <p class="text-sm">
            <i class="fa fa-arrow-up text-success"></i>
            <span class="font-weight-bold">12% more</span> than last month
          </p>
        </div>
        <div class="card-body p-3">
          <div class="chart">
            <canvas id="chart-sales-trend" class="chart-canvas" height="300"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card z-index-2">
        <div class="card-header pb-0">
          <h6>Monthly Comparison</h6>
          <p class="text-sm">Sales vs Expenses</p>
        </div>
        <div class="card-body p-3">
          <div class="chart">
            <canvas id="chart-comparison" class="chart-canvas" height="300"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Top Products Table -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-7">
              <h6>Top Performing Products</h6>
              <p class="text-sm mb-0">
                <i class="fa fa-check text-info" aria-hidden="true"></i>
                <span class="font-weight-bold ms-1">Top 5</span> best sellers this month
              </p>
            </div>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Name</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Category</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Units Sold</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Revenue</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Performance</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div>
                        <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm me-3" alt="product">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">Laptop Pro X1</h6>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0">Electronics</p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold">342 units</span>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold">RM 45,680</span>
                  </td>
                  <td class="align-middle">
                    <div class="progress-wrapper w-75 mx-auto">
                      <div class="progress-info">
                        <div class="progress-percentage">
                          <span class="text-xs font-weight-bold">95%</span>
                        </div>
                      </div>
                      <div class="progress">
                        <div class="progress-bar bg-gradient-success w-95" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div>
                        <img src="../assets/img/small-logos/logo-xd.svg" class="avatar avatar-sm me-3" alt="product">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">Smart Watch Series 5</h6>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0">Wearables</p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold">287 units</span>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold">RM 28,700</span>
                  </td>
                  <td class="align-middle">
                    <div class="progress-wrapper w-75 mx-auto">
                      <div class="progress-info">
                        <div class="progress-percentage">
                          <span class="text-xs font-weight-bold">80%</span>
                        </div>
                      </div>
                      <div class="progress">
                        <div class="progress-bar bg-gradient-info w-80" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div>
                        <img src="../assets/img/small-logos/logo-atlassian.svg" class="avatar avatar-sm me-3" alt="product">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">Wireless Headphones</h6>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0">Audio</p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold">231 units</span>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold">RM 18,480</span>
                  </td>
                  <td class="align-middle">
                    <div class="progress-wrapper w-75 mx-auto">
                      <div class="progress-info">
                        <div class="progress-percentage">
                          <span class="text-xs font-weight-bold">75%</span>
                        </div>
                      </div>
                      <div class="progress">
                        <div class="progress-bar bg-gradient-info w-75" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div>
                        <img src="../assets/img/small-logos/logo-slack.svg" class="avatar avatar-sm me-3" alt="product">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">Gaming Mouse Pro</h6>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0">Accessories</p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold">198 units</span>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold">RM 15,840</span>
                  </td>
                  <td class="align-middle">
                    <div class="progress-wrapper w-75 mx-auto">
                      <div class="progress-info">
                        <div class="progress-percentage">
                          <span class="text-xs font-weight-bold">65%</span>
                        </div>
                      </div>
                      <div class="progress">
                        <div class="progress-bar bg-gradient-info w-65" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div>
                        <img src="../assets/img/small-logos/logo-jira.svg" class="avatar avatar-sm me-3" alt="product">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">4K Monitor 27"</h6>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0">Displays</p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold">156 units</span>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold">RM 16,730</span>
                  </td>
                  <td class="align-middle">
                    <div class="progress-wrapper w-75 mx-auto">
                      <div class="progress-info">
                        <div class="progress-percentage">
                          <span class="text-xs font-weight-bold">60%</span>
                        </div>
                      </div>
                      <div class="progress">
                        <div class="progress-bar bg-gradient-info w-60" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('dashboard')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  
  <script>
    // Calculate ROI dynamically
    function calculateROI() {
      const sales = parseFloat(document.getElementById('totalSales').textContent.replace(/,/g, ''));
      const expenses = parseFloat(document.getElementById('totalExpenses').textContent.replace(/,/g, ''));
      const roi = sales - expenses;
      const roiPercentage = ((roi / expenses) * 100).toFixed(1);
      
      document.getElementById('roiAmount').textContent = roi.toLocaleString();
      document.getElementById('roiPercentage').textContent = roiPercentage + '%';
    }

    // Generate PDF Report Function
    function generatePDFReport() {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();
      
      // Title
      doc.setFontSize(20);
      doc.setTextColor(33, 37, 41);
      doc.text('Business Dashboard Report', 20, 20);
      
      // Date
      doc.setFontSize(10);
      doc.setTextColor(108, 117, 125);
      doc.text('Generated: ' + new Date().toLocaleDateString(), 20, 28);
      
      // Line separator
      doc.setDrawColor(200, 200, 200);
      doc.line(20, 32, 190, 32);
      
      // Key Metrics Section
      doc.setFontSize(14);
      doc.setTextColor(33, 37, 41);
      doc.text('Key Performance Metrics', 20, 42);
      
      doc.setFontSize(11);
      const sales = document.getElementById('totalSales').textContent;
      const expenses = document.getElementById('totalExpenses').textContent;
      const roi = document.getElementById('roiAmount').textContent;
      const roiPct = document.getElementById('roiPercentage').textContent;
      const topProduct = document.getElementById('topProduct').textContent;
      const topProductSales = document.getElementById('topProductSales').textContent;
      
      doc.text('Total Sales (This Month):', 20, 52);
      doc.setTextColor(40, 167, 69);
      doc.text('RM ' + sales, 120, 52);
      
      doc.setTextColor(33, 37, 41);
      doc.text('Total Expenses (This Month):', 20, 62);
      doc.setTextColor(255, 193, 7);
      doc.text('RM ' + expenses, 120, 62);
      
      doc.setTextColor(33, 37, 41);
      doc.text('ROI (Profit):', 20, 72);
      doc.setTextColor(13, 110, 253);
      doc.text('RM ' + roi + ' (' + roiPct + ' margin)', 120, 72);
      
      doc.setTextColor(33, 37, 41);
      doc.text('Top Product:', 20, 82);
      doc.setTextColor(23, 162, 184);
      doc.text(topProduct, 120, 82);
      doc.text(topProductSales + ' units sold', 120, 88);
      
      // Line separator
      doc.setDrawColor(200, 200, 200);
      doc.line(20, 95, 190, 95);
      
      // Top Products Section
      doc.setFontSize(14);
      doc.setTextColor(33, 37, 41);
      doc.text('Top 5 Products', 20, 105);
      
      doc.setFontSize(10);
      const products = [
        ['1. Laptop Pro X1', 'RM 45,680', '342 units'],
        ['2. Smart Watch Series 5', 'RM 28,700', '287 units'],
        ['3. Wireless Headphones', 'RM 18,480', '231 units'],
        ['4. Gaming Mouse Pro', 'RM 15,840', '198 units'],
        ['5. 4K Monitor 27"', 'RM 16,730', '156 units']
      ];
      
      let yPos = 115;
      products.forEach(product => {
        doc.setTextColor(33, 37, 41);
        doc.text(product[0], 25, yPos);
        doc.text(product[1], 100, yPos);
        doc.text(product[2], 145, yPos);
        yPos += 8;
      });
      
      // Footer
      doc.setFontSize(8);
      doc.setTextColor(108, 117, 125);
      doc.text('Report generated automatically by Business Intelligence Dashboard', 20, 280);
      doc.text('For internal use only - Confidential', 20, 285);
      
      // Save PDF
      doc.save('Business-Dashboard-Report-' + new Date().toISOString().split('T')[0] + '.pdf');
      
      // Show success message
      alert('PDF Report generated successfully!');
    }

    window.onload = function() {
      // Calculate ROI on page load
      calculateROI();

      // Sales Trend Chart
      var ctx1 = document.getElementById("chart-sales-trend").getContext("2d");
      var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);
      gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
      gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)');

      new Chart(ctx1, {
        type: "line",
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"],
          datasets: [{
            label: "Sales (RM)",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 4,
            pointBackgroundColor: "#cb0c9f",
            borderColor: "#cb0c9f",
            borderWidth: 3,
            backgroundColor: gradientStroke1,
            fill: true,
            data: [85000, 92000, 88000, 105000, 98000, 112000, 108000, 118000, 115000, 125430],
            maxBarThickness: 6
          }],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                padding: 10,
                color: '#b2b9bf',
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
                callback: function(value) {
                  return 'RM ' + (value / 1000) + 'k';
                }
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
              },
              ticks: {
                display: true,
                color: '#b2b9bf',
                padding: 10,
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
          },
        },
      });

      // Comparison Chart (Bar)
      var ctx2 = document.getElementById("chart-comparison").getContext("2d");
      new Chart(ctx2, {
        type: "bar",
        data: {
          labels: ["This Month"],
          datasets: [{
            label: "Sales",
            backgroundColor: "#28a745",
            data: [125430],
            maxBarThickness: 60
          }, {
            label: "Expenses",
            backgroundColor: "#ffc107",
            data: [78250],
            maxBarThickness: 60
          }, {
            label: "Profit",
            backgroundColor: "#007bff",
            data: [47180],
            maxBarThickness: 60
          }],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: true,
              position: 'bottom'
            }
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                padding: 10,
                color: '#b2b9bf',
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
                callback: function(value) {
                  return 'RM ' + (value / 1000) + 'k';
                }
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false
              },
              ticks: {
                display: true,
                color: '#b2b9bf',
                padding: 10,
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
          },
        },
      });
    }
  </script>
@endpush