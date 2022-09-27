@extends('backend.layouts.master')

@section('title') Add / Edit ESWL Price @endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('backend/libs/select2/select2.min.css')}}">
@endsection

@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Add / Edit ESWL PRICE</h4>
			
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Backend</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Treatment Sheet</a></li>
                    <li class="breadcrumb-item active">ESWL Price</li>
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
				<form action="{{ route('backend.sheet.eswl-price.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
					@else
					<form action="{{ route('backend.sheet.eswl-price.update', $sRow->id ) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
						<input name="_method" type="hidden" value="PUT">
						@endif
						{{ csrf_field() }}						
						
						<div class="row">
							<div class="col-md-12">
								<div class="form-group row"><label class="col-md-12 col-form-label"><b>DATA MANAGEMENT</b></label></div>
								<div class="form-group row">
									<label class="col-md-3 col-form-label">Hospital :</label>
									<div class="col-md-9">
									<select class="form-control select2-templating" id="id_hosp" name="id_hosp">
										<option value="">Select</option>
										@if($sHospital)
											@foreach($sHospital AS $r)
											<option value="{{$r->id}}"  {{ (isset($sRow) && $sRow->id_hosp==$r->id)?'selected':'' }}>{{$r->name_open_invoice}}</option>
											@endforeach
										@endif
									</select>
									</div>
								</div>								
								<div class="form-group row">
									<label class="col-md-3 col-form-label">Tx. Free :</label>
									<div class="col-md-9">
									<select class="form-control select2-templating" id="id_eswl" name="id_eswl">
										<option value="">Select</option>
										@if($sSheetEswl)
											@foreach($sSheetEswl AS $r)
											<option value="{{$r->id}}"  {{ (isset($sRow) && $sRow->id_eswl==$r->id)?'selected':'' }}>{{$r->name}}</option>
											@endforeach
										@endif
									</select>
									</div>
								</div>								
								<div class="form-group row">
									<label for="example-text-input" class="col-md-3 col-form-label">Price :</label>
									<div class="col-md-9">
										
										<div class="outer-repeater">
											<div data-repeater-list="outer-group1" class="outer">
												<div data-repeater-item class="outer">								
													
													<div class="inner-repeater">
														<div data-repeater-list="inner-group1" class="inner form-group" >
															
															<!-- Loop Start -->
															@if($sPrice)
																@foreach($sPrice AS $rs)
																<div data-repeater-item class="inner row">
																	<div class="col-md-10">
																		<input class="form-control" type="text" value="{{ $rs??'' }}" name="price" placeholder="Price" required>
																	</div>
																	<div class="col-md-2">
																		<input data-repeater-delete type="button" class="btn btn-primary btn-block inner" value="Delete"/>
																	</div>	
																	<br><br>													
																</div>
																@endforeach
															@else
																<div data-repeater-item class="inner row">
																	<div class="col-md-10">
																		<input class="form-control" type="text" value="" name="price" placeholder="Price" required>
																	</div>
																	<div class="col-md-2">
																		<input data-repeater-delete type="button" class="btn btn-primary btn-block inner" value="Delete"/>
																	</div>	
																	<br><br>													
																</div>
															@endif
															<!-- Loop End -->
															
														</div>
														<input data-repeater-create type="button" class="btn btn-success inner" onclick="f_run_select2()" value="Add Price"/>
													</div>								
													
												</div>
											</div>
										</div>
										
									</div>
								</div>
								<br>
								
								
								
							</div>
						</div>						
						
						<div class="form-group mb-0 row">
							<div class="col-md-6">
								<a class="btn btn-secondary btn-sm waves-effect" href="{{ route('backend.sheet.eswl-price.index') }}">
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
		<!-- form mask -->
		<script src="{{ URL::asset('backend/libs/select2/select2.min.js')}}"></script>
		<!-- form mask -->
        <script src="{{ URL::asset('backend/libs/jquery-repeater/jquery-repeater.min.js')}}"></script>
        <!-- form mask init -->
        <script src="{{ URL::asset('backend/js/pages/form-repeater.int.js')}}"></script> 
		
		<script>
			$('.select2-templating').select2();
		</script>
	@endsection