@extends('backend.layouts.master')

@section('title') Report Train @endsection

@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Report Train</h4>
			
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Backend</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                    <li class="breadcrumb-item active">Report Train</li>
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
					
						<div class="col-12 text-right">		
							<form method="get" action="{{url("backend/report/train/excel")}}">		
							{{-- <a class="btn btn-warning btn-sm mt-1 btn-excel" href="javascript: void(0);" onclick="send_excel();">Export Excel รายงานข้อมูลการอบรม</a>									 --}}
								<button class="btn btn-warning btn-sm mt-1 btn-excel">Export Excel รายงานข้อมูลการอบรม</button>		
							</form>						
						</div>
					
				
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
				url: '{{ route('backend.report.train.datatable') }}',
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
                {data: 'proto', 			title :'<center>รูป</center>', 				 className: 'text-left w120'},				
                {data: 'detail_emp', 		title :'<center>พนักงานที่มาอบรม</center>',   className: 'text-left w240'},				
                {data: 'vi_detail', 		title :'<center>รายละเอียดการอบรม</center>',  className: 'text-left w240'},				
				{data: 'vi_time_start', 	title :'<center>เวลาเริ่มการอบรม </center>', 	className: 'text-left w50'},
				{data: 'vi_time_stop', 		title :'<center>เวลาสิ้นสุดการอบรม </center>', 	className: 'text-left w100'},				
				{data: 'vi_time_unit', 		title :'<center>เวลาที่ใช้ในการอบรม </center>', className: 'text-left w120'},				
				{data: 'id', 				title :'<center>จัดการ </center>', 				className: 'text-center w60'},				
			
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

				
				$('td:last-child', nRow).html(''
					+ '<button type="button" onclick="sendmail('+aData['id']+');" class="btn btn-sm btn-info"><i class="bx bx-mail-send font-size-16 align-middle"></i></button> '
					+ '<button type="button" onclick="trainDel('+aData['id']+'); trainReload();" class="btn btn-sm btn-danger"><i class="bx bx-trash font-size-16 align-middle"></i></button>'
					+ ''					
				).addClass('input');
			}
		});
		$('.myWhere,.myLike,.myCustom,.myDateRangeStop,#onlyTrashed').on('change', function(e){
			oTable.draw();
		});

	});

	function send_excel(){ 
		var result = confirm("Want to export excel ?");
		if (result) {			
			// alert("Y Test : "+id);					
		
			formData = new FormData();				
							
			$.ajax({
				type		: 'GET', 			
				url			: "{{ route('backend.report.train.excel') }}",
				dataType	: 'JSON',
				data		: {

				},
				processData	: false,
				contentType : false,
				success: function(result) {}
			});
		}
	}

	function sendmail(id){ 
		var result = confirm("Want to send mail ?");
		if (result) {			
			// alert("Y Test : "+id);					
		
			formData = new FormData();		
			formData.append("id", id);		
							
			$.ajax({
				type		: 'POST', 			
				url			: "{{ route('frontend.train.sendmail') }}",
				dataType	: 'JSON',
				data		: formData,
				processData	: false,
				contentType : false,
				success: function(result) {}
			});
		}
	}

	function trainDel(id){ 
		var result = confirm("Want to delete?");
		if (result) {			
			// alert("Y Test : "+id);					
		
			formData = new FormData();		
			formData.append("id", id);		
							
			$.ajax({
				type		: 'POST', 			
				url			: "{{ route('backend.report.train.del') }}",
				dataType	: 'JSON',
				data		: formData,
				processData	: false,
				contentType : false,
				// async   : false,
				success: function(result) {}
			});
		}
	}
	function trainReload(){ 	
		// alert("Test");
		location.reload();	
	}
</script>
@endsection
