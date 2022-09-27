@extends('frontend.layouts.components-index')

@section('contents-boby')
<div class="bg-imageG" id="content">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center py-5">
				<img src="{{ asset('asset/frontend/images/SIG_Logo-removebg-preview.png') }}" class="logo1">
			</div>
			<div class="col-12 text-center py-4">
				<h1 class="fw-bold display-4">ถ่ายรูปผู้เข้าร่วมอบรม</h1>
				<h2 class="fw-normal display-4">(Take a photo of the participants)</h2>
			</div>
			<div class="col-12 py-4">
				<form action="listTraining">
					<div class="row mb-3">
						<div class="col-12">
							<!--พื้นที่โชว์ถ่ายรูปจากกล้อง-->
							<div class="ratio ratio-1x1 mb-12">

								<main id="webcam-app">
									<div class="form-control webcam-start" id="webcam-control">
											<label class="form-switch">
											<input type="checkbox" id="webcam-switch">
											<i></i> 
											<span id="webcam-caption">Click to Start Camera</span>
											</label>      
											{{-- <button id="cameraFlip" class="btn d-none"></button> --}}
									</div>
									
									<div id="errorMsg" class="col-12 col-md-6 alert-danger d-none">
										Fail to start camera, please allow permision to access camera. <br/>
										If you are browsing through social media built in browsers, you would need to open the page in Sarafi (iPhone)/ Chrome (Android)
										<button id="closeError" class="btn btn-primary ml-3">OK</button>
									</div>
									<div class="md-modal md-effect-12">
										<div id="app-panel" class="app-panel md-content row p-0 m-0">     
											<div id="webcam-container" class="webcam-container col-12 d-none p-0 m-0">
												<video id="webcam" autoplay playsinline width="1040" height="880"></video>
												<canvas id="canvas" class="d-none"></canvas>
												<div class="flash"></div>
												<audio id="snapSound" src="{{-- asset('assets/audio_snap.wav') --}}" preload = "auto"></audio>
											</div>
											<div id="cameraControls" class="cameraControls">
												<a href="#" id="exit-app" title="Exit App" class="d-none"><i class="material-icons">exit_to_app</i></a>
												<a href="#" id="take-photo" title="Take Photo"><i class="material-icons">camera_alt</i></a>
												<a href="#" id="download-photo" download="selfie.png" target="_blank" title="Save Photo" class="d-none"><i class="material-icons">file_download</i></a>  
												<a href="#" id="resume-camera"  title="Resume Camera" class="d-none"><i class="material-icons">camera_front</i></a>
											</div>
										</div>        
									</div>
									<div class="md-overlay"></div>
									<div class="takeaphoto"></div>
									<input type="hidden" name="barcodeid" id="barcodeid">
								</main> 

							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 text-center"><button type="button" id="cameraFlip" class="btn btn-blue"><i class="fas fa-camera"></i></button></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('style-css')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endsection

@section('scripts-js')
<script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>
<script>
	$('#content').css({
       'height': $(window).height()
    });

	// window.onload = function() {
	// 	if (window.jQuery) {  			
	// 		alert("Yeah!");
	// 	} else {		
	// 		alert("Doesn't Work");
	// 	}
	// }
	
	/* take a photo */
	const webcamElement = document.getElementById('webcam');
	const canvasElement = document.getElementById('canvas');
	const snapSoundElement = document.getElementById('snapSound');
	const webcam = new Webcam(webcamElement, 'enviroment', canvasElement, snapSoundElement);

	$("#webcam-switch").change(function () {
		if(this.checked){
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
		else {        
			cameraStopped();
			webcam.stop();
			console.log("webcam stopped");
		}        
	});

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

	function cameraStopped(){
		$("#errorMsg").addClass("d-none");
		$("#wpfront-scroll-top-container").removeClass("d-none");
		$("#webcam-control").removeClass("webcam-on");
		$("#webcam-control").addClass("webcam-off");
		$("#cameraFlip").addClass('d-none');
		$(".webcam-container").addClass("d-none");
		$("#webcam-caption").html("Click to Start Camera");
		$('.md-modal').removeClass('md-show');
	}


	$("#take-photo").click(function () {
		beforeTakePhoto();
		let picture = webcam.snap();
		// document.querySelector('#download-photo').href = picture;
		//ดูข้อมูลาพ
		// console.log($("#download-photo").prop("href"));
		//เพิ่มรปภาพ
		photono++;
		// $(".takeaphoto").append(
		//     "<a href='javascript:void(0);' id='download-photo" + photono + "'>" +
		//     "<i class='material-icons'>photo" + photono + "</i></a>"
		// );
		// document.querySelector('#download-photo'+photono).href = picture;
		$(".takeaphoto").append(
			"<div class='form-group row' id='photo" + photono + "'>" +
				"<div class='col-sm-12'>" +
					"<div style='display: block; margin-left: auto; margin-right: auto; width: 100%;'>" +
					// "<a class='image-popup-no-margins' href='" + picture + "'>" +
						"<div style='position: absolute; right: 10px;'><i class='bx bx-trash-alt btntrash' id='" + photono + "' style='color: red; font-size: 1.73em;'></i></div>" +
						"<div><img class='img-fluid' src='" + picture + "'" +
						"></div>" +
					// "</a>" +
						"<input type='hidden' name='takeaphoto[]' value='" + picture + "'>" +
					"</div>" +
				"</div>" +
			"</div>"
		);
		$('#webcam-control').removeClass('d-none');
		$('#cameraControls').removeClass('d-none');
		// afterTakePhoto();
		//คิดว่าถ่ายเสร็จแล้วปิด คิดใหม่ว่าถ่ายให้เสร็จไปก่อนแล้วปิดทีเดียวดีกว่า
		// $("#exit-app").trigger("click");
	});

	$(document).on("click", ".btntrash", function () {
		$("#photo"+$(this).attr("id")).remove();
	});

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

	function afterTakePhoto(){
		webcam.stop();
		$('#canvas').removeClass('d-none');
		$('#take-photo').addClass('d-none');
		$('#exit-app').removeClass('d-none');
		$('#download-photo').removeClass('d-none');
		$('#resume-camera').removeClass('d-none');
		$('#cameraControls').removeClass('d-none');
	}

	function removeCapture(){
		$('#canvas').addClass('d-none');
		$('#webcam-control').removeClass('d-none');
		$('#cameraControls').removeClass('d-none');
		$('#take-photo').removeClass('d-none');
		$('#exit-app').addClass('d-none');
		$('#download-photo').addClass('d-none');
		$('#resume-camera').addClass('d-none');
	}

	$("#resume-camera").click(function () {
		webcam.stream()
			.then(facingMode =>{
				removeCapture();
			});
	});

	$("#exit-app").click(function () {
		removeCapture();
		$("#webcam-switch").prop("checked", false).change();
	});
</script>
@endsection