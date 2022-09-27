@extends('frontend.layouts.components-index')

@section('style-css')

@endsection

@section('contents-boby')
<?php
	// if(!empty($sDataV)){
	// 	dd($sDataV);
	// }
?>
<div class="bg-imageG" id="content">
	<div class="container">
		<div class="row ">
			<div class="col-12 text-center py-2" style="margin-top:7%;">
				<img src="{{ asset('asset/frontend/images/SIG_Logo-removebg-preview.png') }}" class="logo1">
			</div>
			
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 ">
				<form action="thankyou">
					<div class="row mb-1 ">
						<div class="col-12">
							<!--พื้นที่โชว์ถ่ายรูปจากกล้อง-->
							{{-- <div class="ratio ratio-4x3 mb-1"> --}}
							<div class="ratio ratio-4x3 mb-1">
								<video id="vid" width="100%" height="100%" controls muted autoplay>
									<?php if($sDataV->name_status == '1'){ ?>
										<?php $v_name = $sDataV->name; ?>
										<source src="{{URL::asset('/public/asset/video/'.$v_name.'')}}" type="video/mp4">
									<?php }else{ ?>
										<?php $v_name = $sDataV->name_m; ?>
										<source src="http://127.0.0.1:8080/videos/<?php echo $v_name; ?>" type="video/mp4">
									<?php } ?>
								</video>
							</div>
						</div>
					</div>

					<div class="container">
						<div class="row mb-5">
							<div class="col-12 py-2">
								<div class="card cardT mb-4">
									<div class="card-body">
										<!-- Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incid -->
										<h3 class="card-title">หัวข้อเรื่่องอบรม <?php echo empty($sDataV->details) ? '-' : $sDataV->details; ?></h3>

										<div class="row">
											<div class="col-8">
												<p class="text-blue">แผนก: <?php echo empty($sDataV->department_name) ? '-' : $sDataV->department_name; ?></p>
											</div>
											<div class="col-4 text-end">
												<p class="text-blue"><i class="fas fa-eye"></i>
													<?php echo empty($sDataV->views) ? '0' : $sDataV->views; ?></p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6 text-left mb-3">
							{{-- <a href="{{url("listTraining/$sData->id")}}"><button type="button" class="btn btn-blue" style="width:100%; font-size:20px;">กลับสู่เมนู <br/> BACK</button></a> --}}
							<a href="{{ url()->previous() }}"><button type="button" class="btn btn-blue" style="width:100%; font-size:20px;">กลับสู่เมนู <br/> BACK</button></a>
							
						</div>
						<div class="col-sm-6 text-right mb-3">
							<button type="button" onclick="return takeOther()" id="take-other" class="btn btn-blue" style="width:100%; font-size:20px;">จัดเก็บและเลือกวิดีโอถัดไป <br/> SAVE / NEXT VIDEO</button>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 text-center mb-2">
							<button type="button" onclick="return takeFinal()" id="take-final" class="btn btn-blue" style="width:100%; font-size:20px;">เสร็จสิ้นการอบรบ <br/> FINISH</button>
						</div>
					</div>
					<div class="row text-end">
						<div class="col-sm-12 text-end">
							<button type="button" onclick="return endFinal()" id="take-endfinal" class="btn btn-danger" style="width:30%; font-size:20px;">ออกจากระบบการอบรม <br/> EXIT (without SAVE)</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		
	</div>
</div>
<script>
	$(function(){
		var vid = document.getElementById("vid");
		vid.muted = false;
				vid.play();
	
		
	});
</script>
<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
<script>
	$('#content').css({
       'height': $(window).height()
    });

	function takeOther() {
		var txt;
		$.ajax({
			url: '{{url("listTraining-submit/$sData->id")}}',
			type: 'post',
			data: {
				id: "{{$sData->id}}",
				v_id: "{{$sDataV->id}}",
				v_start: '{{date("h:i:s")}}',
			},
			dataType: 'html',
			success: function(data) {
				window.location = '{{url("listTraining/$sData->id")}}';
			}
		});
		
  }

  
	
// 	function takeOther() {
// 		var txt;
// 		var r = confirm("ยืนยันการจบคลิปอบรม");
// 		if (r == true) {	
// 			$.ajax({
// 				url: '{{url("listTraining-submit/$sData->id")}}',
// 				type: 'post',
// 				data: {
// 					id: "{{$sData->id}}",
// 					v_id: "{{$sDataV->id}}",
// 					v_start: '{{date("h:i:s")}}',
// 				},
// 				dataType: 'html',
// 				success: function(data) {
// 					window.location = '{{url("listTraining/$sData->id")}}';
// 				}
// 			});
		  
// 		  return false;
// 		} else {	
	  
// 		  return false;
// 		}
		
//   }
  function takeFinal() {
		
		var txt;
	  $.ajax({
		  url: '{{url("listTraining-submit/$sData->id")}}',
		  type: 'post',
		  data: {
			  id: "{{$sData->id}}",
			  v_id: "{{$sDataV->id}}",
			  v_start: '{{date("h:i:s")}}',
		  },
		  dataType: 'html',
		  success: function(data) {
			  window.location = '{{ route('frontend.thankyou', ['v_id' => $sDataV->id.','.$sData->id]) }}';
		  }
	  });
  }

  function endFinal() {
		
		var txt;
		var r = confirm("ยืนยันออกจากระบบการอบรม");
		if (r == true) {	
			window.location = '{{ url('') }}';
		  return false;
		} else {	
	  
		  return false;
		}
		
  }

	// function takeFinal() {
		
	//   	var txt;
	//   	var r = confirm("ยืนยันการจบการอบรบรม");
	//   	if (r == true) {	
	// 		$.ajax({
	// 			url: '{{url("listTraining-submit/$sData->id")}}',
	// 			type: 'post',
	// 			data: {
	// 				id: "{{$sData->id}}",
	// 				v_id: "{{$sDataV->id}}",
	// 				v_start: '{{date("h:i:s")}}',
	// 			},
	// 			dataType: 'html',
	// 			success: function(data) {
	// 				window.location = '{{ route('frontend.thankyou', ['v_id' => $sDataV->id.','.$sData->id]) }}';
	// 			}
	// 		});
			
	// 		return false;
	//   	} else {	
		
	// 		return false;
	//   	}
	  	
	// }
</script>
@endsection

@section('scripts-js')

@endsection
