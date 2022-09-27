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
				<br><br><br><br><br><br>
				<br><br><br><br><br><br>
				<br><br><br><br><br><br>
			
				<h1><b>กำลังปิดปรับปรุงข้อมูล</b></h1>
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