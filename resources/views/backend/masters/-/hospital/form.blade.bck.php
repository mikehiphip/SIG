@extends('backend.layouts.master')

@section('title') hospital @endsection

@section('css')

@endsection

@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Add / Edit Hospital</h4>
			
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Backend</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Masters</a></li>
                    <li class="breadcrumb-item active">Hospital</li>
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
				<form action="{{ route('backend.masters.hospital.store') }}" method="POST" autocomplete="off">
					@else
					<form action="{{ route('backend.masters.hospital.update', $sRow->id ) }}" method="POST" autocomplete="off">
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
								<input class="form-control" type="email" value="{{ $sRow->email??'' }}" name="email" {{ isset($sRow)?'readonly':'required' }}>
							</div>
						</div>
						-->
						
						<div class="form-group row">
							<label for="example-password-input" class="col-md-2 col-form-label">Types</label>
							<div class="col-md-10">
								<select class="form-control" name="types">
									<option value="">Select</option>
									@if($sHtypes)
									@foreach($sHtypes AS $v)
									<option value="{{$v}}"  {{ (isset($sRow) && $sRow->types==$v)?'selected':'' }}>{{$v}}</option>
									@endforeach
									@endif
								</select>
								<!--<input class="form-control" type="text" value="{{ $sRow->types??'' }}" name="types" placeholder="Types">-->
							</div>
						</div>						
						<div class="form-group row">
							<label for="example-text-input" class="col-md-2 col-form-label">Name</label>
							<div class="col-md-10">
								<input class="form-control" type="text" value="{{ $sRow->name??'' }}" name="name" placeholder="Name" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-text-input" class="col-md-2 col-form-label">Name Open Invoice</label>
							<div class="col-md-10">
								<input class="form-control" type="text" value="{{ $sRow->name_open_invoice??'' }}" name="name_open_invoice" placeholder="Name Open Invoice" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-text-input" class="col-md-2 col-form-label">Tax Id</label>
							<div class="col-md-10">
								<input class="form-control" type="text" value="{{ $sRow->tax_id??'' }}" name="tax_id" placeholder="Tax Id" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-text-input" class="col-md-2 col-form-label">Address</label>
							<div class="col-md-10">
								<input class="form-control" type="text" value="{{ $sRow->address??'' }}" name="address" placeholder="Address" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-text-input" class="col-md-2 col-form-label">Tel</label>
							<div class="col-md-10">
								<input class="form-control" type="text" value="{{ $sRow->tel??'' }}" name="tel" placeholder="Telephone" required>
							</div>
						</div>
						
						<div class="form-group row">
							<label for="example-text-input" class="col-md-2 col-form-label">Treating Physician </label>
							<div class="col-md-10">
								
								<div class="outer-repeater">
									<div data-repeater-list="outer-group1" class="outer">
										<div data-repeater-item class="outer">								
											
											<div class="inner-repeater">
												<div data-repeater-list="inner-group1" class="inner form-group" >
													
													<!-- Loop Start -->
													@if($sPhysicianId)
														@foreach($sPhysicianId AS $rs)
														<div data-repeater-item class="inner row">
															<div class="col-md-10">
																<select class="form-control" name="id_physician">
																	<option value="">Select</option>
																	@if($sPhysician)
																	@foreach($sPhysician AS $r)
																	<option value="{{$r->id}}"  {{ ($rs==$r->id)?'selected':'' }}>{{$r->names}}</option>
																	@endforeach
																	@endif
																</select>
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
																<select class="form-control" name="id_physician">
																	<option value="">Select</option>
																	@if($sPhysician)
																	@foreach($sPhysician AS $r)
																	<option value="{{$r->id}}" >{{$r->names}}</option>
																	@endforeach
																	@endif
																</select>
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
						
						<div class="form-group mb-0 row">
							<div class="col-md-6">
								<a class="btn btn-secondary btn-sm waves-effect" href="{{ route('backend.masters.hospital.index') }}">
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
		<script src="{{ URL::asset('backend/libs/select2/select2.min.js')}}"></script>
		<!-- form mask -->
        <script src="{{ URL::asset('backend/libs/jquery-repeater/jquery-repeater.min.js')}}"></script>
        <!-- form mask init -->
        <script src="{{ URL::asset('backend/js/pages/form-repeater.int.js')}}"></script> 
		
		<script>
			$('.select2-templating').select2();
		</script>
		
	@endsection