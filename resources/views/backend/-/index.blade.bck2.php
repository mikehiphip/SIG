@extends('backend.layouts.master')

@section('css')
<style>
    .box_graph{
        width: 1000px;
        max-width: 100%;
        margin: 0 auto;
    }
    .btn_year{
        text-align: center;
    }
    .btn_year a{
        display: inline-block;
        width: 70px;
    }

    @media (max-width 767px){
        .box_graph{
            width: 590px;
            max-width: 100%;
        }
    }
</style>
@endsection

@section('title') Dashboard @endsection

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Dashboard</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Welcome to Novimed Dashboard</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <!-- Left -->
        <div class="col-xl-6">  

            <!-- Col1 -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Daily Earning</h4>
                    <!--<h4 class="card-title mb-4">Daily Earning</h4>-->
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="text-muted">Revenue</p>
                            <h3>$34,252</h3>                            
                        </div>
                        <div class="col-sm-6">
                            <p class="text-muted">Average Price</p>
                            <h3>$16.2</h3>
                        </div>
                        <div class="col-sm-12">
                            <!--<div id="radialBar-chart" class="apex-charts"></div> -->
                            <div id="chart_div" class="box_graph"></div>                         
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mt-12 btn_year">
                                <a href="" class="btn btn-primary waves-effect waves-light btn-sm">Day </i></a>
                                <a href="" class="btn btn-primary waves-effect waves-light btn-sm">Week </a>
                                <a href="" class="btn btn-primary waves-effect waves-light btn-sm">Month </a>
                                <a href="" class="btn btn-primary waves-effect waves-light btn-sm">Year </a>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>

            <!--Treatment Sheet ESWL Record-->
            <div class="row">                
                <div class="col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">ESWL Record Revenue</p>
                                    <h4 class="mb-0">$35, 723</h4>
                                </div>
                                <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="bx bx-archive-in font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">ESWL Record Average Price</p>
                                    <h4 class="mb-0">$16.2</h4>
                                </div>
                                <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-right"></div>
                            <h4 class="card-title mb-4">ESWL Record</h4>        
                            <div>
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap">
                                        <thead class="thead-light">
                                            <tr>                                           
                                                <th>Order ID</th>
                                                <th>Billing Name</th>
                                                <th>Date</th>
                                                <th>Total</th>
                                                <th>Payment Status</th>
                                                <th>Payment Method</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>                                                
                                                <td><a href="javascript: void(0);" class="text-body font-weight-bold">#SK2540</a> </td>
                                                <td>Neal Matthews</td>
                                                <td>07 Oct, 2019</td>
                                                <td>$400</td>
                                                <td><span class="badge badge-pill badge-soft-success font-size-12">Paid</span></td>
                                                <td><i class="fab fa-cc-mastercard mr-1"></i> Mastercard</td>                                                
                                            </tr>
                                                                                       
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <!--Treatment Sheet Endourologic Record-->
            <div class="row">                
                <div class="col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Endourologic Record Revenue</p>
                                    <h4 class="mb-0">$35, 723</h4>
                                </div>
                                <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="bx bx-archive-in font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Endourologic Record Average Price</p>
                                    <h4 class="mb-0">$16.2</h4>
                                </div>
                                <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-right">
                                <ul class="nav nav-pills"></ul>
                            </div>
                            <h4 class="card-title mb-4">Endourologic Record</h4>        
                            <div>
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap">
                                        <thead class="thead-light">
                                            <tr>                                           
                                                <th>Order ID</th>
                                                <th>Billing Name</th>
                                                <th>Date</th>
                                                <th>Total</th>
                                                <th>Payment Status</th>
                                                <th>Payment Method</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>                                                
                                                <td><a href="javascript: void(0);" class="text-body font-weight-bold">#SK2540</a> </td>
                                                <td>Neal Matthews</td>
                                                <td>07 Oct, 2019</td>
                                                <td>$400</td>
                                                <td><span class="badge badge-pill badge-soft-success font-size-12">Paid</span></td>
                                                <td><i class="fab fa-cc-mastercard mr-1"></i> Mastercard</td>                                                
                                            </tr>
                                                                                      
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <!--Treatment Sheet Surgical Record-->
            <div class="row">                
                <div class="col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Surgical Record Revenue</p>
                                    <h4 class="mb-0">$35, 723</h4>
                                </div>
                                <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="bx bx-archive-in font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Surgical Record Average Price</p>
                                    <h4 class="mb-0">$16.2</h4>
                                </div>
                                <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-right">
                                <ul class="nav nav-pills"></ul>
                            </div>
                            <h4 class="card-title mb-4">Surgical Record</h4>        
                            <div>
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap">
                                        <thead class="thead-light">
                                            <tr>                                           
                                                <th>Order ID</th>
                                                <th>Billing Name</th>
                                                <th>Date</th>
                                                <th>Total</th>
                                                <th>Payment Status</th>
                                                <th>Payment Method</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>                                                
                                                <td><a href="javascript: void(0);" class="text-body font-weight-bold">#SK2540</a> </td>
                                                <td>Neal Matthews</td>
                                                <td>07 Oct, 2019</td>
                                                <td>$400</td>
                                                <td><span class="badge badge-pill badge-soft-success font-size-12">Paid</span></td>
                                                <td><i class="fab fa-cc-mastercard mr-1"></i> Mastercard</td>                                                
                                            </tr>

                                                                                      
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- Right -->
        <div class="col-xl-6">
             <!-- Col2 -->
            <div class="card">
                <div class="card-body">  
                    <h4 class="card-title mb-4">Master Data</h4>      

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Patient</p>
                                    <h4 class="mb-0">1,235</h4>
                                </div>
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                    <span class="avatar-title">
                                            <i class="bx bx-copy-alt font-size-24"></i>
                                        </span>
                                </div>
                            </div>
                        </div> 
                        <div class="col-sm-6">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Hospital</p>
                                    <h4 class="mb-0">1,235</h4>
                                </div>
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                    <span class="avatar-title">
                                            <i class="bx bx-copy-alt font-size-24"></i>
                                        </span>
                                </div>
                            </div>
                        </div>                        
                    </div>  
                    <br>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Medical Physician</p>
                                    <h4 class="mb-0">1,235</h4>
                                </div>
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                    <span class="avatar-title">
                                            <i class="bx bx-copy-alt font-size-24"></i>
                                        </span>
                                </div>
                            </div>
                        </div> 
                        <div class="col-sm-6">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Medical Radiographer</p>
                                    <h4 class="mb-0">1,235</h4>
                                </div>
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                    <span class="avatar-title">
                                        <i class="bx bx-copy-alt font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <br>                  

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Medical Assistant</p>
                                    <h4 class="mb-0">1,235</h4>
                                </div>

                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                    <span class="avatar-title">
                                        <i class="bx bx-copy-alt font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <br>                    
                </div>
            </div>
            <!-- Col3 -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">                           
                            <div class="float-right"></div>
                            <h4 class="card-title mb-4">Report Top Ten</h4>
                            <!-- end table-responsive -->                            
                        </div>                   
                    </div>  
                    <br>

                    <div class="row">
                        <div class="col-md-12">                           
                            <div class="float-right"></div>
                            <h4 class="card-title mb-4">Physician</h4>  
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap">
                                    <thead class="thead-light">
                                        <tr>                                           
                                            <th>Order ID</th>
                                            <th>Billing Name</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Payment Status</th>
                                            <th>Payment Method</th>                                                
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>                                                
                                            <td><a href="javascript: void(0);" class="text-body font-weight-bold">#SK2540</a> </td>
                                            <td>Neal Matthews</td>
                                            <td>07 Oct, 2019</td>
                                            <td>$400</td>
                                            <td><span class="badge badge-pill badge-soft-success font-size-12">Paid</span></td>
                                            <td><i class="fab fa-cc-mastercard mr-1"></i> Mastercard</td>                                                
                                        </tr>

                                                                                 
                                    </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->                            
                        </div>                   
                    </div>  
                    <br>                                  

                    <div class="row">
                        <div class="col-md-12">                           
                            <div class="float-right"></div>
                            <h4 class="card-title mb-4">Hospital</h4>  
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap">
                                    <thead class="thead-light">
                                        <tr>                                           
                                            <th>Order ID</th>
                                            <th>Billing Name</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Payment Status</th>
                                            <th>Payment Method</th>                                                
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>                                                
                                            <td><a href="javascript: void(0);" class="text-body font-weight-bold">#SK2540</a> </td>
                                            <td>Neal Matthews</td>
                                            <td>07 Oct, 2019</td>
                                            <td>$400</td>
                                            <td><span class="badge badge-pill badge-soft-success font-size-12">Paid</span></td>
                                            <td><i class="fab fa-cc-mastercard mr-1"></i> Mastercard</td>                                                
                                        </tr>
                                                                                
                                    </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->                            
                        </div>                      
                    </div>
                    <br>
                    
                    <div class="row">
                        <div class="col-md-12">                           
                            <div class="float-right"></div>
                            <h4 class="card-title mb-4">Radiographer</h4>  
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap">
                                    <thead class="thead-light">
                                        <tr>                                           
                                            <th>Order ID</th>
                                            <th>Billing Name</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Payment Status</th>
                                            <th>Payment Method</th>                                                
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <tr>                                                
                                            <td><a href="javascript: void(0);" class="text-body font-weight-bold">#SK2540</a> </td>
                                            <td>Neal Matthews</td>
                                            <td>07 Oct, 2019</td>
                                            <td>$400</td>
                                            <td><span class="badge badge-pill badge-soft-success font-size-12">Paid</span></td>
                                            <td><i class="fab fa-cc-mastercard mr-1"></i> Mastercard</td>                                                
                                        </tr>
                                                                                 
                                    </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->                            
                        </div>                      
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
    
    <!-- end row -->
