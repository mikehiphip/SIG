@extends('backend.layouts.master')

@section('title') Hospital  @endsection

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
            <h4 class="mb-0 font-size-18">Hospital</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Backend</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Masters</a></li>
                    <li class="breadcrumb-item active">Hospital </li>
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
				          	<input type="text" class="form-control float-left ml-1 text-center w130 myLike" placeholder="Search Types" name="types">
                    <input type="text" class="form-control float-left text-center w250 myLike" placeholder="Search Name" name="name">
                    <input type="text" class="form-control float-left text-center w250 myLike" placeholder="Search Name Open Invoice" name="name_open_invoice">
                    <input type="text" class="form-control float-left text-center w120 myLike" placeholder="Search Tax Id" name="tax_id">
                    <input type="text" class="form-control float-left text-center w350 myLike" placeholder="Search Address" name="address">                    
                  </div>
                  <div class="col-12 text-right">
                    <a class="btn btn-info btn-sm mt-1" href="{{ route('backend.masters.hospital.create') }}">
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
          url: '{{ route('backend.masters.hospital.datatable') }}',
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
			{data: 'id', 					title :'Action', 								className: 'text-center w70'},
            {data: 'id', 					title :'Code', 									className: 'text-center w50'},           
            {data: 'types', 				title :'<center>Types</center>', 				className: 'text-left'},
            {data: 'name', 					title :'<center>Name</center>', 				className: 'text-left'},
            {data: 'name_open_invoice', 	title :'<center>name_open_invoice</center>', 	className: 'text-left'},
            {data: 'tax_id', 				title :'<center>tax_id</center>', 				className: 'text-center'},
            {data: 'tel', 					title :'<center>tel</center>', 					className: 'text-left'},            
            
        ],
        rowCallback: function(nRow, aData, dataIndex){
			$('td:eq(0)', nRow).html(''									
				+ '<a href="{{ route('backend.masters.hospital.index') }}/'+aData['id']+'/edit" class="btn btn-sm btn-primary"><i class="bx bx-edit font-size-16 align-middle"></i></a> '
				+ '<a href="javascript: void(0);" data-url="{{ route('backend.masters.hospital.index') }}/'+aData['id']+'" class="btn btn-sm btn-danger cDelete"><i class="bx bx-trash font-size-16 align-middle"></i></a>'
			).addClass('input');	
			
			$('td:eq(1)', nRow).html(''					
				+ ((aData['id']) ? aData['id'] : '<center>-</center>') 
				+ ''
			).addClass('input');
			$('td:eq(2)', nRow).html(''					
				+ ((aData['types']) ? aData['types'] : '<center>-</center>') 
				+ ''
			).addClass('input');
			$('td:eq(4)', nRow).html(''					
				+ ((aData['name_open_invoice']) ? aData['name_open_invoice'] : '<center>-</center>') 
				+ ''
			).addClass('input');
			$('td:eq(5)', nRow).html(''					
				+ ((aData['tax_id']) ? aData['tax_id'] : '<center>-</center>') 
				+ ''
			).addClass('input');
			$('td:eq(6)', nRow).html(''					
				+ ((aData['tel']) ? aData['tel'] : '<center>-</center>') 
				+ ''
			).addClass('input');
			// $('td:last-child', nRow).html('').addClass('input');
        }
    });
    $('.myWhere,.myLike,.myCustom,#onlyTrashed').on('change', function(e){
		oTable.draw();
    });
});
</script>
@endsection

