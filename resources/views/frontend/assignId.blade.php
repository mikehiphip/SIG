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
			<div class="col-12 text-center py-4">
				<h1 class="fw-bold display-4">กรุณากรอกเลขรหัสพนักงาน</h1>
				<h2 class="fw-normal display-4">(Please enter employee ID)</h2>
			</div>
			<div class="col-12 py-4">
			
				<form id="isform" action="{{ route('frontend.assignidaction') }}" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="row mb-3">
						<div class="col-md-1 text-center">
							<div class="ico-num">1</div>
						</div>
						<div class="col-md-10">
							<input type="text" id="c_emp_v1" name="c_emp_v1" class="form-control mb-3" value="" autocomplete="off">							
							<div id="c_emp_s1" class=""></div>							
						</div>
						<div class="col-md-1 text-center">
							<div id="c_emp_l1" class=""></div>							
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-1 text-center">
							<div class="ico-num">2</div>
						</div>
						<div class="col-md-10">
							<input type="text" id="c_emp_v2" name="c_emp_v2" class="form-control mb-3" value="" autocomplete="off">
							<div id="c_emp_s2" class=""></div>							
						</div>
						<div class="col-md-1 text-center">
							<div id="c_emp_l2" class=""></div>							
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-1 text-center">
							<div class="ico-num">3</div>
						</div>
						<div class="col-md-10">
							<input type="text" id="c_emp_v3" name="c_emp_v3" class="form-control mb-3" value="" autocomplete="off">
							<div id="c_emp_s3" class=""></div>
						
						</div>
						<div class="col-md-1 text-center">
							<div id="c_emp_l3" class=""></div>							
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-1 text-center">
							<div class="ico-num">4</div>
						</div>
						<div class="col-md-10">
							<input type="text" id="c_emp_v4" name="c_emp_v4" class="form-control mb-3" value="" autocomplete="off">
							<div id="c_emp_s4" class=""></div>
							
						</div>
						<div class="col-md-1 text-center">
							<div id="c_emp_l4" class=""></div>							
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-1 text-center">
							<div class="ico-num">5</div>
						</div>
						<div class="col-md-10">
							<input type="text" id="c_emp_v5" name="c_emp_v5" class="form-control mb-3" value="" autocomplete="off">
							<div id="c_emp_s5" class=""></div>							
						</div>
						<div class="col-md-1 text-center">
							<div id="c_emp_l5" class=""></div>							
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 text-center"><button type="button" id="btn-form" class="btn btn-blue">ยืนยัน</button></div>
					</div>
				</form>


				<input type="hidden" value="{{ route('frontend.assignidcall') }}" id="urlAssignIdCallLink">
			</div>
		</div>
	</div>
</div> 
@endsection

@section('scripts-js')
<script>
    $('#content').css({
       'height': $(window).height()
    });

	// <!--<div class="alert alert-success h2">สุจิตรา วิไลพรรณ</div>-->
	// <!--<i class="fas fa-check-circle text-success fa-4x"></i>-->

	// <!--<div class="alert alert-danger h2">&nbsp;</div>-->
	// <!--<i class="fas fa-times-circle text-danger fa-4x"></i>-->

	$('#c_emp_v1').keypress(function (e) {
		var key = e.which;
		if(key == 13)  // the enter key code
		{
			v_num = $('input[name = c_emp_v1]').val();
			f_check_exp(v_num, '1');
		}
	});

	$('#c_emp_v2').keypress(function (e) {
		var key = e.which;
		if(key == 13)  // the enter key code
		{
			v_num = $('input[name = c_emp_v2]').val();
			f_check_exp(v_num, '2');
		}
	});

	$('#c_emp_v3').keypress(function (e) {
		var key = e.which;
		if(key == 13)  // the enter key code
		{
			v_num = $('input[name = c_emp_v3]').val();
			f_check_exp(v_num, '3');
		}
	});

	$('#c_emp_v4').keypress(function (e) {
		var key = e.which;
		if(key == 13)  // the enter key code
		{
			v_num = $('input[name = c_emp_v4]').val();
			f_check_exp(v_num, '4');
		}
	});

	$('#c_emp_v5').keypress(function (e) {
		var key = e.which;
		if(key == 13)  // the enter key code
		{
			v_num = $('input[name = c_emp_v5]').val();
			f_check_exp(v_num, '5');
		}
	});

	function f_check_exp(p1, p2){
		// alert('test'+p2+' : '+p1);
		
		$("#c_emp_s"+p2).removeAttr("class");
		$("#c_emp_s"+p2).html('');			
		$("#c_emp_l"+p2).removeAttr("class");

		$("#c_emp_s"+p2).attr("class", "");				
		$("#c_emp_l"+p2).attr("class", "");

		$.ajax({           
            url: $('#urlAssignIdCallLink').val(),
			
            data: {
				"_token"	: "{{ csrf_token() }}",
                "p_id"		: p1
            },
            type: 'POST',
			async: false,
            success: function(result) {
                var myJSON = JSON.parse(result);              
				
				v_name 		= myJSON.r_data.prefixnamethai + ' ' + myJSON.r_data.namethai + ' ' + myJSON.r_data.lastnamethai;		// ชื่อ
				v_status 	= myJSON.r_status;		// สถานะ

				if(v_status == 'yes'){
					$("#c_emp_s"+p2).addClass("alert alert-success h2");
					$("#c_emp_s"+p2).html(v_name);			
					$("#c_emp_l"+p2).addClass("fas fa-check-circle text-success fa-4x");
				}else{
					$("#c_emp_s"+p2).addClass("alert alert-danger h2");					
					$("#c_emp_v"+p2).val('');
					p1 = (p1 == '')?'&nbsp;':p1;	$("#c_emp_s"+p2).html(p1);						
					$("#c_emp_l"+p2).addClass("fas fa-times-circle text-danger fa-4x");
				}
				
            }
        });
		return v_status;
	}
	
	
	
	
	$("#btn-form").click(function () {	
		v_num1 = $('input[name = c_emp_v1]').val();
		v_num2 = $('input[name = c_emp_v2]').val();
		v_num3 = $('input[name = c_emp_v3]').val();
		v_num4 = $('input[name = c_emp_v4]').val();
		v_num5 = $('input[name = c_emp_v5]').val();
		v_num_arr = [];
		v_num_arr.push(v_num1, v_num2, v_num3, v_num4, v_num5);
		checks = 0;
		for(i=0; i<5; i++){
			// alert('test : '+v_num_arr[i]);
			if(v_num_arr[i] != ''){
				ajax_checks = f_check_exp(v_num_arr[i], (i+1));
				if(ajax_checks == 'no'){
					checks++;
				}
			}
		}
		
		if(checks > 0){
			alert('กรุณากรอกเลขรหัสพนักงานที่ไม่มีใหม่');
		}else{
			$( "#isform" ).submit();
		}
	});
</script> 
@endsection