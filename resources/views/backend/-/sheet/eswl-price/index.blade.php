@extends('backend.layouts.master')

@section('title') ESWL Price @endsection

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
            <h4 class="mb-0 font-size-18">ESWL Price</h4>
			
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Backend</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Treatment Sheet</a></li>
                    <li class="breadcrumb-item active">ESWL Price </li>
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
					<div class="col-8">
						<input type="text" class="form-control float-left text-center w260 myLike" placeholder="Search Name Open Invoice" name="hospital.name_open_invoice">
						<input type="text" class="form-control float-left ml-1 text-center w260 myLike" placeholder="Search Name Sheet Eswl" name="sheetEswl.name">						
					</div>
					<div class="col-4 text-right">
						<a class="btn btn-info btn-sm mt-1" href="{{ route('backend.sheet.eswl-price.create') }}">
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
				url: '{{ route('backend.sheet.eswl-price.datatable') }}',
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
			columns: [
				{data: 'id', 						title :'<center>Action</center>', 				className: 'text-center w40'},
				{data: 'id', 						title :'<center>Code</center>', 				className: 'text-left w30'},           
				{data: 'name_open_invoice',			title :'<center>Name Open Invoice</center>', 	className: 'text-left w140'},           				
				{data: 'name_sheet_eswl',			title :'<center>Name Sheet Eswl</center>', 		className: 'text-left w140'},           				
				{data: 'price',						title :'<center>Price</center>', 				className: 'text-left w40'},
			],
			rowCallback: function(nRow, aData, dataIndex){
				// $('td:last-child', nRow).html(''
				$('td:eq(0)', nRow).html(''
					+ '<a href="{{ route('backend.sheet.eswl-price.index') }}/'+aData['id']+'/edit" class="btn btn-sm btn-primary"><i class="bx bx-edit font-size-16 align-middle"></i></a> '
					+ '<a href="javascript: void(0);" data-url="{{ route('backend.sheet.eswl-price.index') }}/'+aData['id']+'" class="btn btn-sm btn-danger cDelete"><i class="bx bx-trash font-size-16 align-middle"></i></a>'
				).addClass('input');
				$('td:eq(2)', nRow).html(''					
					+ ((aData['name_open_invoice']) ? aData['name_open_invoice'] : '<center>-</center>') 
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

