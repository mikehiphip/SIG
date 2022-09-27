@extends('backend.layouts.master')

@section('title') Patient @endsection

@section('css')
	<!-- select2 css -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('backend/libs/select2/select2.min.css')}}">

	<!-- bootstrap-datepicker css -->
	<link href="{{ URL::asset('backend/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">
	
	<style>
		.disable-div-surgical {
			visibility: hidden;			
		}
		.disable-obj {
			visibility: hidden;			
		}
	</style>
@endsection

@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Add / Edit Patient</h4>
			
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Backend</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Masters</a></li>
                    <li class="breadcrumb-item active">Patient</li>
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
					<form action="{{ route('backend.masters.patient.store') }}" method="POST" autocomplete="off">
				@else
					<form action="{{ route('backend.masters.patient.update', $sRow->id ) }}" method="POST" autocomplete="off">
						<input name="_method" type="hidden" value="PUT">
						@endif
						{{ csrf_field() }}		
						<div class="form-group row">
							<label for="example-text-input" class="col-md-3 col-form-label"><b> Detail </b></label>
							<div class="col-md-9">&nbsp;</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-3 col-form-label">Hospital <span style="color:red;">*</span></label>
							<div class="col-md-9">
								<select class="form-control select2-templating" id="id_hosp" name="id_hosp" required>
									<option value="">Select</option>
									@if($sHospital)
									@foreach($sHospital AS $r)
									<option value="{{$r->id}}"  {{ (isset($sRow) && $sRow->id_hosp==$r->id)?'selected':'' }}>{{$r->name}}</option>
									@endforeach
									@endif
								</select>
							</div>
						</div>						
						<div class="form-group row">
							<label for="example-password-input" class="col-md-3 col-form-label">Prefix <span style="color:red;">*</span></label>
							<div class="col-md-9">
								<input class="form-control" type="text" value="{{ $sRow->name_pre??'' }}" name="name_pre" placeholder="Prefix" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-password-input" class="col-md-3 col-form-label">Name <span style="color:red;">*</span></label>
							<div class="col-md-9">
								<input class="form-control" type="text" value="{{ $sRow->name_first??'' }}" name="name_first" placeholder="Name" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-password-input" class="col-md-3 col-form-label">Surname <span style="color:red;">*</span></label>
							<div class="col-md-9">
								<input class="form-control" type="text" value="{{ $sRow->name_last??'' }}" name="name_last" placeholder="Surname" required>
							</div>
						</div>											
						<div class="form-group row">
							<label for="example-text-input" class="col-md-3 col-form-label">ID Number</label>
							<div class="col-md-9">
								<input class="form-control" type="text" value="{{ $sRow->number_id??'' }}" name="number_id" placeholder="ID Number">
							</div>
						</div>
						<div class="form-group row">
							<label for="example-text-input" class="col-md-3 col-form-label">HN No <span style="color:red;">*</span></label>
							<div class="col-md-9">
								<input class="form-control" type="text" value="{{ $sRow->hn_no??'' }}" name="hn_no" placeholder="HN No" required>
							</div>
						</div>	
						<div class="form-group row">
							<label class="col-md-3 col-form-label">Sex <span style="color:red;">*</span></label>
							<div class="col-md-9">
								<select class="form-control select2-templating" id="id_sex" name="id_sex" required>
									<option value="">Select</option>
									@if($sPatientSex)
									@foreach($sPatientSex AS $r)
									<option value="{{$r->id}}"  {{ (isset($sRow) && $sRow->id_sex==$r->id)?'selected':'' }}>{{$r->name}}</option>
									@endforeach
									@endif
								</select>
							</div>
						</div>						
						<div class="form-group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Birthday</label>
							<div class="col-md-8">							
								<input class="form-control mydateth" type="text" 
								value="<?php echo (empty($sRow->birthday)?'':date_format(date_create($sRow->birthday), 'd-m-Y'));?>" 
								data-date-language="th-th" id="process_age" name="birthday" >
							</div>
							<div class="col-md-1">
								<button type="button" class="btn btn-sm input-block-level form-control btn-danger waves-effect" id="delete_birthday">
									Delete
								</button>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Age <span style="color:red;">*</span></label>
							<div class="col-md-9">
								<input class="form-control" type="text" value="{{ $sRow->age??'' }}" 
								id="age" name="age" placeholder="Age" required>
							</div>
						</div>							
						
						<!--
						<div class="form-group row"><label class="col-md-12 col-form-label"><b>PROCEDURE DATA</b></label></div>
						<div class="form-group row">
							<?php $countoption = 0; ?>							
							@if($sTreatmentSheet)
								@foreach($sTreatmentSheet AS $r)
								<div class="col-md-4">
									<div class="form-check">
										<input class="form-check-input" id="{{$r->id}}" type="checkbox" name="treatment_sheet[]" value="{{$r->names}}" <?php echo (in_array($r->names ,$sTreatment_sheet)?'checked':'')?> ><label class="form-check-label" for="treatment_sheet"> {{$r->names}}</label><br>
									</div>
								</div>
								<?php 
									$countoption++;
									$finaloption = $countoption%4;			
								?>
								<?php if($finaloption==0){ ?>
								<div class="col-md-12"><br></div>
								<?php } ?>
								@endforeach
							@endif	
						</div><br>
						<?php // echo json_encode($sTreatmentSheet); ?>	
						-->
						<div class="form-group mb-0 row">
							<div class="col-md-6">
								<a class="btn btn-secondary btn-sm waves-effect" href="{{ route('backend.masters.patient.index') }}">
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

	<input id="check_sheet_eswl_3" type="hidden" value="<?php echo $sRow->book_number3??''; ?>" >
	<input id="check_sheet_eswl_5" type="hidden" value="<?php echo $sRow->book_number5??''; ?>" >	

	<input id="check_sheet_endo_3" type="hidden" value="<?php echo $sRow->book_number3_endo??''; ?>" >	
	<input id="check_sheet_endo_4" type="hidden" value="<?php echo $sRow->book_number4_endo??''; ?>" >	

	<input id="check_sheet_surg_3" type="hidden" value="<?php echo $sRow->book_number3_surg??''; ?>" >	
	<input id="check_sheet_surg_4" type="hidden" value="<?php echo $sRow->book_number4_surg??''; ?>" >	
	
	{{--dd($sRow->book_number3_endo)--}}
	@endsection
	
	@section('script')
	<!-- select2 -->
	<script src="{{ URL::asset('backend/libs/select2/select2.min.js')}}"></script>
	<!-- form mask -->
	<script src="{{ URL::asset('backend/libs/jquery-repeater/jquery-repeater.min.js')}}"></script>
	<!-- form mask init -->
	<script src="{{ URL::asset('backend/js/pages/form-repeater.int.js')}}"></script>
	
	<!-- bootstrap-datepicker js -->
    <script src="{{ URL::asset('backend/libs/bootstrap-datepicker/moment.min.js')}}"></script>    
    <script src="{{ URL::asset('backend/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>    
    <script src="{{ URL::asset('backend/libs/bootstrap-datepicker/bootstrap-datepicker-thai.js')}}"></script>
	<script src="{{ URL::asset('backend/libs/bootstrap-datepicker/locales/bootstrap-datepicker.th.js')}}"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"></script>-->
	<script>

		/* Main */
		$(function(){

			d_treatment			= "";

			d_sheet_eswl_3		= "";
			d_sheet_eswl_5		= "";
			d_sheet_endo_3		= "";
			d_sheet_endo_4		= "";
			d_sheet_surg_3		= "";
			d_sheet_surg_4		= "";

			d_sheet_eswl_3		= $('#check_sheet_eswl_3').val();
			d_sheet_eswl_5		= $('#check_sheet_eswl_5').val();
			d_sheet_endo_3		= $('#check_sheet_endo_3').val();
			d_sheet_endo_4		= $('#check_sheet_endo_4').val();
			d_sheet_surg_3		= $('#check_sheet_surg_3').val();
			d_sheet_surg_4		= $('#check_sheet_surg_4').val();

			
			// alert('d_sheet_eswl_3 : '+d_sheet_eswl_3);
			// alert('d_sheet_eswl_5 : '+d_sheet_eswl_5);
			// alert('d_sheet_endo_3 : '+d_sheet_endo_3);
			// alert('d_sheet_endo_4 : '+d_sheet_endo_4);			
			// alert('d_sheet_surg_3 : '+d_sheet_surg_3);
			// alert('d_sheet_surg_4 : '+d_sheet_surg_4);			
			// return false;

			jsTreatmentSheet 	= <?php echo json_encode($sTreatmentSheet); ?>;		

			f_start_status_age();
			
			$(".mydateth").datepicker({			
				format:'dd-mm-yyyy',  	// กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000  				
				autoclose: true			
			});   
			// }).datepicker("setDate", "0");   
			
			$("#process_age").on("change",function(){ 				
				var dayBirth=$(this).val();
				
				var getdayBirth=dayBirth.split("-");  
				var YB=getdayBirth[2]-543;  
				var MB=getdayBirth[1];  
				var DB=getdayBirth[0];  
				
				var setdayBirth=moment(YB+"-"+MB+"-"+DB);    
				var setNowDate=moment();  
				var yearData=setNowDate.diff(setdayBirth, 'years', true); // ข้อมูลปีแบบทศนิยม  
				var yearFinal=Math.round(setNowDate.diff(setdayBirth, 'years', true),0); // ปีเต็ม  
				var yearReal=setNowDate.diff(setdayBirth, 'years'); // ปีจริง  
				var monthDiff=Math.floor((yearData-yearReal)*12); // เดือน  
				var str_year_month=yearReal+" ปี "+monthDiff+" เดือน"; // ต่อวันเดือนปี  			
				
				 	
				if($("#process_age").val()=='' || $("#process_age").val()==null){
					$('#age').val('');
					$('#age').removeAttr('readonly');
					$('#age').removeAttr('style');
				}else{
					$("#age").val(yearReal);
					$('#age').attr('readonly','readonly');
					$('#age').attr('style','background-color:#F5F5F5;');
				}

			});  			
			
			/* step1 */
			f_check_sheet_all();	
			
			f_input_value_sheet();
		});
		
		$('.select2-templating').select2();

		/* function ไม่ใช่แล้ว */
		function getvalid(sel, arrays){ 
			// p1 : สำหรับค่าใน select option							
			var getid  		= sel.options[sel.selectedIndex].value;
			var getvalue 	= sel.options[sel.selectedIndex].text;
			// p2 : สำหรับ sheet ทั้ง3
			$.each(arrays, function (kay, value){
				// console.log(kay + ' : ' + 'index = ' + value.id + 'value = ' + value.names);
				if(value.names == getid){
					switch_data = value.id;
				}
			});																								
			
			/*
				0 : index = 2	|| value = ESWL Treatment Record
				1 : index = 4	|| value = Endourological Treatment Record
				2 : index = 5	|| value = Transurethral Surgical Treatment Record
			*/
			switch(switch_data.toString()) {
				case '2':
					$('#detail-treatment-record').html(f_add_detail_treatment(getvalue, 'เล่มที่ (3 digit)', 'book_number3', 'เลขที่ (5 digit)', 'book_number5'));
					break;
				case '4':
					$('#detail-treatment-record').html(f_add_detail_treatment(getvalue, 'เล่มที่ (3 digit)', 'book_number3_endo', 'เลขที่ (4 digit)', 'book_number4_endo'));
					break;
				case '5':
					$('#detail-treatment-record').html(f_add_detail_treatment(getvalue, 'เล่มที่ (3 digit)', 'book_number3_surg', 'เลขที่ (4 digit)', 'book_number4_surg'));
					break;
			}			
			
		}
		
		//ตัวแปรที่ใช้สำหรับการสร้าง Object Sheet
		/* 
			p1 : sheet name
			p2 : book_number1 placeholder
			p3 : book_number1 name
			p4 : book_number2 placeholder
			p5 : book_number2 name
			p6 : book_number1 function
			p7 : book_number2 function
			p8 : sheet value
		*/
		function f_add_detail_treatment(p1, p2, p3, p4, p5, p6, p7, p8){	
			// alert(p8);
			switch(p8.toString()) {
				case '2':
					var val1 = (d_sheet_eswl_3)=='undefined' ? '' : d_sheet_eswl_3;
					var val2 = (d_sheet_eswl_5)=='undefined' ? '' : d_sheet_eswl_5;
					break;
				case '4':
					var val1 = (d_sheet_endo_3)=='undefined' ? '' : d_sheet_endo_3;
					var val2 = (d_sheet_endo_4)=='undefined' ? '' : d_sheet_endo_4;
					break;
				case '5':
					var val1 = (d_sheet_surg_3)=='undefined' ? '' : d_sheet_surg_3;
					var val2 = (d_sheet_surg_4)=='undefined' ? '' : d_sheet_surg_4;
					break;
			}

			d_treatment		= d_treatment+"<div class='form-group row'>";
			d_treatment		= d_treatment+"<label for='example-text-input' class='col-md-6 col-form-label'>";
			d_treatment		= d_treatment+"<b> "+p1+" </b>";
			d_treatment		= d_treatment+"</label>";		
			d_treatment		= d_treatment+"<div class='col-md-6'>&nbsp;</div>";		
			d_treatment		= d_treatment+"</div>";
			d_treatment		= d_treatment+"<div class='form-group row'>";
			d_treatment		= d_treatment+"<label for='example-text-input' class='col-md-3 col-form-label'> "+p2+" <span style='color:red'>*</span></label>";
			d_treatment		= d_treatment+"<div class='col-md-9'>";
			d_treatment		= d_treatment+"<input onkeyup='javascript: f_"+p6+"();' class='form-control' type='text' value='"+val1+"' id='"+p6+"' name='"+p3+"' placeholder=' "+p2+" ' required>";
			d_treatment		= d_treatment+"</div>";
			d_treatment		= d_treatment+"</div>";
			d_treatment		= d_treatment+"<div class='form-group row'>";
			d_treatment		= d_treatment+"<label for='example-text-input' class='col-md-3 col-form-label'> "+p4+" <span style='color:red'>*</span></label>";
			d_treatment		= d_treatment+"<div class='col-md-9'>";
			d_treatment		= d_treatment+"<input onkeyup='javascript: f_"+p7+"();' class='form-control' type='text' value='"+val2+"' id='"+p7+"' name='"+p5+"' placeholder=' "+p4+" ' required>";
			d_treatment		= d_treatment+"</div>";
			d_treatment		= d_treatment+"</div>";

			return d_treatment;
		}
		
		function f_start_status_age(){			
			if($("#process_age").val()=='' || $("#process_age").val()==null){				
				$('#age').removeAttr('readonly');
				$('#age').removeAttr('style');
			}else{
				$('#age').attr('readonly','readonly');
				$('#age').attr('style','background-color:#F5F5F5;');
			}
		}
		
		function f_status_age(){
			// if(v_hos_id!="" && v_hos_price_id!=""){	
			if($("#process_age").val()=='' || $("#process_age").val()==null){
				$('#age').val('');
				$('#age').removeAttr('readonly');
				$('#age').removeAttr('style');
			}else{
				$('#age').attr('readonly','readonly');
				$('#age').attr('style','background-color:#F5F5F5;');
			}
		}

		function f_delete_birthday(){
			$("#process_age").val('');
			f_status_age();
		}
		$("#delete_birthday").on('click', f_delete_birthday);


		function f_input_value_sheet(){			
			// loop ว่าอันไหนเลือกไม่เลือก
			$.each(jsTreatmentSheet, function (kay, value){				
				// alert('Test : '+value.names);
				if($('#'+value.id).prop("checked")) {
					// alert('Test : '+value.id);	
					switch(value.id.toString()) {
						case '2':
							$('#detail-treatment-record').html(f_add_detail_treatment(value.names, 'เล่มที่ (3 digit)', 'book_number3', 'เลขที่ (5 digit)', 'book_number5', 'sheet_eswl_3', 'sheet_eswl_5', value.id));							
							break;
						case '4':
							$('#detail-treatment-record').html(f_add_detail_treatment(value.names, 'เล่มที่ (3 digit)', 'book_number3_endo', 'เลขที่ (4 digit)', 'book_number4_endo', 'sheet_endo_3', 'sheet_endo_4', value.id));
							break;
						case '5':
							$('#detail-treatment-record').html(f_add_detail_treatment(value.names, 'เล่มที่ (3 digit)', 'book_number3_surg', 'เลขที่ (4 digit)', 'book_number4_surg', 'sheet_surg_3', 'sheet_surg_4', value.id));
							break;
					}
				}
			});
		}

		/* step2 */
		function f_data_value_all(){
			console.log("d_sheet_eswl_3 : "	+d_sheet_eswl_3);
			console.log("d_sheet_eswl_5 : "	+d_sheet_eswl_5);
			console.log("d_sheet_endo_3 : "	+d_sheet_endo_3);
			console.log("d_sheet_endo_4 : "	+d_sheet_endo_4);
			console.log("d_sheet_surg_3 : "	+d_sheet_surg_3);
			console.log("d_sheet_surg_4 : "	+d_sheet_surg_4);			
		}

		/* step1 */	
		function f_check_sheet_all(){
			$.each(jsTreatmentSheet, function (kay, value){
				// console.log(kay + ' : ' + 'index = ' + value.id + 'value = ' + value.names);
				// $('#'+value.id).val(this.checked);				

				/* ตรวจสอบ ถ้าเลิอกแล้ว จะใส่ค่าเข้าตัวแปล sheet ทั้งหมด */ 
				$('#'+value.id).change(function() {
					d_treatment	= "";
					if(d_treatment	== ""){
						$('#detail-treatment-record').html('');
					}		
					f_input_value_sheet();
				});			
				
			});	
		}

		function f_sheet_eswl_3(){
			d_sheet_eswl_3 = $('#sheet_eswl_3').val();
			// alert('Test f_sheet_eswl_3 : '+$('#sheet_eswl_3').val());
			// f_data_value_all();
		}
		function f_sheet_eswl_5(){
			d_sheet_eswl_5 = $('#sheet_eswl_5').val();			
		}
		function f_sheet_endo_3(){
			d_sheet_endo_3 = $('#sheet_endo_3').val();			
		}
		function f_sheet_endo_4(){
			d_sheet_endo_4 = $('#sheet_endo_4').val();			
		}
		function f_sheet_surg_3(){
			d_sheet_surg_3 = $('#sheet_surg_3').val();		
		}
		function f_sheet_surg_4(){
			d_sheet_surg_4 = $('#sheet_surg_4').val();	
			f_data_value_all();		
		}
		
	</script>
@endsection