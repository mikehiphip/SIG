@extends('frontend.layouts.components-index')

@section('contents-boby')
<div class="bg-imageG" id="content">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center pt-5 pb-0">
				<img src="{{ asset('asset/frontend/images/SIG_Logo-removebg-preview.png') }}" class="logo1" style="width:200px;">
			</div>
			<div class="col-12 text-center py-3">
				<h1 class="fw-bold display-4">ถ่ายรูปผู้เข้าร่วมอบรม  <span class="label label-warning show-countdown"></span></h1>
				<h2 class="fw-normal display-4">(Take a photo of the participants)</h2>
			</div>
			<div class="col-12">
				<?php
					// if(!empty($id)){
					// 	dd($id);
					// }
				?>
				<form id="photo_action" action="{{ route('frontend.takephotoaction') }}" method="POST" enctype="multipart/form-data">   
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="id" value="{{ $id }}">
					<div class="row mb-3">
						<div class="col-12 display-take">
							<!--พื้นที่โชว์ถ่ายรูปจากกล้อง-->							
							<div id="webcam-container" class="webcam-container ratio ratio-4x3">
								<video id="webcam" autoplay playsinline width="100%" height="100%" controls></video>	
								<canvas id="canvas" class="d-none"></canvas>															
							</div>
							<div class="takeaphoto"></div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12 text-center display-btn">							
							<button type="button" id="take-photo" class="btn btn-blue"><i class="fas fa-camera"></i></button>
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
	
	/* take a photo */
	const webcamElement = document.getElementById('webcam');
	const canvasElement = document.getElementById('canvas');
	const snapSoundElement = document.getElementById('snapSound');
	const webcam = new Webcam(webcamElement, 'enviroment', canvasElement, snapSoundElement);
	
	// run video auto
	function f_webcam_switch() {
		$('.md-modal').addClass('md-show');
		webcam.start()
		.then(result =>{
			cameraStarted();
			console.log("webcam started");
		})
		.catch(err => {
			displayError();
		});		       
	}
	f_webcam_switch();

	$('#cameraFlip').click(function() {
		webcam.flip();
		webcam.start();  
	});

	$('#closeError').click(function() {
		$("#webcam-switch").prop('checked', false).change();
	});

	function displayError(err = ''){
		if(err!=''){
			$("#errorMsg").html(err);
		}
		$("#errorMsg").removeClass("d-none");
	}

	function cameraStarted(){
		$("#errorMsg").addClass("d-none");
		$('.flash').hide();
		$("#webcam-caption").html("on");
		$("#webcam-control").removeClass("webcam-off");
		$("#webcam-control").addClass("webcam-on");
		$(".webcam-container").removeClass("d-none");
		if( webcam.webcamList.length > 1){
			$("#cameraFlip").removeClass('d-none');
		}
		$("#wpfront-scroll-top-container").addClass("d-none");
		window.scrollTo(0, 0);
		// $('body').css('overflow-y','hidden');
	}

	function display(seconds){ //function ใช้ในการ นับถอยหลัง

        seconds-=1;//ลบเวลาทีละหนึ่งวินาทีทุกครั้งที่ function ทำงาน
     
        if(seconds==-1){
            // alert('ถ่ายรูปสำเร็จ');
			// ถ่ายรูป
			takePhoto();
            return false;
        } //เมื่อหมดเวลาแล้วจะหยุดการทำงานของ function display
        
		$(".show-countdown").html(seconds); //แสดงเวลาที่เหลือ
        setTimeout("display("+seconds+")",1000);// สั่งให้ function display() ทำงาน หลังเวลาผ่านไป 1000 milliseconds ( 1000  milliseconds = 1 วินาที )
    }
	
	
	// main
	$("#take-photo").click(function () {
		// ดึงรูป ไปอยู่ที่หน้า draft แทน
		/*
		v_display_take = '';
		v_display_take += '<div style="height:936px">';
		v_display_take += '<img src="https://www.w3schools.com/tags/img_girl.jpg" style="margin-top:100px; margin-bottom:100px; width:936px; height:716px;">';
		v_display_take += '</div>';
		v_display_take += '<div class="takeaphoto"></div>';
		$(".display-take").html(v_display_take);		
		*/
		
		// ปุ่ม ไปอยู่ที่หน้า draft แทน
		/*
		v_display_btn = '';
		v_display_btn += '<button type="button" id="take-photo" class="btn btn-yellow"><i class="fa fa-retweet" aria-hidden="true"></i></button>';
		v_display_btn += '<button type="button" id="take-photo" class="btn btn-blue"><i class="fa fa-angle-right" aria-hidden="true"></i></button>';
		$(".display-btn").html(v_display_btn);	
		*/
		
		var seconds=6;	// กำหนดค่าเริ่มต้น วินาที    	
		$(".show-countdown").html(seconds);
		
		// ไป CountDown และถ่ายรูป
		display(seconds); //เปิดหน้าเว็บให้ทำงาน function  display()
		
		// ถ่ายรูป
		// takePhoto();		
	});
	
	
	/*
	$("#take-photo").click(function () {		
		beforeTakePhoto();
		let picture = webcam.snap();
		// alert(picture);

		$(".takeaphoto").append(		
			"<input type='hidden' name='takeaphoto' value='" + picture + "'>" 
		);
		$( "#photo_action" ).submit();

		$('#webcam-control').removeClass('d-none');
		$('#cameraControls').removeClass('d-none');
		
	});
	*/
	
	function takePhoto(){
		beforeTakePhoto();
		let picture = webcam.snap();
		// alert(picture);

		$(".takeaphoto").append(		
			"<input type='hidden' name='takeaphoto' value='" + picture + "'>" 
		);
		$( "#photo_action" ).submit();

		$('#webcam-control').removeClass('d-none');
		$('#cameraControls').removeClass('d-none');
	}
	
	function beforeTakePhoto(){
		$('.flash')
			.show()
			.animate({opacity: 0.3}, 500)
			.fadeOut(500)
			.css({'opacity': 0.7});
		window.scrollTo(0, 0); 
		$('#webcam-control').addClass('d-none');
		$('#cameraControls').addClass('d-none');
	}
	
</script>
@endsection