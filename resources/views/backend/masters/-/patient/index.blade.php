@extends('backend.layouts.master')

@section('title') Patient  @endsection

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
            <h4 class="mb-0 font-size-18">Patient</h4>
			
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Backend</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Masters</a></li>
                    <li class="breadcrumb-item active">Patient </li>
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
                <div class="row search-div">
					<div class="col-12">
						<input type="text" class="form-control float-left ml-1 text-center w140 myLike" placeholder="Search Code" name="code">
						<input type="text" class="form-control float-left ml-1 text-center w220 myLike" placeholder="Search Hospital Name" name="hospital.name">						
						<input type="text" class="form-control float-left ml-1 text-center w220 myLike" placeholder="Search Full Name" name="name_full">						
						<input type="text" class="form-control float-left ml-1 text-center w120 myLike" placeholder="Search HN No" name="hn_no">												
					</div>					
				</div>
				<div class="row search-div">					
					<div class="col-12">						
						<input type="text" class="form-control float-left ml-1 text-center w140 myLike" placeholder="Search ESWL เลขที่" name="book_number3">						
						<input type="text" class="form-control float-left ml-1 text-center w140 myLike" placeholder="Search ESWL เล่มที่" name="book_number5">						
						<input type="text" class="form-control float-left ml-1 text-center w200 myLike" placeholder="Search Endourologic เล่มที่" name="book_number3_endo">						
						<input type="text" class="form-control float-left ml-1 text-center w200 myLike" placeholder="Search Endourologic เล่มที่" name="book_number4_endo">						
						<input type="text" class="form-control float-left ml-1 text-center w200 myLike" placeholder="Search Surgical เล่มที่" name="book_number3_surg">						
						<input type="text" class="form-control float-left ml-1 text-center w200 myLike" placeholder="Search Surgical เล่มที่" name="book_number4_surg">						
					</div>					
				</div>
				<div class="row">					
					<div class="col-12 text-right">
						<a class="btn btn-info btn-sm mt-1" href="{{ route('backend.masters.patient.create') }}">
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
			responsive		: true,
			scrollY: ''+($(window).height()-460)+'px',			
			iDisplayLength: 25,
			ajax: {
				url: '{{ route('backend.masters.patient.datatable') }}',
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
							d.Like[$(this).attr('name')] = $.trim($(this).val());
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
			// https://datatables.net/extensions/responsive/examples/display-control/init-classes.html
			columns: [            
				{data: 'actions', 			title :'Action', 								className: 'text-center all w80'},
				{data: 'code', 				title :'<center>Code</center>', 				className: 'text-center w100'},           
				{data: 'hospitalname', 		title :'<center>Hospital Name</center>', 		className: 'text-left w220'},           
				{data: 'name_first',		title :'<center>Full Name</center>', 			className: 'text-left w220'},            
				{data: 'hn_no', 			title :'<center>HN No</center>', 				className: 'text-left w100'},
				{data: 'book_number3', 		title :'<center>เลขที่ eswl</center>', 			  className: 'text-left none w200'},                    
				{data: 'book_number5', 		title :'<center>เล่มที่ eswl</center>', 		   className: 'text-left none w200'},                                
				{data: 'book_number3_endo', title :'<center>เล่มที่ endourologic</center>',    className: 'text-left none w200'},                                
				{data: 'book_number4_endo', title :'<center>เล่มที่ endourologic</center>',    className: 'text-left none w200'},                                
				{data: 'book_number3_surg',	title :'<center>เล่มที่ surgical</center>', 	   className: 'text-left none w200'},                                
				{data: 'book_number4_surg', title :'<center>เล่มที่ surgical</center>', 	   className: 'text-left none w200'},                                
				{data: 'treatment_sheet', 	title :'<center>Treatment Sheet</center>',	    className: 'text-left none'}, 
			],
			rowCallback: function(nRow, aData, dataIndex){
			
				$('td:eq(2)', nRow).html(''					
					+ ((aData['hospitalname']) ? aData['hospitalname'] : '<center>-</center>') 
					+ ''
				).addClass('input');
				$('td:eq(3)', nRow).html(''					
					+ ((aData['name_pre']) ? aData['name_pre'] : '') 
					+ ' ' 
					+ ((aData['name_first']) ? aData['name_first'] : '') 
					+ ' ' 
					+ ((aData['name_last']) ? aData['name_last'] : '') 
					+ ''
				).addClass('input');	
				$('td:eq(4)', nRow).html(''					
					+ ((aData['hn_no']) ? aData['hn_no'] : '<center>-</center>') 
					+ ''
				).addClass('input');
				$('td:eq(5)', nRow).html(''					
					+ ((aData['book_number3']) ? aData['book_number3'] : '<center>-</center>') 
					+ ''
				).addClass('input');
				$('td:eq(6)', nRow).html(''										
					+ ((aData['book_number5']) ? aData['book_number5'] : '<center>-</center>') 
					+ ''
				).addClass('input');		
				$('td:eq(7)', nRow).html(''					
					+ ((aData['treatment_sheet']) ? aData['treatment_sheet'] : '<center>-</center>') 
					+ ''
				).addClass('input');			
				// $('td:last-child', nRow).html(''
					// + '<a href="{{ route('backend.masters.patient.index') }}/'+aData['id']+'/edit" class="btn btn-sm btn-primary"><i class="bx bx-edit font-size-16 align-middle"></i></a> '
					// + '<a href="javascript: void(0);" data-url="{{ route('backend.masters.patient.index') }}/'+aData['id']+'" class="btn btn-sm btn-danger cDelete"><i class="bx bx-trash font-size-16 align-middle"></i></a>'
				// ).addClass('input');				
			}
		});
		$('.myWhere,.myLike,.myCustom,#onlyTrashed').on('change', function(e){
			oTable.draw();
		});
	});
</script>
@endsection

