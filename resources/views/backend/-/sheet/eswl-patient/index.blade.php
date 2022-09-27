@extends('backend.layouts.master')

@section('title') ESWL Patient @endsection

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
@endsection

@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">ESWL Patient</h4>
			
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Backend</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Treatment Sheet</a></li>
                    <li class="breadcrumb-item active">ESWL Patient </li>
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
						<input type="text" class="form-control float-left text-center w180 myLike" placeholder="Search Reference Code" name="reference_code">
						<input type="text" class="form-control float-left ml-1 text-center w120 myLike" placeholder="Search Date" name="treatment_date">						
						<input type="text" class="form-control float-left ml-1 text-center w180 myLike" placeholder="Search Patient Name" name="patient_name">						
						<input type="text" class="form-control float-left ml-1 text-center w180 myLike" placeholder="Search Hospital Name" name="hospital.name">						
						<input type="text" class="form-control float-left ml-1 text-center w180 myLike" placeholder="Search Physician Name" name="physician.names">						
					</div>
					<div class="col-12 text-right">
						<a class="btn btn-info btn-sm mt-1" href="{{ route('backend.sheet.eswl-patient.create') }}">
							<i class="bx bx-plus font-size-16 align-middle mr-1"></i>Add Data
						</a>
					</div>
				</div>
				
				
				
                <table id="data-table" class="table table-bordered dt-responsive" style="width: 100%;"></table>
				
			</div>
		</div>
	</div> <!-- end col -->
</div> <!-- end row -->

@endsection

@section('script')
<script>
	var oTable;
	$(function() {
		oTable = $('#data-table').DataTable({
			"sDom": "<'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
			processing		: true,
			serverSide		: true,
			stateSave		: true,
			scroller		: true,
			scrollCollapse	: true,
			scrollX			: true,
			ordering		: false,
			scrollY			: ''+($(window).height()-420)+'px',
			iDisplayLength	: 50,
			ajax: {
				url: '{{ route('backend.sheet.eswl-patient.datatable') }}',
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
							if( $(this).attr('name') == "treatment_date"){
								var datepicker 	= $.trim($(this).val());
								var date_array 	= datepicker.split("-");
                           		var date_search = date_array[2]+"-"+date_array[1]+"-"+date_array[0];							
							
								d.Like[$(this).attr('name')] = date_search;
							}else{
								d.Like[$(this).attr('name')] = $.trim($(this).val());
							}
						}
					});
					d.Custom={};
					$('.myCustom').each(function() {
						if( $.trim($(this).val()) && $.trim($(this).val()) != '0' ){
							d.Custom[$(this).attr('name')] = $.trim($(this).val());
						}
					});
					oData = d;
				},
				method: 'POST'
			},
			columns: [     
				{data: 'id', 						title :'Action', 								className: 'text-center w80'},
				{data: 'book_auto', 				title :'<center>Reference Code</center>', 		className: 'text-center w120'},
				{data: 'treatment_date', 			title :'<center>Date</center>', 				className: 'text-center w80'},            
				{data: 'patient_name', 				title :'<center>Patient Name</center>', 		className: 'text-left w240'},
				{data: 'hospital_name', 			title :'<center>Hospital Name</center>', 		className: 'text-left w240'},
				{data: 'physician_name', 			title :'<center>Physician Name</center>', 		className: 'text-left w200'},
				{data: 'treatment_txno', 			title :'<center>Tx No.</center>',				className: 'text-center w50'},
				{data: 'medical_expenses', 			title :'<center>Expenses</center>', 			className: 'text-right w120'},
				{data: 'medical_expenses_manual', 	title :'<center>Expenses Manual</center>', 		className: 'text-right w120'},
			],
			rowCallback: function(nRow, aData, dataIndex){	
				// $('td:last-child', nRow).html(''
				$('td:eq(0)', nRow).html(''
					+ '<a href="{{ route('backend.sheet.eswl-patient.index') }}/'+aData['id']+'/edit" class="btn btn-sm btn-primary"><i class="bx bx-edit font-size-16 align-middle"></i></a> '
					+ '<a href="javascript: void(0);" data-url="{{ route('backend.sheet.eswl-patient.index') }}/'+aData['id']+'" class="btn btn-sm btn-danger cDelete"><i class="bx bx-trash font-size-16 align-middle"></i></a>'
				).addClass('input');
				
				$('td:eq(1)', nRow).html(''					
					+ aData['book_auto_y'] + aData['book_auto_m'] + aData['book_auto']
					+ ''
				).addClass('input');
				$('td:eq(2)', nRow).html(''					
					+ ((aData['treatment_date']) ? aData['treatment_date'] : '<center>-</center>') 
					+ ''
				).addClass('input');
				$('td:eq(3)', nRow).html(''					
					+ ((aData['patient_name']) ? aData['patient_name'] : '<center>-</center>') 
					+ ''
				).addClass('input');
				$('td:eq(4)', nRow).html(''					
					+ ((aData['hospital_name']) ? aData['hospital_name'] : '<center>-</center>') 
					+ ''
				).addClass('input');
				$('td:eq(5)', nRow).html(''					
					+ ((aData['physician_name']) ? aData['physician_name'] : '<center>-</center>') 
					+ ''
				).addClass('input');
				$('td:eq(6)', nRow).html(''					
					+ ((aData['treatment_txno']) ? aData['treatment_txno'] : '<center>-</center>') 
					+ ''
				).addClass('input');
				$('td:eq(7)', nRow).html(''					
					+ ((aData['medical_expenses']) ? aData['medical_expenses'] : '<center>-</center>') 
					+ ''
				).addClass('input');
				$('td:eq(8)', nRow).html(''					
					+ ((aData['medical_expenses_manual']) ? aData['medical_expenses_manual'] : '<center>-</center>') 
					+ ''
				).addClass('input');
			}
		});
		$('.myWhere,.myLike,.myCustom,#onlyTrashed').on('change', function(e){
			oTable.draw();
		});
	});
</script>
@endsection

