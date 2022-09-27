@extends('frontend.layouts.components-index')

@section('contents-boby')
<div class="bg-imageG" id="content">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center py-5">
				<img src="{{ asset('asset/frontend/images/SIG_Logo-removebg-preview.png') }}" class="logo1">
			</div>
			<div class="col-12 text-center py-4">
				<h1 class="fw-bold display-4">ถ่ายรูปผู้เข้าร่วมอบรม  </h1>
				<h2 class="fw-normal display-4">(Take a photo of the participants)</h2>
			</div>
			<div class="col-12 py-4">
				<?php
					// if(!empty($id)){
					// 	dd($id);
					// }
				?>
				<form id="photo_action" action="{{ route('frontend.takephotodraftaction') }}" method="POST" enctype="multipart/form-data">   
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="id" value="{{ $id }}">
					<div class="row mb-3">
						<div class="col-12 display-take">
							<!--พื้นที่โชว์ถ่ายรูปจากกล้อง-->							
							<div style="height:936px">
								<img src="{{ asset('/') }}{{$fileName}}" style="margin-top:100px; margin-bottom:100px; width:936px; height:716px;">
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12 text-center display-btn">							
							<button type="button" id="take-previous" class="btn btn-yellow"><i class="fa fa-retweet" aria-hidden="true"></i></button>
							<button type="button" id="take-next" class="btn btn-blue"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('style-css')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
	.btn-yellow {
		background: #FFA500;
		color: #fff;
		text-align: center;
		font-size: 3rem;
		padding: 20px 50px;
		width: 40%;
	}
</style>
@endsection

@section('scripts-js')
<script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>
<script>
	$('#content').css({
       'height': $(window).height()
    });	
	
	// main
	$("#take-previous").click(function () {	
		window.location = '{{ url()->previous()}}';			
	});
	
	$("#take-next").click(function () {
		$( "#photo_action" ).submit();
	});	
</script>
@endsection