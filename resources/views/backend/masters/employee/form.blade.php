@extends('backend.layouts.master')

@section('title') พนักงาน @endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Add / Edit พนักงาน</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">ข้อมูลหลัก</a></li>
                        <li class="breadcrumb-item">พนักงาน </li>
                        <li class="breadcrumb-item active">Add / Edit พนักงาน </li>
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
                    <form action="{{ route('backend.masters.employee.store') }}" method="POST" autocomplete="off">
                @else
                    <form action="{{ route('backend.masters.employee.update', $sRow->id) }}" method="POST" autocomplete="off">
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
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">โค้ด</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ $sRow->code ?? '' }}" name="code"
                                placeholder="กรอกโค้ด" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">รหัสบัตรประชาชน</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ $sRow->id_card_code ?? '' }}" name="id_card_code"
                                placeholder="กรอกรหัสบัตรประชาชน" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="example-password-input" class="col-md-2 col-form-label">คำนำหน้าภาษาอังกฤษ</label>
                        <div class="col-md-10">
                            <select class="form-control select2-templating" name="prefixideng">
                                <option value="">กรุณาเลือกข้อมูล</option>
                                @if ($sRowPfn)
                                    @foreach ($sRowPfn as $v)
                                        <option value="{{ $v }}" {{ isset($sRow) && $sRow->prefixideng == $v->id ? 'selected' : '' }}>
                                            {{ $v->nameeng }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <!--<input class="form-control" type="text" value="{{ $sRow->types ?? '' }}" name="types" placeholder="Types">-->
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">ชื่อภาษาอังกฤษ</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ $sRow->nameeng ?? '' }}" name="nameeng"
                                placeholder="กรอกชื่อชื่อภาษาอังกฤษ" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">นามสกุลภาษาอังกฤษ</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ $sRow->lastnameeng ?? '' }}"
                                name="lastnameeng" placeholder="กรอกนามสกุลภาษาอังกฤษ" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="example-password-input" class="col-md-2 col-form-label">คำนำหน้าภาษาไทย</label>
                        <div class="col-md-10">
                            <select class="form-control select2-templating" name="prefixidthai">
                                <option value="">กรุณาเลือกข้อมูล</option>
                                @if ($sRowPfn)
                                    @foreach ($sRowPfn as $v)
                                        <option value="{{ $v }}" {{ isset($sRow) && $sRow->prefixidthai == $v->id ? 'selected' : '' }}>
                                            {{ $v->namethai }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <!--<input class="form-control" type="text" value="{{ $sRow->types ?? '' }}" name="types" placeholder="Types">-->
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">ชื่อภาษาไทย</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ $sRow->namethai ?? '' }}" name="namethai"
                                placeholder="กรอกชื่อภาษาไทย" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">นามสกุลภาษาไทย</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ $sRow->lastnamethai ?? '' }}" name="lastnamethai"
                                placeholder="กรอกนามสกุลภาษาไทย" required>
                        </div>
                    </div>    
                    
                    <div class="form-group row">
                        <label for="example-password-input" class="col-md-2 col-form-label">แผนก</label>
                        <div class="col-md-10">
                            <select class="form-control select2-templating" name="department_id">
                                <option value="">กรุณาเลือกข้อมูล</option>
                                @if ($sRowDep)
                                    @foreach ($sRowDep as $v)
                                        <option value="{{ $v }}" {{ isset($sRow) && $sRow->department_id == $v->id ? 'selected' : '' }}>
                                            {{ $v->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <!--<input class="form-control" type="text" value="{{ $sRow->types ?? '' }}" name="types" placeholder="Types">-->
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="example-password-input" class="col-md-2 col-form-label">ตำแหน่ง</label>
                        <div class="col-md-10">
                            <select class="form-control select2-templating" name="position_id">
                                <option value="">กรุณาเลือกข้อมูล</option>
                                @if ($sRowPos)
                                    @foreach ($sRowPos as $v)
                                        <option value="{{ $v }}" {{ isset($sRow) && $sRow->position_id == $v->id ? 'selected' : '' }}>
                                            {{ $v->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <!--<input class="form-control" type="text" value="{{ $sRow->types ?? '' }}" name="types" placeholder="Types">-->
                        </div>
                    </div>
                    <br>
                
                    <div class="form-group mb-0 row">
                        <div class="col-md-6">
                            <a class="btn btn-secondary btn-sm waves-effect"
                                href="{{ route('backend.masters.employee.index') }}">
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
