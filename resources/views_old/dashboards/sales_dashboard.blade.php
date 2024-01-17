@extends('layouts.master')

@section('content')
      <div class="az-content-body">
          <h2 class="az-content-title tx-24 mg-b-5" style="float: right !important;">My Jobs: <span style="color:green">0</span></h2>
            <h1><span style="font-weight:bold;">Sales Dashboard</span></h1>
            <h2 class="az-content-title tx-24 mg-b-5">Welcome! <span>{{ auth()->user()->name }}</span></h2>
            <br>
        <div class="row row-sm">
          <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="card card-body card-dashboard-fifteen">
              <h1>0</h1>
              <label class="tx-purple">OPEN CASES</label>
              <div class="chart-wrapper">
                <div id="flotChart1" class="flot-chart"></div>
              </div><!-- chart-wrapper -->
            </div><!-- card -->
          </div><!-- col -->
          <div class="col-sm-6 col-lg-4 col-xl-3 mg-t-20 mg-sm-t-0">
            <div class="card card-body card-dashboard-fifteen">
              <h1>0</h1>
              <label class="tx-primary">IN-PROGRESS CASES</label>
              <div class="chart-wrapper">
                <div id="flotChart2" class="flot-chart"></div>
              </div><!-- chart-wrapper -->
            </div><!-- card -->
          </div><!-- col -->
          <div class="col-sm-6 col-lg-4 col-xl-3 mg-t-20 mg-sm-t-20 mg-lg-t-0">
            <div class="card card-body card-dashboard-fifteen">
              <h1>0</h1>
              <label class="tx-teal">QUOTATIONS APPROVAL</label>
              <div class="chart-wrapper">
                <div id="flotChart3" class="flot-chart"></div>
              </div><!-- chart-wrapper -->
            </div><!-- card -->
          </div><!-- col -->
          <div class="col-sm-6 col-lg-12 col-xl-3 mg-t-20 mg-xl-t-0">
            <div class="d-lg-flex d-xl-block">
              <div class="card wd-lg-50p wd-xl-auto">
                <div class="card-header">
                  <h6 class="card-title tx-14 mg-b-0">My Escalations</h6>
                </div><!-- card-header -->
                <div class="card-body">
                  <h3 class="tx-bold tx-inverse lh--5 mg-b-15">0 <span class="tx-base tx-normal tx-gray-600">/ Out of: 0</span></h3>
                  <div class="progress mg-b-0 ht-3">
                    <div class="progress-bar wd-85p bg-purple" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div><!-- card-body -->
              </div><!-- card -->
              <div class="card mg-t-20 mg-lg-t-0 mg-xl-t-20 mg-lg-l-20 mg-xl-l-0">
                <div class="card-header">
                  <h6 class="card-title tx-14 mg-b-5">My Team Jobs</h6>
                </div><!-- card-header -->
                <div class="card-body">
                  <h2 class="tx-bold tx-inverse lh--5 mg-b-5">0</h2>
                </div><!-- card-body -->
              </div><!-- card -->
            </div>
          </div><!-- col-3 -->
          <div class="col-xl-6 mg-t-15 mg-t-20">
            <div class="card">
              <div class="card-header">
                <h6 class="card-title tx-14 mg-b-5">My Profile (Monthly Chart)</h6>
                </div><!-- card-header -->
              <div class="card-body row pd-25">
                <div class="col-sm-8 col-md-7">
                  <div id="flotPie" class="wd-100p ht-200"></div>
                </div><!-- col -->
                <div class="col-sm-4 col-md-5 mg-t-30 mg-sm-t-0">
                  <ul class="list-unstyled">
                    <li class="d-flex align-items-center"><span class="d-inline-block wd-10 ht-10 bg-black mg-r-10"></span> Pending Cases (0%)</li>
                    <li class="d-flex align-items-center mg-t-5"><span class="d-inline-block wd-10 ht-10 bg-warning mg-r-10"></span> In-Progress Cases (0%)</li>
                    <li class="d-flex align-items-center mg-t-5"><span class="d-inline-block wd-10 ht-10 bg-teal mg-r-10"></span> Completed Cases(0%)</li>
                    <li class="d-flex align-items-center mg-t-5"><span class="d-inline-block wd-10 ht-10 bg-danger mg-r-10"></span> Canceled Cases(0%)</li>
                    <li class="d-flex align-items-center mg-t-5"><span class="d-inline-block wd-10 ht-10 bg-indigo mg-r-10"></span> Approvals (0%)</li>
                    <li class="d-flex align-items-center mg-t-5"><span class="d-inline-block wd-10 ht-10 bg-info mg-r-10"></span> Issuance (0%)</li>
                  </ul>
                </div><!-- col -->
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col -->
          <div class="col-gl-5 col-xl-6 mg-t-20">
            <div class="card">
              <div class="card-header">
                <h6 class="card-title tx-14 mg-b-5">Lead Ageing List</h6>
                </div><!-- card-header -->
              <div class="table-responsive mg-t-15">
                <table class="table table-striped table-talk-time">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Customer</th>
                      <th>Status</th>
                      <th>Days / Hours</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>21</td>
                      <td>Hassan</td>
                      <td><span><badge class='badge badge-success'>Confirmed</badge> <badge class='badge badge-primary'>Pending Issuance</badge></span></td>
                      <td>7 / 20 HRS</td>
                    </tr>
                    <tr>
                      <td>22</td>
                      <td>Ali</td>
                      <td><span><badge class='badge badge-warning'>In-Progress</badge></span></td>
                      <td>5 / 5 HRS</td>
                    </tr>
                    <tr>
                      <td>23</td>
                      <td>Shahzaib</td>
                      <td><span><badge class='badge badge-danger'>Escalation</badge></span></td>
                      <td>4 / 12 HRS</td>
                    </tr>
                    <tr>
                      <td>24</td>
                      <td>Kaab</td>
                      <td><span><badge class='badge badge-danger'>In-Progress</badge></span></td>
                      <td>2 / 6 HRS</td>
                    </tr>
                    <tr>
                      <td>25</td>
                      <td>Maaz</td>
                      <td><span><badge class='badge badge-success'>Confirmed</badge> <badge class='badge badge-primary'>Pedning Issuance</badge></span></td>
                      <td>2 / 3 HRS</td>
                    </tr>
                    <tr>
                      <td>25</td>
                      <td>Talha</td>
                      <td><span><badge class='badge badge-info'>Open</badge></span></td>
                      <td>1 / 5 HRS</td>
                    </tr>
                  </tbody>
                </table>
              </div><!-- table-responsive -->
            </div><!-- card -->
          </div><!-- col -->
        </div><!-- row -->
      </div><!-- az-content-body -->
    @endsection
    @push('scripts')
       <script>
      $(function(){
        'use strict'

        $('.az-sidebar .with-sub').on('click', function(e){
          e.preventDefault();
          $(this).parent().toggleClass('show');
          $(this).parent().siblings().removeClass('show');
        })

        $(document).on('click touchstart', function(e){
          e.stopPropagation();

          // closing of sidebar menu when clicking outside of it
          if(!$(e.target).closest('.az-header-menu-icon').length) {
            var sidebarTarg = $(e.target).closest('.az-sidebar').length;
            if(!sidebarTarg) {
              $('body').removeClass('az-sidebar-show');
            }
          }
        });


        $('#azSidebarToggle').on('click', function(e){
          e.preventDefault();

          if(window.matchMedia('(min-width: 992px)').matches) {
            $('.az-sidebar').toggle();
          } else {
            $('body').toggleClass('az-sidebar-show');
          }
        })

        /* ----------------------------------- */
        /* Dashboard content */

        $.plot('#flotChart1', [{
            data: flotSampleData5,
            color: '#8039f4'
          }], {
    			series: {
    				shadowSize: 0,
            lines: {
              show: true,
              lineWidth: 2,
              fill: true,
              fillColor: { colors: [ { opacity: 0 }, { opacity: 0.12 } ] }
            }
    			},
          grid: {
            borderWidth: 0,
            labelMargin: 10,
            markings: [{ color: '#70737c', lineWidth: 1, font: {color: '#000'}, xaxis: { from: 75, to: 75} }]
          },
    			yaxis: { show: false },
    			xaxis: {
            show: true,
            position: 'top',
            color: 'rgba(102,16,242,.1)',
            reserveSpace: false,
            ticks: [[15,'1h'],[35,'1d'],[55,'1w'],[75,'1m'],[95,'3m'], [115,'1y']],
            font: {
              size: 10,
              weight: '500',
              family: 'Roboto, sans-serif',
              color: '#999'
            }
          }
    		});

        $.plot('#flotChart2', [{
            data: flotSampleData2,
            color: '#007bff'
          }], {
    			series: {
    				shadowSize: 0,
            lines: {
              show: true,
              lineWidth: 2,
              fill: true,
              fillColor: { colors: [ { opacity: 0 }, { opacity: 0.5 } ] }
            }
    			},
          grid: {
            borderWidth: 0,
            labelMargin: 10,
            markings: [{ color: '#70737c', lineWidth: 1, font: {color: '#000'}, xaxis: { from: 75, to: 75} }]
          },
    			yaxis: { show: false },
    			xaxis: {
            show: true,
            position: 'top',
            color: 'rgba(102,16,242,.1)',
            reserveSpace: false,
            ticks: [[15,'1h'],[35,'1d'],[55,'1w'],[75,'1m'],[95,'3m'], [115,'1y']],
            font: {
              size: 10,
              weight: '500',
              family: 'Roboto, sans-serif',
              color: '#999'
            }
          }
    		});

        $.plot('#flotChart3', [{
            data: flotSampleData5,
            color: '#00cccc'
          }], {
    			series: {
    				shadowSize: 0,
            lines: {
              show: true,
              lineWidth: 2,
              fill: true,
              fillColor: { colors: [ { opacity: 0.2 }, { opacity: 0.5 } ] }
            }
    			},
          grid: {
            borderWidth: 0,
            labelMargin: 10,
            markings: [{ color: '#70737c', lineWidth: 1, font: {color: '#000'}, xaxis: { from: 75, to: 75} }]
          },
    			yaxis: { show: false },
    			xaxis: {
            show: true,
            position: 'top',
            color: 'rgba(102,16,242,.1)',
            reserveSpace: false,
            ticks: [[15,'1h'],[35,'1d'],[55,'1w'],[75,'1m'],[95,'3m'], [115,'1y']],
            font: {
              size: 10,
              weight: '500',
              family: 'Roboto, sans-serif',
              color: '#999'
            }
          }
    		});

        $.plot('#flotPie', [
          { label: 'Very Satisfied', data: [[1,25]], color: '#6f42c1'},
          { label: 'Satisfied', data: [[1,38]], color: '#007bff'},
          { label: 'Not Satisfied', data: [[1,20]], color: '#00cccc'},
          { label: 'Very Unsatisfied', data: [[1,15]], color: '#969dab'}
        ], {
          series: {
            pie: {
              show: true,
              radius: 1,
              innerRadius: 0.5,
              label: {
                show: true,
                radius: 3/4,
                formatter: labelFormatter
              }
            }
          },
          legend: { show: false }
        });

        function labelFormatter(label, series) {
          return '<div style="font-size:11px; font-weight:500; text-align:center; padding:2px; color:white;">' + Math.round(series.percent) + '%</div>';
        }

        var ctx6 = document.getElementById('chartStacked1');
        new Chart(ctx6, {
          type: 'bar',
          data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
              data: [10, 24, 20, 25, 35, 50, 20, 30, 28, 33, 45, 65],
              backgroundColor: '#6610f2',
              borderWidth: 1,
              fill: true
            },{
              data: [20, 30, 28, 33, 45, 65, 25, 35, 50, 20, 30, 28],
              backgroundColor: '#00cccc',
              borderWidth: 1,
              fill: true
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
                ticks: {
                  beginAtZero:true,
                  fontSize: 11
                }
              }],
              xAxes: [{
                barPercentage: 0.4,
                ticks: {
                  fontSize: 11
                }
              }]
            }
          }
        });
      });
    </script>
    @endpush

