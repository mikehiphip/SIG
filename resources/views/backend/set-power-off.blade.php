@extends('backend.layouts.master')

@section('title') ตั้งค่าการใช้ระบบ @endsection

@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">ตั้งค่าการใช้ระบบ</h4>
            
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Backend</a></li>
                    <li class="breadcrumb-item active">ตั้งค่าการใช้ระบบ</li>
                </ol>
            </div>
            
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                
                    <form action="{{ route('backend.set-power-off.action') }}" method="POST" autocomplete="off">                     
                        
                        {{ csrf_field() }}            
                        
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Active</label>
                            <div class="col-md-10 mt-2">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch" name="active" value="y" {{ (isset($sRow) && $sRow->isStatus=='y')?'checked':'' }}>
                                    <label class="custom-control-label" for="customSwitch">ใช้งานปกติ</label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group mb-0 row">
                            <div class="col-md-6">
                                <a class="btn btn-secondary btn-sm waves-effect" href="{{ route('backend.permission.admin.index') }}">
                                    <i class="bx bx-arrow-back font-size-16 align-middle mr-1"></i> ย้อนกลับ
                                </a>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="submit" class="btn btn-primary btn-sm waves-effect">
                                    <i class="bx bx-save font-size-16 align-middle mr-1"></i> บันทึกข้อมูล
                                </button>
                            </div>
                        </div>
                        
                    </form>
                    
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->
    
    @endsection
