@extends('layouts.master')

@section('content')
    <div class="az-content-body">
        <div class="az-content-body-left">
            <h2 class="az-content-title tx-24 mg-b-5" style="float: right !important;">Today's Jobs: <span style="color:green">5</span></h2>
            <h1><span style="font-weight:bold;">Accounts Dashboard</span></h1>
            <h2 class="az-content-title tx-24 mg-b-5">Welcome! <span>{{ auth()->user()->name }}</span></h2>
            
            <br>
            <div class="row row-sm mg-b-20">
          <div class="col-lg-8">
            <div class="row row-xs row-sm--sm">
              <div class="col-sm-6 col-md-4">
                <div class="card card-dashboard-seventeen">
                  <div class="card-body">
                    <h6 class="card-title">Quotations Summary</h6>
                    <div>
                      <h4>THIS WEEK: {{ $quotation_count }}</h4>
                      <span>TODAY: {{$quotation_today_count}}</span>
                    </div>
                  </div>
                  <div class="chart-wrapper">
                    <div id="flotChart1" class="flot-chart"></div>
                  </div><!-- chart-wrapper -->
                </div>
              </div><!-- col -->
              <div class="col-sm-6 col-md-4 mg-t-20 mg-sm-t-0">
                <div class="card card-dashboard-seventeen">
                  <div class="card-body">
                    <h6 class="card-title">Total Income Today</h6>
                    <div>
                      <h4>{{ $today_amount }}</h4>
                    </div>
                  </div><!-- card-body -->
                  <div class="chart-wrapper">
                    <div id="flotChart2" class="flot-chart"></div>
                  </div><!-- chart-wrapper -->
                </div><!-- card -->
              </div><!-- col -->
              <div class="col-sm-6 col-md-4 mg-t-20 mg-md-t-0">
                <div class="card card-dashboard-seventeen bg-primary-dark tx-white">
                  <div class="card-body">
                    <h6 class="card-title">Total Dues Today</h6>
                    <div>
                      <h4 class="text-white">{{ $total_today_due }}</h4>
                    </div>
                  </div><!-- card-body -->
                  <div class="chart-wrapper">
                    <div id="flotChart3" class="flot-chart"></div>
                  </div><!-- chart-wrapper -->
                </div><!-- card -->
              </div><!-- col -->
              <div class="col-12 mg-t-20">
                <div class="card card-dashboard-nineteen">
                  <div class="card-header">
                    <h6 class="card-title">Account &amp; Monthly Recurring Revenue Growth</h6>
                    <div class="row">
                      <div class="col-6 col-md-5">
                        <h4>0</h4>
                        <label class="az-content-label">MRR Growth</label>
                        <p>Measure How Fast You’re Growing Monthly Recurring Revenue. <a href="">Learn More</a></p>
                      </div><!-- col -->
                      <div class="col-6 col-md-5">
                        <h4>0</h4>
                        <label class="az-content-label">Avg. MRR/Customer</label>
                        <p>The revenue generated per account on a monthly or yearly basis.  <a href="">Learn More</a></p>
                      </div><!-- col -->
                    </div><!-- row -->
                    <div class="chart-legend">
                      <div>Growth Actual</div>
                      <div>Actual</div>
                      <div>Plan</div>
                    </div>
                  </div><!-- card-header -->
                  <div class="card-body">
                    <div class="flot-chart-wrapper">
                      <div id="flotChart" class="flot-chart"></div>
                    </div><!-- flot-chart-wrapper -->
                  </div><!-- card-body -->
                </div><!-- card -->
              </div><!-- col -->
            </div><!-- row -->
          </div><!-- col -->
          <div class="col-lg-4 mg-t-20 mg-lg-t-0">
            <div class="card card-dashboard-eighteen">
              <h6 class="card-title mg-b-5">Monitoring</h6>
              <p class="tx-gray-500 mg-b-0"><?php echo date('d-m-Y', strtotime(now()))?></p>
              <div class="card-body row row-xs">
                <div class="col-6">
                  <h6 class="dot-primary">{{ $today_amount }}/=</h6>
                  <label>Total Income Today</label>
                </div><!-- col -->
                <div class="col-6">
                  <h6 class="dot-purple">0</h6>
                  <label>Pending Vouchers</label>
                </div><!-- col -->
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col -->
          
          <div class="col-lg-12 mg-t-20">
            <div class="row row-sm">
              <div class="col-sm-6">
                <div class="card card-dashboard-twenty">
                  <div class="card-body">
                    <label class="az-content-label tx-13 tx-primary">Umrah Invoices</label>
                    <div class="expansion-value">
                      <strong>0</strong>
                      <strong>100</strong>
                    </div>
                    <div class="progress">
                      <div class="progress-bar wd-70p" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="expansion-label">
                      <span>This Month</span>
                      <span>Previous Month</span>
                    </div>
                  </div>
                </div><!-- card -->
              </div><!-- col -->
              <div class="col-sm-6 mg-t-20 mg-sm-t-0">
                <div class="card card-dashboard-twenty ht-md-100p">
                  <div class="card-body">
                    <label class="az-content-label tx-13 tx-danger">International Invoices</label>
                    <div class="expansion-value">
                      <strong>0</strong>
                      <strong>100</strong>
                    </div>
                    <div class="progress">
                      <div class="progress-bar wd-50p bg-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="expansion-label">
                      <span>This Month</span>
                      <span>Previous Month</span>
                    </div>
                  </div>
                </div><!-- card -->
              </div><!-- col -->
              <div class="col mg-t-20">
                <div class="card card-dashboard-progress">
                  <div class="card-body">
                    <div class="d-sm-flex justify-content-between mg-b-20">
                      <label class="az-content-label tx-13 mg-b-10 mg-sm-b-0">MRR (September)</label>
                      <ul class="progress-legend">
                        <li>Expansion</li>
                        <li>New</li>
                      </ul>
                    </div>
                    <div class="media">
                      <label>None:</label>
                      <div class="media-body">
                        <div id="progressBar1" class="progress">
                          <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                          <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div><!-- progress -->
                      </div><!-- media-body -->
                    </div><!-- media -->
                    <div class="media">
                      <label>Partner:</label>
                      <div class="media-body">
                        <div id="progressBar2" class="progress">
                          <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                          <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div><!-- progress -->
                      </div><!-- media-body -->
                    </div><!-- media -->
                  </div><!-- card-body -->
                </div><!-- card -->
              </div><!-- col -->
            </div><!-- row -->
          </div><!-- col -->
        </div><!-- row -->
            <!-- card -->


            <!-- row -->
        </div>
    </div><!-- az-content-body -->
