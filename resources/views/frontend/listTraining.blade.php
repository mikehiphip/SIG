@extends('frontend.layouts.components-index')

@section('style-css')

@endsection

@section('contents-boby')
<?php
	// if(!empty($id)){
	// 	dd($id);
	// }
?>
<div class="bg-imageG" id="content">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center py-5">
				<img src="{{ asset('asset/frontend/images/SIG_Logo-removebg-preview.png') }}" class="logo1">
			</div>
			<div class="col-12 text-center py-4">
				<h1 class="fw-bold display-4">รายการวิดีโออบรม</h1>
				<h2 class="fw-normal display-4">(Training video)</h2>
			</div>
		</div>
	</div>
	<div class="container container-main pb-5">
		<div class="row">
			<div class="col-sm-6 text-left mb-3">
				@if(@Request::get('departid') != null)
					@php $station = Request::get('departid'); @endphp
					<a href="{{ url("list-station/$station/$id") }}"><button type="button" class="btn btn-blue" style="width:100%; font-size:20px;">กลับสู่เมนู <br/> BACK</button></a>
				@else
					<a href="{{ url("list-department/$id") }}"><button type="button" class="btn btn-blue" style="width:100%; font-size:20px;">กลับสู่เมนู <br/> BACK</button></a>
				@endif
				
			</div>
		
		</div>

		<div class="row">			
			<?php foreach($sRow as $k => $v){ ?>
			<div class="col-md-6">
				<div class="card cardT mb-4">
				  <img src="{{ asset('asset/video/images/'.$v->pic.'') }}" class="card-img-top" alt="...">
				  <div class="card-body">
					<h3 class="card-title">หัวข้อเรื่่องอบรม <?php echo empty($v->details)?'-':$v->details; ?></h3>
					<div class="row">
						<div class="col-8">
							<p class="text-blue">แผนก: <?php echo empty($v->department_name)?'-':$v->department_name; ?></p>
						</div>
						<div class="col-4 text-end">
							<p class="text-blue"><i class="fas fa-eye"></i> <?php echo $v->views; ?></p>
						</div>
					</div>  
					<a href="{{ route('frontend.videotraining', ['v_id' => $v->id.','.$id]) }}" class="stretched-link"></a>
				  </div>
				</div>
			</div>
			<?php } ?>
		</div>

		{{-- <div class="row">
			<div class="col-sm-6 text-left mb-3">
				@if(@Request::get('departid') != null)
					@php $station = Request::get('departid'); @endphp
					<a href="{{ url("list-station/$station/$id") }}"><button type="button" class="btn btn-blue" style="width:100%; font-size:20px;">กลับสู่เมนู <br/> BACK</button></a>
				@else
					<a href="{{ url("list-department/$id") }}"><button type="button" class="btn btn-blue" style="width:100%; font-size:20px;">กลับสู่เมนู <br/> BACK</button></a>
				@endif
				
			</div>
		
		</div> --}}

	</div>
</div>
@endsection

@section('scripts-js')

@endsection