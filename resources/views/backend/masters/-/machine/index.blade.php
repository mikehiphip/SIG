@extends('backend.layouts.master')

@section('title') Urological Medical Device @endsection

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
            <h4 class="mb-0 font-size-18">Urological Medical Device</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Backend</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Masters</a></li>
                    <li class="breadcrumb-item active">Urological Medical Device </li>
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
					          <input type="text" class="form-control float-left ml-1 text-center w230 myLike" placeholder="Search Machine Type Name" name="machineType.names">
                    <input type="text" class="form-control float-left text-center w150 myLike" placeholder="Search Code" name="machinecode">
                    <input type="text" class="form-control float-left text-center w290 myLike" placeholder="Search Description" name="description">
                    <input type="text" class="form-control float-left text-center w150 myLike" placeholder="Search Machine Id" name="machineid">
                    
                  </div>
                  <div class="col-12 text-right">
                    <a class="btn btn-info btn-sm mt-1" href="{{ route('backend.masters.machine.create') }}">
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
          url: '{{ route('backend.masters.machine.datatable') }}',
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
			{data: 'id', 					title :'Action', 								className: 'text-center w60'},
            {data: 'id', 					title :'No', 									className: 'text-center w50'},           
            {data: 'machinetypename', 		title :'<center>Machine Type Name</center>', 	className: 'text-left w140'},           
            {data: 'machinecode', 			title :'<center>Code</center>', 				className: 'text-left'},
            {data: 'description', 			title :'<center>Description</center>', 			className: 'text-left'},
            {data: 'machineid', 			title :'<center>Machine Id</center>', 			className: 'text-center w100'},
            {data: 'status', 				title :'<center>Status</center>', 				className: 'text-center'},
        ],
        rowCallback: function(nRow, aData, dataIndex){
			// $('td:eq(1)', nRow).html(''					
				// + ((aData['machinecode']) ? aData['machinecode'] : '<center>-</center>') 
				// + ''
			// ).addClass('input');
			// $('td:eq(2)', nRow).html(''					
				// + ((aData['description']) ? aData['description'] : '<center>-</center>') 
				// + ''
			// ).addClass('input');
			// $('td:eq(3)', nRow).html(''					
				// + ((aData['machineid']) ? aData['machineid'] : '<center>-</center>') 
				// + ''
			// ).addClass('input');
			// $('td:eq(4)', nRow).html(''					
				// + ((aData['status']) ? aData['status'] : '<center>-</center>') 
				// + ''
			// ).addClass('input');			
			// $('td:last-child', nRow).html(''
			$('td:eq(0)', nRow).html(''
				+ '<a href="{{ route('backend.masters.machine.index') }}/'+aData['id']+'/edit" class="btn btn-sm btn-primary"><i class="bx bx-edit font-size-16 align-middle"></i></a> '
				+ '<a href="javascript: void(0);" data-url="{{ route('backend.masters.machine.index') }}/'+aData['id']+'" class="btn btn-sm btn-danger cDelete"><i class="bx bx-trash font-size-16 align-middle"></i></a>'
			).addClass('input');
        }
    });
    $('.myWhere,.myLike,.myCustom,#onlyTrashed').on('change', function(e){
		oTable.draw();
    });
});
</script>
@endsection