@endsection
@push('scripts')
<script>
      $(function(){
        'use strict'

        var plot = $.plot('#flotChart', [{
          data: flotSampleData10,
          color: '#80bdff',
          lines: {
            fillColor: { colors: [{ opacity: .6 }, { opacity: .4 }]}
          }
        },{
          data: flotSampleData4,
          color: '#007bff',
          lines: {
            fillColor: { colors: [{ opacity: .8 }, { opacity: .6 }]}
          }
        },{
          data: flotSampleData11,
          color: '#003d80',
          lines: {
            fillColor: { colors: [{ opacity: .9 }, { opacity: .7 }]}
          }
        }], {
    			series: {
    				shadowSize: 0,
            lines: {
              show: true,
              lineWidth: 0,
              fill: true
            }
    			},
          grid: {
            borderWidth: 0,
            aboveData: true
          },
    			yaxis: {
            show: true,
    				min: 0,
    				max: 150,
            color: 'rgba(255,255,255,0.2)',
            ticks: [[0,''],[25,'$25,000'],[50,'$50,000'],[75,'$75,000'],[100,'$100,000']]
    			},
    			xaxis: {
            show: true,
            ticks: [[0,''],[8,'Jan'],[20,'Feb'],[32,'Mar'],[44,'Apr'],[56,'May'],[68,'Jun'],[80,'Jul'],[92,'Aug'],[104,'Sep'],[116,'Oct'],[128,'Nov'],[140,'Dec']],
            color: 'rgba(255,255,255,0.2)'
          }
        });

        $.plot('#flotChart1', [{
            data: flotSampleData6,
            color: '#70737c'
          }], {
    			series: {
    				shadowSize: 0,
            lines: {
              show: true,
              lineWidth: 2,
              fill: true,
              fillColor: { colors: [ { opacity: 0 }, { opacity: 0.1 } ] }
            }
    			},
          grid: {
            borderWidth: 0,
            labelMargin: 0
          },
    			yaxis: {
            show: false,
            min: 0,
            max: 120
          },
    			xaxis: { show: false }
    		});

        $.plot('#flotChart2', [{
            data: flotSampleData7,
            color: '#007bff'
          }], {
    			series: {
    				shadowSize: 0,
            lines: {
              show: true,
              lineWidth: 2,
              fill: true,
              fillColor: { colors: [ { opacity: 0 }, { opacity: 0.2 } ] }
            }
    			},
          grid: {
            borderWidth: 0,
            labelMargin: 0
          },
    			yaxis: {
            show: false,
            min: 0,
            max: 120
          },
    			xaxis: { show: false }
    		});

        $.plot('#flotChart3', [{
            data: flotSampleData8,
            color: '#fff'
          }], {
    			series: {
    				shadowSize: 0,
            lines: {
              show: true,
              lineWidth: 2,
              fill: true,
              fillColor: { colors: [ { opacity: 0 }, { opacity: 0.2 } ] }
            }
    			},
          grid: {
            borderWidth: 0,
            labelMargin: 0
          },
    			yaxis: {
            show: false,
            min: 0,
            max: 120
          },
    			xaxis: { show: false }
    		});

        $.plot('#flotChart4', [{
            data: flotSampleData9,
            color: '#fff'
          }], {
    			series: {
    				shadowSize: 0,
            lines: {
              show: true,
              lineWidth: 2,
              fill: true,
              fillColor: { colors: [ { opacity: 0 }, { opacity: 0.2 } ] }
            }
    			},
          grid: {
            borderWidth: 0,
            labelMargin: 0
          },
    			yaxis: {
            show: false,
            min: 0,
            max: 120
          },
    			xaxis: { show: false }
    		});

        var ctx5 = document.getElementById('chartBar5').getContext('2d');
        new Chart(ctx5, {
          type: 'horizontalBar',
          data: {
            labels: ['Jul', 'Aug', 'Sep'],
            datasets: [{
              data: [12, 39, 20],
              backgroundColor: '#007bff'
            }, {
              data: [22, 30, 25],
              backgroundColor: '#6f42c1'
            },{
              data: [40, 30, 35],
              backgroundColor: '#00cccc'
            },{
              data: [25, 40, 25],
              backgroundColor: '#004a99'
            }]
          },
          options: {
            maintainAspectRatio: false,
            legend: {
              display: false,
                labels: {
                  display: false
                }
            },
            scales: {
              yAxes: [{
                barPercentage: 0.75,
                ticks: {
                  beginAtZero:true,
                  fontSize: 11,
                }
              }],
              xAxes: [{
                ticks: {
                  beginAtZero:true,
                  fontSize: 11,
                  max: 80
                }
              }]
            }
          }
        });

        var ctx6 = document.getElementById('chartBar6').getContext('2d');
        new Chart(ctx6, {
          type: 'bar',
          data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
              data: [150,110,90,115,125,160,160,140,100,110,120,120],
              backgroundColor: '#2b91fe'
            },{
              data: [180,140,120,135,155,170,180,150,140,150,130,130],
              backgroundColor: '#054790'
            }]
          },
          options: {
            maintainAspectRatio: false,
            legend: {
              display: false,
                labels: {
                  display: false
                }
            },
            scales: {
              xAxes: [{
                //stacked: true,
                display: false,
                barPercentage: 0.5,
                ticks: {
                  beginAtZero:true,
                  fontSize: 11
                }
              }],
              yAxes: [{
                ticks: {
                  fontSize: 10,
                  color: '#eee',
                  min: 80,
                  max: 200
                }
              }]
            }
          }
        });

        // Progress
        var prog1 = $('#progressBar1 .progress-bar:first-child');
        prog1.css('width','30%');
        prog1.attr('aria-valuenow','30');
        prog1.text('30%');

        var prog2 = $('#progressBar1 .progress-bar:last-child');
        prog2.css('width','53%');
        prog2.attr('aria-valuenow', '53');
        prog2.text('53%');

        // Progress
        var prog3 = $('#progressBar2 .progress-bar:first-child');
        prog3.css('width','35%');
        prog3.attr('aria-valuenow','35');
        prog3.text('35%');

        var prog4 = $('#progressBar2 .progress-bar:last-child');
        prog4.css('width','37%');
        prog4.attr('aria-valuenow', '37');
        prog4.text('37%');

      });
    </script>
@endpush
