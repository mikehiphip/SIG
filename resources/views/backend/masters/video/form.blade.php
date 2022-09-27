@extends('backend.layouts.master')

@section('title') วีดีโอ @endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Add / Edit วีดีโอ</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">ข้อมูลหลัก</a></li>
                        <li class="breadcrumb-item">วีดีโอ </li>
                        <li class="breadcrumb-item active">Add / Edit วีดีโอ </li>
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
                    <form action="{{ route('backend.masters.video.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                @else
                    <form action="{{ route('backend.masters.video.update', $sRow->id) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
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
                        <label for="pic" class="col-md-2 col-form-label">รูปหน้าปก ( กรุณา upload ไฟล์ .jpg ) <font style="color:red;"><b>Intrinsic size: 8256 × 5504 px</b></font></label>
                        <div class="col-md-4">	                       
                            <div class="form-group">                                
                                <input type="file" class="form-control" id="pic" name="pic">                            
                                <?php
                                    if(!empty($sRow->pic)){
                                        $image = $sRow->pic;                                                                        
                                    }else{
                                        $image = "";
                                    }
                                ?>                            
                                @if($image != "")      
                                    <br>
                                    <img class="imgshow" width="50%" src="{{ asset('public/asset/video/images/'.$image) }}" />
                                @endif
                                <div class="valid-feedback"> Looks good! </div>
                            </div>
                        </div>                    																									
                    </div>
                    
                    <div class="row">		
                        <label for="files" class="col-md-2 col-form-label">วีดีโอ ( กรุณา upload ไฟล์ .mp4 ) 
                        <font style="color:red;"><b>Upload file to the maximum : {{ ini_get("upload_max_filesize") }}B</b></font></label>
                        <div class="col-md-4">	                       
                            <div class="form-group">                                
                                <input type="file" class="form-control" id="files" name="files">                            
                                <?php
                                    if(!empty($sRow->name)){
                                        $video = $sRow->name;                                                                        
                                    }else{
                                        $video = "";
                                    }
                                ?>                            
                                 @if($video != "")      
                                    <br>                                    
                                    <video width="320" height="240" controls>
                                          <source src="{{ asset('public/asset/video/'.$video) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @endif
                                <div class="valid-feedback"> Looks good! </div>
                            </div>
                        </div>    
                        <label for="files" class="col-md-2 col-form-label">ชื่อวีดีโอ <font style="color:red;"><b></b></font></label>
                        <!-- public/asset/video -->
                        <div class="col-md-4">	                       
                            <div class="form-group">                                
                                <input class="form-control" type="text" value="{{ $sRow->name_m ?? '' }}" name="name_m" placeholder="กรอกชื่อวีดีโอสำหรับ upload เข้าทาง ftp">                            
                                <?php
                                    if(!empty($sRow->name_m)){
                                        $video = $sRow->name_m;                                                                        
                                    }else{
                                        $video = "";
                                    }
                                ?>                            
                                
                                <div class="valid-feedback"> Looks good! </div>
                            </div>
                        </div> 
                    </div>
                    
                    
                    <?php
                        $svideo1 = '';
                        $svideo2 = '';
                        if(!empty($sRow)){
                            if(empty($sRow->name_status)){
                                $svideo1 = 'checked';                                                                        
                            }
                            if($sRow->name_status == '1'){
                                $svideo1 = 'checked';                                                                     
                            }
                            if($sRow->name_status == '2'){
                                $svideo2 = 'checked';                                                                       
                            }
                        }
                    ?>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">สถานะ</label>
                        <div class="col-md-4">
                            <input class="form-check-input" type="radio" name="name_status" id="name_status1" value="1" <?php echo $svideo1; ?>>
                            <label class="form-check-label" for="name_status1">
                                                                                        ใช้วิดีโอแบบที่1 upload ที่ระบบ
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input class="form-check-input" type="radio" name="name_status" id="name_status2" value="2" <?php echo $svideo2; ?>>
                            <label class="form-check-label" for="name_status2">
                                                                                        ใช้วิดีโอแบบที่2 ใส่ชื่อ และไฟล์อยู่ที่ external harddisk ที่ kiosk
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">รายละเอียด</label>
                        <div class="col-md-10">                            
                            <textarea class="form-control" name="details" rows="3" placeholder="กรอกรายละเอียด" required>{{ $sRow->details ?? '' }}</textarea>
                        </div>
                    </div>
                    
                                       
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">จำนวนเข้าชม</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ $sRow->views ?? '' }}" name="views"
                                placeholder="กรอกจำนวนเข้าชม" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">ความยาวในการเข้าดู</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ $sRow->unit ?? '' }}"
                                name="unit" placeholder="ความยาวในการเข้าดู (x ชั่วโมง xx นาที xx วินาที)" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="example-password-input" class="col-md-2 col-form-label">แผนก</label>
                        <div class="col-md-10">
                            <select class="form-control select2-templating getstation" id="department_id" name="department_id">
                                <option value="">กรุณาเลือกข้อมูล</option>
                                @if (@$sRowDep)
                                    @foreach ($sRowDep as $v)
                                        <option value="{{ $v }}" {{ isset($sRow) && $sRow->department_id == $v->id ? 'selected' : '' }}>
                                            {{ $v->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-password-input" class="col-md-2 col-form-label">Station</label>
                        <div class="col-md-10">
                            <select class="form-control select2-templating" id="station_id" name="station_id">
                                @if(@$sRow->department_id != null)
                                    <option value="">กรุณาเลือกข้อมูล</option>
                                    @php $stations = DB::table('sg_station')->where('department_id',$sRow->department_id)->get();@endphp
                                    @if($stations->count() > 0)
                                        @foreach($stations as $station)
                                            <option value="{{@$station->id}}" @if($station->id == $sRow->station_id) selected @endif>{{@$station->name}}</option>
                                        @endforeach
                                    @endif
                                @else
                                <option value="">กรุณาเลือกข้อมูลแผนก</option>
                                @endif
                                
                            </select>
                        </div>
                    </div>



                    <br>
                
                    <div class="form-group mb-0 row">
                        <div class="col-md-6">
                            <a class="btn btn-secondary btn-sm waves-effect"
                                href="{{ route('backend.masters.video.index') }}">
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

        $('.getstation').change(function(){
            var department_id = $('#department_id').val();
            $.ajax({
                url : 'backend/masters/video/get-station/search',
                type: 'get',
                data:{
                    id: department_id,
                },
                dataType: 'json',
                success: function(data)
                {
                    if(data)
                    {
                        $("#station_id").text("");
                        $('#station_id').val(null);
                        $("#station_id").append("<option value=''  selected>กรุณาเลือกข้อมูลแผนก</option>");
                        $.each(data, function(index, value) {
                            $("#station_id").append("<option value='" + value.id + "'>" + value.name + ")</option>");
                        });
                    }
                    else
                    {
                        alert(1);
                        $("#station_id").text("");
                        $('#station_id').val(null);
                        $("#station_id").append("<option value=''  selected>กรุณาเลือกข้อมูลแผนก</option>");
                    }
                }
            })
        });
    </script>

@endsection
