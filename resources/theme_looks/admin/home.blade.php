 @extends('layouts.admin')

 @section('title', 'Dashboard')
 @section('page-headder')
 {{-- Categories --}}
 @endsection
 @section('content')
 <div class="row">

     <div class="col-lg-3 col-6">
         <div class="info-box bg-white">
             <span class="info-box-icon"><i class="far fa-bookmark"></i></span>

             <div class="info-box-content">
                 <span class="info-box-text">Bookmarks</span>
                 <span class="info-box-number">41,410</span>

                 <div class="progress">
                     <div class="progress-bar" style="width: 70%"></div>
                 </div>
                 <span class="progress-description">
                     70% Increase in 30 Days
                 </span>
             </div>
             <!-- /.info-box-content -->
         </div>
         <!-- /.info-box -->
     </div>
     <!-- /.col -->
     <div class="col-lg-3 col-6">
         <div class="info-box bg-white">
             <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>

             <div class="info-box-content">
                 <span class="info-box-text">Likes</span>
                 <span class="info-box-number">41,410</span>

                 <div class="progress">
                     <div class="progress-bar" style="width: 70%"></div>
                 </div>
                 <span class="progress-description">
                     70% Increase in 30 Days
                 </span>
             </div>
             <!-- /.info-box-content -->
         </div>
         <!-- /.info-box -->
     </div>
     <!-- /.col -->
     <div class="col-lg-3 col-6">
         <div class="info-box bg-white">
             <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>

             <div class="info-box-content">
                 <span class="info-box-text">Events</span>
                 <span class="info-box-number">41,410</span>

                 <div class="progress">
                     <div class="progress-bar" style="width: 70%"></div>
                 </div>
                 <span class="progress-description">
                     70% Increase in 30 Days
                 </span>
             </div>
             <!-- /.info-box-content -->
         </div>
         <!-- /.info-box -->
     </div>
     <!-- /.col -->
     <div class="col-lg-3 col-6">
         <div class="info-box bg-white">
             <span class="info-box-icon"><i class="fas fa-comments"></i></span>

             <div class="info-box-content">
                 <span class="info-box-text">Comments</span>
                 <span class="info-box-number">41,410</span>

                 <div class="progress">
                     <div class="progress-bar" style="width: 70%"></div>
                 </div>
                 <span class="progress-description">
                     70% Increase in 30 Days
                 </span>
             </div>
             <!-- /.info-box-content -->
         </div>
         <!-- /.info-box -->
     </div>
     <!-- /.col -->

     <div class="col-lg-3 col-6">
         <!-- small box -->
         <div class="small-box bg-white">
             <div class="inner">
                 <h3>150</h3>

                 <p>New Orders</p>
             </div>
             <div class="icon">
                 <i class="ion ion-bag"></i>
             </div>
             <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
         </div>
     </div>
     <!-- ./col -->
     <div class="col-lg-3 col-6">
         <!-- small box -->
         <div class="small-box bg-white">
             <div class="inner">
                 <h3>53<sup style="font-size: 20px">%</sup></h3>

                 <p>Bounce Rate</p>
             </div>
             <div class="icon">
                 <i class="ion ion-stats-bars"></i>
             </div>
             <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
         </div>
     </div>
     <!-- ./col -->
     <div class="col-lg-3 col-6">
         <!-- small box -->
         <div class="small-box bg-white">
             <div class="inner">
                 <h3>44</h3>

                 <p>User Registrations</p>
             </div>
             <div class="icon">
                 <i class="ion ion-person-add"></i>
             </div>
             <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
         </div>
     </div>
     <!-- ./col -->
     <div class="col-lg-3 col-6">
         <!-- small box -->
         <div class="small-box bg-white">
             <div class="inner">
                 <h3>65</h3>

                 <p>Unique Visitors</p>
             </div>
             <div class="icon">
                 <i class="ion ion-pie-graph"></i>
             </div>
             <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
         </div>
     </div>
     <!-- ./col -->
 </div>
 <!-- /.row -->
 <!-- Main row -->
 <div class="row">
     <!-- Left col -->
     <section class="col-lg-6 connectedSortable">



         <div class="card">
             <div class="card-header border-0">
                 <div class="d-flex justify-content-between">
                     <h3 class="card-title">Online Store Visitors</h3>
                     <a href="javascript:void(0);">View Report</a>
                 </div>
             </div>
             <div class="card-body">
                 <div class="d-flex">
                     <p class="d-flex flex-column">
                         <span class="text-bold text-lg">820</span>
                         <span>Visitors Over Time</span>
                     </p>
                     <p class="ml-auto d-flex flex-column text-right">
                         <span class="text-success">
                             <i class="fas fa-arrow-up"></i> 12.5%
                         </span>
                         <span class="text-muted">Since last week</span>
                     </p>
                 </div>
                 <!-- /.d-flex -->

                 <div class="position-relative mb-4">
                     <canvas id="visitors-chart" height="200"></canvas>
                 </div>

                 <div class="d-flex flex-row justify-content-end">
                     <span class="mr-2">
                         <i class="fas fa-square text-primary"></i> This Week
                     </span>

                     <span>
                         <i class="fas fa-square text-gray"></i> Last Week
                     </span>
                 </div>
             </div>
         </div>
         <!-- /.card -->



     </section>
     <!-- /.Left col -->
     <!-- right col (We are only adding the ID to make the widgets sortable)-->
     <section class="col-lg-6 connectedSortable">
         <!-- /.col-md-6 -->
         <div class="card">
             <div class="card-header border-0">
                 <div class="d-flex justify-content-between">
                     <h3 class="card-title">Sales</h3>
                     <a href="javascript:void(0);">View Report</a>
                 </div>
             </div>
             <div class="card-body">
                 <div class="d-flex">
                     <p class="d-flex flex-column">
                         <span class="text-bold text-lg">$18,230.00</span>
                         <span>Sales Over Time</span>
                     </p>
                     <p class="ml-auto d-flex flex-column text-right">
                         <span class="text-success">
                             <i class="fas fa-arrow-up"></i> 33.1%
                         </span>
                         <span class="text-muted">Since last month</span>
                     </p>
                 </div>
                 <!-- /.d-flex -->

                 <div class="position-relative mb-4">
                     <canvas id="sales-chart" height="200"></canvas>
                 </div>

                 <div class="d-flex flex-row justify-content-end">
                     <span class="mr-2">
                         <i class="fas fa-square text-primary"></i> This year
                     </span>

                     <span>
                         <i class="fas fa-square text-gray"></i> Last year
                     </span>
                 </div>
             </div>
         </div>


     </section>
     <!-- right col -->
 </div>
 <!-- /.row (main row) -->
 @endsection


 @push('.js')

 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 <!-- ChartJS -->
 <script src="{{ asset('backend/plugins/chart.js/Chart.min.js') }}"></script>
 <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
 <script src="{{ asset('backend/dist/js/pages/dashboard.js') }}"></script>
 <script src="{{ asset('backend/dist/js/pages/dashboard3.js') }}"></script>
 @endpush
