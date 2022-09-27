@extends('backend.layouts.master')

@section('title') ส่วนลดทั้งเว็บไซต์ @endsection

@section('css')

@endsection

@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">ส่วนลดทั้งเว็บไซต์</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Backend</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Promotion</a></li>
                    <li class="breadcrumb-item active">ส่วนลดทั้งเว็บไซต์</li>
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
              @if( empty($sRow) )
              <form action="{{ route('backend.permission.admin.store') }}" method="POST" autocomplete="off">
              @else
              <form action="{{ route('backend.permission.admin.update', $sRow->id ) }}" method="POST" autocomplete="off">
                <input name="_method" type="hidden" value="PUT">
              @endif
                {{ csrf_field() }}
              <!--
                <h4 class="card-title">Textual inputs</h4>
                <p class="card-title-desc">
                  Here are examples of <code>.form-control</code> applied to each textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.
                </p>
              -->
<div class="row col-lg-7 col-md-7 ">

                <div class="col-sm-12">
                  <div class="form-group">
                    <label>โปรโมชั่น :</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-server"></i>
                      </span>
                                          <input type="text" class="form-control" name="name" value="{{ isset($sRow)?$sRow->name:'' }}"  />
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group">
                    <label>ช่วงวันที่ :</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                      </span>
                                          <input type="text" class="form-control js-daterange-picker-rangesoption-2" name="daterange" value="{{ isset($sRow)?$sRow->date_start.' - '.$sRow->date_end:'' }}" readonly="" />
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>ประเภทส่วนลด :</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-server"></i>
                      </span>
                                        <select class="form-control" name="type">
                                          <option value="P" {{ (@$sRow->type=='P')?'selected':'' }}>ส่วนลด %</option>
                        <option value="B" {{ (@$sRow->type=='B')?'selected':'' }}>ส่วนลด บาท</option>
                                        </select>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>ยอดส่วนลด   :</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-server"></i>
                      </span>
                      <input type="text" class="form-control" placeholder="ยอดส่วนลด" value="{{ $sRow->discount??'' }}" name="discount"  required="" />
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>สถานะ :</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-server"></i>
                      </span>
                                        <select class="form-control" name="status">
                                          <option value="Y" {{ (@$sRow->status=='Y')?'selected':'' }}>ใช้งาน</option>
                        <option value="N" {{ (@$sRow->status=='N')?'selected':'' }}>ไม่ใช้งาน</option>
                                        </select>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>ประเทศ :</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-server"></i>
                      </span>

                    </div>
                  </div>
                </div>


              </div>

              <div class="row col-lg-5 col-md-5">
                <div class="col-sm-12">
                    <div class="form-group">
                      <label>รายระเอียด :</label>
                      <textarea class="form-control no-resize" rows="9" placeholder="Please type what you want..." name="note">{{ $sRow->note??'' }}</textarea>
                    </div>

                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 m-t-10 m-b-15 align-center">
                <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
              </div>


              </form>
            </div>
        </div>
    </div> <!-- end col -->
</div>
<!-- end row -->

@endsection




@push('css')
<!-- Bootstrap DateRangePicker Css -->
<link href="{!!asset('/public/backend/assets/plugins/bootstrap-daterangepicker/daterangepicker.css')!!}" rel="stylesheet" />
<style>
.codeinput input{
	padding:3px 0px;height:auto;background-color:transparent !important;border:transparent;
}
</style>
@endpush
@push('scripts')
<!-- MomentJs -->
<script src="{!!asset('/public/backend/assets/plugins/moment/moment.js')!!}"></script>
<!-- Bootstrap DateRangePicker Js -->
<script src="{!!asset('/public/backend/assets/plugins/bootstrap-daterangepicker/daterangepicker.js')!!}"></script>
<script>
$(function() {
    $(document).ready(function() {










   });
});


</script>
@endpush
