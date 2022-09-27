@extends('backend.layouts.master')

@section('title') Add / Edit ESWL Patient @endsection

@section('css')
	<!-- select2 css -->
	<!-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('backend/libs/select2/select2.min.css')}}"> -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

	<!-- bootstrap-datepicker css -->
	<link href="{{ URL::asset('backend/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">

	<style>
		.readonly-color{
			background-color:#F5F5F5;
		}
	</style>
@endsection

@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Add / Edit ESWL Patient</h4>
			
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Backend</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Treatment Sheet</a></li>
                    <li class="breadcrumb-item active">ESWL Patient</li>
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
					<form action="{{ route('backend.sheet.eswl-patient.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
				@else
					<form action="{{ route('backend.sheet.eswl-patient.update', $sRow->id ) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
					<input name="_method" type="hidden" value="PUT">
				@endif
						{{ csrf_field() }}
						<input type="hidden" value="{{ $form_status }}" id="form_status">
						<input type="hidden" value="{{url('backend/sheet/eswl-patient/callexpenses')}}"  	id="urlLink"> 
						<input type="hidden" value="{{url('backend/sheet/eswl-patient/callpatient')}}"  	id="urlPatientLink"> 						
						<input type="hidden" value="{{url('backend/sheet/eswl-patient/calltxnogetcount')}}" id="urlTxNoGetCount"> 
						<input type="hidden" id="sumTxNoGetCount"> 
						<input type="hidden" value="{{ $sRow->patient_id??'' }}" id="ref_patient_id">
						
						<div class="row">
						
							<!-- Col1 -->
							<div class="col-md-6">
								<!-- TREATMENT DATA -->
								@include('backend.sheet.eswl-patient.sub-treatment-data')
								<br>
								
								<!-- MEDICAL PERSONNEL -->
								@include('backend.sheet.eswl-patient.sub-medical-personnel')								
								<br>	
								
								<div class="form-group row"><label class="col-md-12 col-form-label"><b>MEDICAL EXPENSES </b></label></div>								
								<div class="form-group row">
									<label for="example-password-input" class="col-md-3 col-form-label">Service Free</label>
									<div class="col-md-9">
										<input class="form-control" type="text"
										id="medical_expenses" style="background-color:#F5F5F5;" name="medical_expenses" value="{{ $sRow->medical_expenses??'' }}"  placeholder="Service Free" readonly>
									</div>
								</div>
								<div class="form-group row">
									<label for="example-password-input" class="col-md-3 col-form-label">Service Free Manual</label>
									<div class="col-md-9">
										<input class="form-control" type="text"
										id="medical_expenses_manual" name="medical_expenses_manual" 
										value="{{ $sRow->medical_expenses_manual??'' }}"  placeholder="Service Free Manual">
									</div>
								</div>
							</div>							
							
							<!-- Col2 -->
							<div class="col-md-6">							
								<!-- PATIENT DATA --> 
								@include('backend.sheet.eswl-patient.sub-patient-data')								
								<br>
							</div>							
						</div>						
						
						<div class="form-group mb-0 row"><br></div>
						
						<div class="form-group mb-0 row">
							<div class="col-md-6">
								<a class="btn btn-secondary btn-sm waves-effect" href="{{ route('backend.sheet.eswl-patient.index') }}">
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

	@section('script')
		<!-- select2 -->
		<!-- <script src="{{ URL::asset('backend/libs/select2/select2.min.js')}}"></script> -->
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
		<!-- form mask -->
        <script src="{{ URL::asset('backend/libs/jquery-repeater/jquery-repeater.min.js')}}"></script>
        <!-- form mask init -->
        <script src="{{ URL::asset('backend/js/pages/form-repeater.int.js')}}"></script> 
		
		<!-- bootstrap-datepicker js -->
		<script src="{{ URL::asset('backend/libs/bootstrap-datepicker/moment.min.js')}}"></script>    
		<script src="{{ URL::asset('backend/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>    
		<script src="{{ URL::asset('backend/libs/bootstrap-datepicker/bootstrap-datepicker-thai.js')}}"></script>
		<script src="{{ URL::asset('backend/libs/bootstrap-datepicker/locales/bootstrap-datepicker.th.js')}}"></script>
		
		<script>
			v_form_status				= "";
			v_hos_id					= "";
			v_hos_name					= "";					
			v_hos_price_id				= "";
			v_hos_price_name			= "";
			v_expenses					= "";
			v_treatment_txno			= "";
			v_dummy						= 0;
			
			/* Main */				
			$(document).ready(function(){			
				// define variable
				v_form_status				= $("#form_status").val();
				v_hos_id					= ($("#treatment_hos_id").val()=='') ? '' : $("#treatment_hos_id").val();
				v_hos_name					= ($("#treatment_hos_id option:selected").html()=='') ? '' : $("#treatment_hos_id option:selected").html();					
				v_hos_price_id				= ($("#treatment_hos_price_id").val()=='') ? '' : $("#treatment_hos_price_id").val();
				v_hos_price_name			= ($("#treatment_hos_price_id option:selected").html()=='') ? '' : $("#treatment_hos_price_id option:selected").html();	;
				v_expenses					= ($('#medical_expenses').val()=='') ? '' : $('#medical_expenses').val();
				v_treatment_txno			= ($('#treatment_txno').val()=='') ? '' : $('#treatment_txno').val();				
				
				// Tx. Free
				f_call_txnogetcount($('#ref_patient_id').val());
				
				$('#treatment_hos_price_id').attr('readonly','readonly');	

				/* About Select2 Run */
				f_run_select2('group1');
				$(document).on('click', '.btn_run_select2_group1', function(){
					f_run_select2('group1');
				});

				f_run_select2('group2');
				$(document).on('click', '.btn_run_select2_group2', function(){
					f_run_select2('group2');
				});	
				
			});
			/* About Select2 */
			function f_run_select2(p1) {
				$(".c_add_select2_"+p1).each(function() {
					$(".c_add_select2_"+p1).addClass("select2-templating");
				});
				$(".select2-templating").select2();
			}

			$(".mydateth").datepicker({			
				format:'dd-mm-yyyy',  	// กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000  				
				autoclose: true			
			});
			
			$('.select2-templating').select2();
			
			/* auto 1 */
			function f_call_txnogetcount(p1) {
				// alert(p1);	
				// p1 : $('#ref_patient_id').val()
				// $('#treatment_hos_price_id').removeAttr('readonly');			
				
				$.ajax({
					// function callPatient
					url	: $('#urlTxNoGetCount').val(),
					data: {
						p_ref_patient_id 		: p1
					},
					type: 'POST',					
					success: function (result) {							
						var myJSON = JSON.parse(result);	
						// alert(myJSON.r_status);
						if(myJSON.r_status=='y'){	
							if(myJSON.r_txno > 1){							
								// $('#patient_name').val(v_patient_name);
								$('#patient_id').attr('readonly','readonly');
								$('#treatment_hos_id').attr('readonly','readonly');
							}
						}
					}
				});				
			}
			
			/* Java Script Col2 */
			/* About Patient + Tx No */
			
			/* for change patient data col 1 - 1 */
			function f_detail_patient() {	
				v_expenses = '';				
				$("#medical_expenses").val(v_expenses);
				
				v_patient_id		= $("#patient_id").val();
				v_patient_name		= $("#patient_id option:selected").html();
				
				v_form_status		= $('#form_status').val();
				v_patient_id_old	= $('#patient_id_old').val();
				
				
				f_call_detail_patient(v_patient_id, v_form_status, v_patient_id_old);
				
				// v_hos_id			= $("#treatment_hos_id").val();
				// $("#patient_id").val('');					
				// $('#patient_id').trigger('change.select2');										
			}
			$("#patient_id").on('change', f_detail_patient);
			
			/* for change patient data col 1 - support 1 */
			function f_call_detail_patient(p1, P2, P3) {
				// alert(p1);	
				$('#treatment_hos_price_id').removeAttr('readonly');
				
				$.ajax({
					// function callPatient
					url	: $('#urlPatientLink').val(),
					data: {
						p_patient_id 		: p1,
						p_form_status 		: P2, 
						p_patient_id_old 	: P3
					},
					type: 'POST',					
					success: function (result) {							
						var myJSON = JSON.parse(result);	
						// alert(myJSON.r_status);
						if(myJSON.r_status=='y'){	
							v_patient_name 		= myJSON.r_patient_name;
							v_patient_id_number = myJSON.r_patient_id_number;
							v_patient_hn_no 	= myJSON.r_patient_hn_no;
							v_patient_phone_no 	= myJSON.r_patient_phone_no;
							v_patient_sex_name 	= myJSON.r_patient_sex_name;
							v_patient_age 		= myJSON.r_patient_age;							
							v_treatment_txno	= myJSON.r_tx_no;
							v_treatment_hos_price_id	= myJSON.r_treatment_hos_price_id;
							v_hos_id					= myJSON.r_patient_id_hosp;
							v_patient_book_number3		= myJSON.r_patient_book_number3;
							v_patient_book_number5		= myJSON.r_patient_book_number5;
							// alert(v_treatment_hos_price_id);
							
							$('#patient_name').val(v_patient_name);	
							$('#patient_id_number').val(v_patient_id_number);	
							$('#patient_hn_no').val(v_patient_hn_no);	
							$('#patient_phone_no').val(v_patient_phone_no);	
							$('#patient_sex_name').val(v_patient_sex_name);	
							$('#patient_age').val(v_patient_age);	
							$('#treatment_txno').val(v_treatment_txno);		
							$('#book_number3').val(v_patient_book_number3);		
							$('#book_number5').val(v_patient_book_number5);	
							
							$('#treatment_hos_id').val(v_hos_id);		
							$('#treatment_hos_display_id').val(v_hos_id);		
							$('#treatment_hos_display_id').trigger('change.select2');
							
							// add, edit							
							if(v_treatment_txno>'1'){
								v_patient_id		= $("#patient_id").val();
								v_patient_id_old	= $('#patient_id_old').val();
								if(v_patient_id == v_patient_id_old){
									v_treatment_txno = v_treatment_txno-1;
									$('#treatment_txno').val(v_treatment_txno);
									$('#treatment_hos_price_id').removeAttr('readonly');
								}else{
									$('#treatment_hos_price_id').attr('readonly','readonly');
								}
								$("#treatment_hos_price_id").val(v_treatment_hos_price_id);
								$('#treatment_hos_price_id').trigger('change.select2');
							}else{
								$("#treatment_hos_price_id").val('');					
								$('#treatment_hos_price_id').trigger('change.select2');
								
								$('#treatment_hos_price_id').removeAttr('readonly');
							}
							
							f_call_data_price_eswl();
						}
					}
				});				
			}
			
			/* Java Script Col1 */
			
			/* About Price */
			function f_display_variable_call_ajax() {	
				alert('id : '+$('#treatment_hos_id').val());
				alert('name : '+$('#treatment_hos_id option:selected').html());
				
				alert('hos_price_id : '+$('#treatment_hos_price_id').val());
				alert('hos_price_name : '+$('#treatment_hos_price_id option:selected').html());
			}
			
			/* About Hospital + Tx No */
			function f_hos() {	
				v_hos_id			= $("#treatment_hos_id").val();	
				v_patient_id		= $("#patient_id").val();
				if(v_hos_id!="" && v_patient_id!=""){					
					/* ส่ง 1. รหัสผู้ป่วย, 2. รหัสโรงพยาบาล, เพื่อได้ */
					f_call_detail_patient(v_patient_id, v_hos_id);
				}
				f_call_data_price_eswl();
			}
			$("#treatment_hos_id").on('change', f_hos);
			/* About Tx. Free */
			function f_hos_price() {	
				v_hos_price_id			= $("#treatment_hos_price_id").val();	
				v_hos_price_name		= $("#treatment_hos_price_id option:selected").html();
				f_call_data_price_eswl();
			}
			$("#treatment_hos_price_id").on('change', f_hos_price);
			
			function f_call_data_price_eswl() {
				v_hos_id			= $("#treatment_hos_id").val();	
				v_hos_price_id		= $("#treatment_hos_price_id").val();
				v_expenses = '';
				$("#medical_expenses").val('');
				
				if(v_hos_id!="" && v_hos_price_id!=""){								
					
					$.ajax({
						url	: $('#urlLink').val(),
						data: {
							p_hos_id 			: v_hos_id,
							p_hos_price_id 		: v_hos_price_id,
							p_treatment_txno 	: v_treatment_txno
						},
						type: 'POST',					
						success: function (result) {							
							var myJSON = JSON.parse(result);							
							if(myJSON.r_status=='y'){	
								v_expenses = myJSON.r_price;
								$('#medical_expenses').val(v_expenses);
							}else{
								v_expenses = '';
								$("#medical_expenses").val(v_expenses);
							}
						}
					});	
				
				}else{
					console.log("No Data");
					v_expenses = '';
					$("#medical_expenses").val(v_expenses);
				}			
			}
			
		</script>
	@endsection