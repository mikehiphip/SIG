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
				<h1 class="fw-bold display-4">ประเภทรายการอบรม</h1>
				<h2 class="fw-normal display-4">(Training category video)</h2>
			</div>
		</div>
	</div>
	<div class="container container-main pb-5">
		<div class="row">		
            @if($sRow)
            @foreach($sRow as $row)
            <div class="col-sm-6 text-left mb-3">
                <a href=""><button type="button" class="btn btn-blue" style="width:100%; font-size:20px;">{{@$row->name}} <br/> </button></a>
            </div>
            @endforeach
            @endif	
			
		</div>
	</div>
</div>
@endsection

@section('scripts-js')

@endsection