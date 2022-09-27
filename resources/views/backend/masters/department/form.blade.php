@extends('backend.layouts.master')

@section('title') แผนก @endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">เพิ่ม / แก้ไข แผนก</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">                       
                        <li class="breadcrumb-item"><a href="javascript: void(0);">ข้อมูลหลัก</a></li>
                        <li class="breadcrumb-item">แผนก</li>
                        <li class="breadcrumb-item active">เพิ่ม / แก้ไข แผนก</li>
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
                @if (empty($sRow))
                    <form action="{{ route('backend.masters.department.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                @else
                    <form action="{{ route('backend.masters.department.update', $sRow->id) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PUT">
                @endif
                    {{ csrf_field() }}
                    <!--
                    <h4 class="card-title">Textual inputs</h4>
                    <p class="card-title-desc">
                    Here are examples of <code>.form-control</code> applied to each textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.
                    </p>
                    -->

                    <!--
                    <div class="form-group row">
                    <label for="example-email-input" class="col-md-2 col-form-label">Email</label>
                    <div class="col-md-10">
                        <input class="form-control" type="email" value="{{ $sRow->email ?? '' }}" name="email" {{ isset($sRow) ? 'readonly' : 'required' }}>
                    </div>
                    </div>
                    -->

                    <div class="row">		
                        <label for="pic" class="col-md-2 col-form-label">รูปหน้าปก ( กรุณา upload ไฟล์ .jpg ) <font style="color:red;"><b>Intrinsic size: 976 × 294 px</b></font></label>
                        <div class="col-md-4">	                       
                            <div class="form-group">                                
                                <input type="file" class="form-control" id="image" name="image">                            
                                <?php
                                    if(!empty($sRow->image)){
                                        $image = $sRow->image;                                                                        
                                    }else{
                                        $image = "";
                                    }
                                ?>                            
                                @if($image != "")      
                                    <br>
                                    <img class="imgshow" width="50%" src="{{ asset('public/asset/department/images/'.$image) }}" />
                                @endif
                                <div class="valid-feedback"> Looks good! </div>
                            </div>
                        </div>                    																									
                    </div>

                    @if (!empty($sRow))
                    {{-- <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">ลำดับ</label>
                        <div class="col-md-10">
                            @php 
                            $sorts = DB::table('sg_department')->where('deleted_at',null)->count();
                            @endphp
                            <select name="sort" id="sort" class="form-control">
                                @if($sorts > 0)
                                    @for($i=1;$i<=$sorts;$i++)
                                    <option value="{{@$i}}" @if($i == @$sRow->sort) selected @endif>{{@$i}}</option>
                                    @endfor
                                @endif
                            </select>
                  
                        </div>
                    </div> --}}
                    @endif
                   
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">ชื่อแผนก</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ $sRow->name ?? '' }}" name="name"
                                placeholder="กรอก ชื่อแผนก" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">สถานะการแสดงผลหน้าบ้าน</label>
                        <div class="col-md-10">
                            <select name="show_status" id="show_status" class="form-control">
                                <option value="off" @if(@$sRow->show_status == "off") selected @endif>ไม่แสดงผล</option>
                                <option value="on" @if(@$sRow->show_status == "on") selected @endif>แสดงผล</option>
                            </select>
                        </div>
                    </div>
                    <br>

                    <div class="form-group mb-0 row">
                        <div class="col-md-6">
                            <a class="btn btn-secondary btn-sm waves-effect"
                                href="{{ route('backend.masters.department.index') }}">
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

@section('script')

    <!-- form select2 -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <!-- form mask -->
    <script src="{{ URL::asset('backend/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>
    <!-- form mask init -->
    <script src="{{ URL::asset('backend/js/pages/form-repeater.int.js') }}"></script>

    <script>
        $(document).ready( function(){
            f_run_select2();

            $(document).on('click', '.btn_run_select2', function(){
               f_run_select2();
            });
        });

        function f_run_select2() {
            $(".c_add_select2").each(function() {
                $(".c_add_select2").addClass("select2-templating");
            });
            $(".select2-templating").select2();
        }
    </script>

@endsection
