@extends('backend.layouts.master')

@section('title') Physician @endsection

@section('css')

@endsection

@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Add / Edit Physician</h4>
			
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Backend</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Masters</a></li>
                    <li class="breadcrumb-item active">Physician</li>
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
					<form action="{{ route('backend.masters.physician.store') }}" method="POST" autocomplete="off">
				@else
					<form action="{{ route('backend.masters.physician.update', $sRow->id ) }}" method="POST" autocomplete="off">
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
							<label for="example-password-input" class="col-md-2 col-form-label">Names</label>
							<div class="col-md-10">
								<input class="form-control" type="text" value="{{ $sRow->names??'' }}" name="names" placeholder="Names">
							</div>
						</div>						
						<div class="form-group row">
							<label for="example-text-input" class="col-md-2 col-form-label">Sex</label>
							<div class="col-md-10">
								<input class="form-control" type="text" value="{{ $sRow->sex??'' }}" name="sex" placeholder="sex" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-text-input" class="col-md-2 col-form-label">Types</label>
							<div class="col-md-10">
								<input class="form-control" type="text" value="{{ $sRow->types??'' }}" name="types" placeholder="Types" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-text-input" class="col-md-2 col-form-label">Code</label>
							<div class="col-md-10">
								<input class="form-control" type="text" value="{{ $sRow->codes??'' }}" name="codes" placeholder="Code" required>
							</div>
						</div>
						
						<div class="form-group mb-0 row">
							<div class="col-md-6">
								<a class="btn btn-secondary btn-sm waves-effect" href="{{ route('backend.masters.physician.index') }}">
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
