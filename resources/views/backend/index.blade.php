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
                        <li class="breadcrumb-item active">Welcome to SIG Dashboard</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
   
   <div class="row">
        
        <!-- Master Data -->
        <div class="col-xl-12">
             <!-- Col2 -->
            <div class="card">
                <div class="card-body">  
                    <h4 class="card-title mb-4">Master Data</h4>      

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">จำนวนพนักงานทั้งหมด</p>
                                    <h4 class="mb-0">{{ $sRowEmpC }}</h4>
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
                                    <p class="text-muted font-weight-medium">จำนวนแผนกทั้งหมด</p>
                                    <h4 class="mb-0">{{ $sRowDepartmentC }}</h4>
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
                                    <p class="text-muted font-weight-medium">จำนวนตำแหน่งทั้งหมด</p>
                                    <h4 class="mb-0">{{ $sRowPositionC }}</h4>
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
                                    <p class="text-muted font-weight-medium">จำนวนวีดีโอทั้งหมด</p>
                                    <h4 class="mb-0">{{ $sRowVideoC }}</h4>
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
                                    <p class="text-muted font-weight-medium">จำนวนผู้ที่ได้อีเมล์ทั้งหมด</p>
                                    <h4 class="mb-0">{{ $sRowReceiveEmailC }}</h4>
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
        </div>
        
        <!-- Transaction Data -->
        <div class="col-xl-12">
             <!-- Col2 -->
            <div class="card">
                <div class="card-body">  
                    <h4 class="card-title mb-4">Transaction Data</h4>      

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">จำนวนการอบรมทั้งหมด</p>
                                    <h4 class="mb-0">{{ $sRowTrainC }}</h4>
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
                                    <p class="text-muted font-weight-medium">จำนวนพนักงาน ที่เข้าอบรมทั้งหมด</p>
                                    <h4 class="mb-0">{{ $sRowTrainEmpC }}</h4>
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
        </div>
        
        
    </div>    
<!-- end row -->
@endsection

@section('script') 

@endsection