@endsection

@section('script') 

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        /*1*/
        items = ['100', '55', "60"];     // 1 ส่งค่า โดย PHP
        items_persent   = [];
        items_total     = 0;  
        items_avg       = 0; 

        /*2*/
        f_graph_pie_config(items);              // 2

        function f_graph_pie_config(obj){
            items_persent = f_graph_pie_persent(obj); 
            items_avg = f_items_avg(obj); 
            /* ทำให้ส่ง id Average Price */           
            items_total = f_items_total(obj);
            /* ทำให้ส่ง id Revenue */
        }        

        function f_graph_pie_persent(obj_array1){
            var obj_total = 0;
            var obj_persent = [];
            $.each( obj_array1, function( key, value ) {
                obj_total += parseFloat(value);         
            });
            $.each( obj_array1, function( key, value ) {        
                obj_persent[key] = (value*100)/obj_total;    
                obj_persent[key] = obj_persent[key].toFixed(2);     
            });  
            return obj_persent;  
        }
        function f_items_total(obj_array1){
            var obj_total = 0;   
            $.each( obj_array1, function( key, value ) {
                obj_total += parseFloat(value);         
            });    
            return obj_total.toFixed(2);
        }
        function f_items_avg(obj_array1){
            var obj_total = 0;
            var obj_length = 0;
            var obj_avg = 0;
            $.each( obj_array1, function( key, value ) {
                obj_total += parseFloat(value);         
            });
            obj_length = obj_array1.length;
            obj_avg = obj_total/obj_length;
            return obj_avg.toFixed(2);
        }

    /*----------------------------------------------------------------------------------------------------*/

        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages':['corechart']});
    
        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart);
    
        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChart() {                 

            var eswl = parseFloat(items_persent[0]);
            var endo = parseFloat(items_persent[1]);
            var surg = parseFloat(items_persent[2]);
           
            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');
            data.addRows([
                ['ESWL Record', eswl],
                ['Endourologic Record', endo],
                ['Surgical Record', surg],
            ]);
    
            // Set chart options
            var options = {
                'title' : 'Treatment Sheet',
                'pieSliceTextStyle': {
                    color: 'white',
                },  
                tooltip: { trigger: 'none' },
                /*
                slices: {
                    0: { color: 'yellow' },
                    1: { color: 'green' },
                    2: { color: 'blue' }
                } 
                */            
            };
    
            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
@endsection