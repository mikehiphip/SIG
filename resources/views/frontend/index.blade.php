@extends('frontend.layouts.components-index')

@section('style-css')

@endsection

@section('contents-boby')
<div class="bg-imageG" id="content">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center py-5">
				<img src="{{ asset('asset/frontend/images/SIG_Logo-removebg-preview.png') }}" class="logo1">
			</div>
			<div class="col-12 text-center py-5">
				<a href="assignId" type="button" class="btn btn-white shadow w-100 mb-5">
					<div class="icon-btn"><img src="{{ asset('asset/frontend/images/computer.png') }}"></div> Mode Training
				</a>
				<a href="" type="button" class="btn btn-white shadow w-100 mb-5">
					<div class="icon-btn2"><img src="{{ asset('asset/frontend/images/file.png') }}"></div> Training Records
				</a>
			</div>
			<div class="col-12 text-center py-5">
				
			</div>
		</div>
	</div>
</div>
<script>
	$('#content').css({
       'height': $(window).height()
    });
</script>
@endsection

@section('scripts-js')

@endsection