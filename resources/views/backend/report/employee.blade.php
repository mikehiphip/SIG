@extends('backend.layouts.master')

@section('title') Report Employee @endsection

@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Report Employee</h4>
			
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Backend</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                    <li class="breadcrumb-item active">Report Employee</li>
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
                <div class="row">
					<div class="col-12">
						<input type="text" class="form-control float-left ml-1 text-center w180 myLike" placeholder="ขื่อ" name="nameeng">
					</div>
					<!--
					<div class="col-12 text-right">				
						<a class="btn btn-warning btn-sm mt-1 btn-excel" href="javascript: void(0);">Export Excel รายงานค่าบริการรวม</a>					
						<a class="btn btn-success btn-sm mt-1 btn-excel-hospi" href="javascript: void(0);">Export Excel รายงานค่าบริการโรงพยาบาล</a>					
						<a class="btn btn-info btn-sm mt-1 btn-excel-physi" href="javascript: void(0);">Export Excel รายงานค่าแพทย์</a>						
					</div>
					-->
				</div>
				<div class="table-responsive">
					<table id="data-table" class="table table-bordered" style="width: 100%; min-width:100%;"></table>
				</div>
			</div>
		</div>
	</div> <!-- end col -->
</div> <!-- end row -->

@endsection

@section('css')
	<style type="text/css">		
		.search-div {
			margin-bottom	: 1px;			
		}
		input[type=text] {
			margin-bottom		: 5px;
			background-color	: #CCEFF7;
			color				: white;
		}		
	</style>
	<!-- bootstrap-datepicker css -->
	<link href="{{ URL::asset('backend/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">
@endsection

@section('script')
<!-- bootstrap-datepicker js -->
<script src="{{ URL::asset('backend/libs/bootstrap-datepicker/moment.min.js')}}"></script>    
<script src="{{ URL::asset('backend/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>    
<script src="{{ URL::asset('backend/libs/bootstrap-datepicker/bootstrap-datepicker-thai.js')}}"></script>
<script src="{{ URL::asset('backend/libs/bootstrap-datepicker/locales/bootstrap-datepicker.th.js')}}"></script>

<script>
	c_detail_date 		= '';
	c_patient_name 		= '';
	var oData;
	var oTable;
	$(function() {
		$(".mydateth").datepicker({			
			format:'dd-mm-yyyy',  	// กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000  				
			autoclose: true			
		});

		oTable = $('#data-table').DataTable({
			"sDom": "<'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
			processing: true,
			serverSide: true,
			stateSave: true,
			scroller: true,
			scrollCollapse: true,
			scrollX: true,
			ordering: false,
			scrollY: ''+($(window).height()-420)+'px',
			iDisplayLength: 25,
			ajax: {
				url: '{{ route('backend.report.employee.datatable') }}',
				data: function ( d ) {
					d.Where={};
					$('.myWhere').each(function() {
						if( $.trim($(this).val()) && $.trim($(this).val()) != '0' ){
							d.Where[$(this).attr('name')] = $.trim($(this).val());
						}
					});
					d.Like={};
					$('.myLike').each(function() {
						if( $.trim($(this).val()) && $.trim($(this).val()) != '0' ){
							if($(this).attr('name') == 'physician.names'){	
								c_patient_name = $.trim($(this).val());
							}
							d.Like[$(this).attr('name')] = $.trim($(this).val());
						}
					});
					d.Custom={};
					$('.myCustom').each(function() {
						if( $.trim($(this).val()) && $.trim($(this).val()) != '0' ){
							d.Custom[$(this).attr('name')] = $.trim($(this).val());
						}
					});
					d.DateRange={};
					/* set ไว้ ต้องมีอย่างละช่องเท่านั้น ในกรณีภาษาไทย (พ.ศ.) */
					$('.myDateRangeStop').each(function(index, value) {
						if( $.trim($(this).val()) && $.trim($(this).val()) != '0' ){
							rangef = $.trim($('.myDateRangeStart').eq(index).val())+" 00:00";
							rangec = " - ";
							rangel = $.trim($('.myDateRangeStop').eq(index).val())+" 00:00";
							if($.trim($('.myDateRangeStart').eq(index).val()) == ""){
								alert("กรุณากรอกวันที่เริ่ม");								
								$.trim($('.myDateRangeStop').eq(index).val(""))
								return false;
							}else{
								d.DateRange["detail_date"] = rangef+rangec+rangel;
								c_detail_date =  rangef+rangec+rangel;
							}							
						}
					});
					oData = d;
					// console.log('Test : '+ JSON.stringify(oData.DateRange));
				},
				method: 'POST'
			},
			columns: [
                {data: 'DT_RowIndex', 		title :'<center>#.</center>', 				className: 'text-center w50'},                
                {data: 'code', 				title :'<center>รหัสพนักงาน</center>', 			className: 'text-center w70'},				
				{data: 'prefixnameeng', 	title :'<center>คำนำหน้า </center>', 			className: 'text-left w50'},
				{data: 'nameeng', 			title :'<center>ชื่อ </center>', 				className: 'text-left w100'},				
				{data: 'lastnameeng', 		title :'<center>นามสกุล </center>', 			className: 'text-left w120'},				
				{data: 'prefixnamethai', 	title :'<center>คำนำหน้า </center>', 			className: 'text-left w50'},
				{data: 'namethai', 			title :'<center>ชื่อ </center>', 				className: 'text-left w100'},	
				{data: 'lastnamethai', 		title :'<center>นามสกุล </center>', 			className: 'text-left w120'},	
				{data: 'position_name', 	title :'<center>ตำแหน่ง</center>', 			className: 'text-left w200'},							
				{data: 'department_name', 	title :'<center>แผนก Vat</center>', 			className: 'text-left w120'},
			],
			rowCallback: function(nRow, aData, dataIndex){	
				// $('td:eq(2)', nRow).html(''					
					// + ((aData['reference_code']) ? aData['reference_code'] : '<center>-</center>') 
					// + ''
				// ).addClass('input');	

				// $('td:eq(3)', nRow).html(''					
					// + ((aData['book_number3']) ? aData['book_number3'] : '<center>-</center>') 
					// + ''
				// ).addClass('input');

				// $('td:eq(4)', nRow).html(''					
					// + ((aData['book_number5']) ? aData['book_number5'] : '<center>-</center>') 
					// + ''
				// ).addClass('input');			
			}
		});
		$('.myWhere,.myLike,.myCustom,.myDateRangeStop,#onlyTrashed').on('change', function(e){
			oTable.draw();
		});

	});
</script>
@endsection
