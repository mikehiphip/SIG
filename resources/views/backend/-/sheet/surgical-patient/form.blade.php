@extends('backend.layouts.master')

@section('title') Add / Edit Surgical @endsection

@section('css')
	<!-- select2 css -->
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
            <h4 class="mb-0 font-size-18">Add / Edit Surgical</h4>
			
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Backend</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Treatment Sheet</a></li>
                    <li class="breadcrumb-item active">Surgical</li>
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
					<form action="{{ route('backend.sheet.surgical-patient.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
				@else
					<form action="{{ route('backend.sheet.surgical-patient.update', $sRow->id ) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
					<input name="_method" type="hidden" value="PUT">
				@endif
						{{ csrf_field() }}												
						<input type="hidden" value="{{url('backend/sheet/surgical-patient/callpatient')}}"  	id="urlPatientLink"> 												
						<input type="hidden" value="{{ $sRow->patient_id??'' }}" id="ref_patient_id">						
						<div class="row">						
							
							<div class="col-md-12">
								<!-- 1 C -->
								@include('backend.sheet.surgical-patient.sub-toppic-data')
								<br>
							</div>
							
							<div class="col-md-12">							
								<!-- 2 PATIENT DATA 
									1. Payment
									--> 
								@include('backend.sheet.surgical-patient.sub-patient-data')								
								<br>
							</div>							
							
							<div class="col-md-12">							
								<!-- DETAIL DATA --> 
								<!-- 3 C -->
								@include('backend.sheet.surgical-patient.sub-detail-data')	
								<!-- 4
									2. Radiographer
									3. Assistant Radiographers
									4. Anesthesia
								-->
								@include('backend.sheet.surgical-patient.sub-medical-personnel')								
								<br>
							</div>	
							
							<div class="col-md-12">							
								<!-- Conclusion 5. Data Fiber size C --> 
								@include('backend.sheet.surgical-patient.sub-surgical-detail')								
								<br>
							</div>
							
							<div class="col-md-12">							
								<!-- Conclusion 5. Data Fiber size C --> 
								@include('backend.sheet.surgical-patient.sub-conclusion-data')								
								<br>
							</div>
							
							<div class="col-md-12">							
								<!-- Teatment result data C --> 
								@include('backend.sheet.surgical-patient.sub-teatment-result-data')								
								<br>
							</div>
							
							<div class="col-md-12">
								<div class="form-group row"><label class="col-md-12 col-form-label"><b>	TREATMENT FREE DATA</b></label></div>
								<div class="form-group row">
									<label for="example-password-input" class="col-md-3 col-form-label">Treatment free</label>
									<div class="col-md-9">
										<input class="form-control" type="text" name="treatment_free" value="{{ $sRow->treatment_free??'' }}" placeholder="Treatment free" required>
									</div>	
								</div>
							</div>
						</div>						
						
						<div class="form-group mb-0 row"><br></div>
						
						<div class="form-group mb-0 row">
							<div class="col-md-6">
								<a class="btn btn-secondary btn-sm waves-effect" href="{{ route('backend.sheet.surgical-patient.index') }}">
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
				// v_form_status				= $("#form_status").val();
				// v_hos_id					= ($("#treatment_hos_id").val()=='') ? '' : $("#treatment_hos_id").val();
				// v_hos_name					= ($("#treatment_hos_id option:selected").html()=='') ? '' : $("#treatment_hos_id option:selected").html();					
				// v_hos_price_id				= ($("#treatment_hos_price_id").val()=='') ? '' : $("#treatment_hos_price_id").val();
				// v_hos_price_name			= ($("#treatment_hos_price_id option:selected").html()=='') ? '' : $("#treatment_hos_price_id option:selected").html();	;
				// v_expenses					= ($('#medical_expenses').val()=='') ? '' : $('#medical_expenses').val();
				// v_treatment_txno			= ($('#treatment_txno').val()=='') ? '' : $('#treatment_txno').val();				
				
				// Tx. Free
				// f_call_txnogetcount($('#ref_patient_id').val());

				 /* About Select2 Run */
				 f_run_select2('group1');
				$(document).on('click', '.btn_run_select2_group1', function(){
					f_run_select2('group1');
				});

				f_run_select2('group2');
				$(document).on('click', '.btn_run_select2_group2', function(){
					f_run_select2('group2');
				});

				f_run_select2('group3');
				$(document).on('click', '.btn_run_select2_group3', function(){
					f_run_select2('group3');
				});

				f_run_select2('group4');
				$(document).on('click', '.btn_run_select2_group4', function(){
					f_run_select2('group4');
				});

				f_run_select2('group5');
				$(document).on('click', '.btn_run_select2_group5', function(){
					f_run_select2('group5');
				});

				f_run_select2('group6');
				$(document).on('click', '.btn_run_select2_group6', function(){
					f_run_select2('group6');
				});

				f_run_select2('group7');
				$(document).on('click', '.btn_run_select2_group7', function(){
					f_run_select2('group7');
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
			
			/* Java Script Col2 */
			
			/* for change patient data col 1 - 1 */
			function f_detail_patient() {								
				v_patient_id		= $("#patient_id").val();
				v_patient_name		= $("#patient_id option:selected").html();
				
				f_call_detail_patient(v_patient_id);
			}
			$("#patient_id").on('change', f_detail_patient);
			
			/* for change patient data col 1 - support 1 */
			function f_call_detail_patient(p1) {
				// alert(p1);	
				$.ajax({
					// function callPatient
					url	: $('#urlPatientLink').val(),
					data: {
						p_patient_id 		: p1
					},
					type: 'POST',					
					success: function (result) {							
						var myJSON = JSON.parse(result);	
						// alert(myJSON.r_patient_book_number3);
						// alert(myJSON.r_patient_book_number3);
						if(myJSON.r_status=='y'){	
							v_patient_name 		= myJSON.r_patient_name;
							v_patient_id_number = myJSON.r_patient_id_number;
							v_patient_hn_no 	= myJSON.r_patient_hn_no;
							v_patient_phone_no 	= myJSON.r_patient_phone_no;
							v_patient_sex_name 	= myJSON.r_patient_sex_name;
							v_patient_age 		= myJSON.r_patient_age;							
							v_patient_birthday	= myJSON.r_patient_birthday;
							v_patient_book_number3	= myJSON.r_patient_book_number3;
							v_patient_book_number4	= myJSON.r_patient_book_number4;
							v_hos_id				= myJSON.r_patient_id_hosp;							
							
							$('#patient_name').val(v_patient_name);	
							$('#patient_id_number').val(v_patient_id_number);	
							$('#patient_hn_no').val(v_patient_hn_no);	
							$('#patient_phone_no').val(v_patient_phone_no);	
							$('#patient_sex_name').val(v_patient_sex_name);	
							$('#patient_age').val(v_patient_age);	
							$('#patient_birthdate').val(v_patient_birthday);	
							$('#book_number3_surg').val(v_patient_book_number3);	
							$('#book_number4_surg').val(v_patient_book_number4);
							
							$('#detail_hos_id').val(v_hos_id);		
							$('#detail_hos_detail_id').val(v_hos_id);		
							$('#detail_hos_detail_id').trigger('change.select2');
						}
					}
				});				
			}
			
		</script>
	@endsection