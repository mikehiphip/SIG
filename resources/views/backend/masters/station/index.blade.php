@extends('backend.layouts.master')

@section('title') Station  @endsection

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
            <h4 class="mb-0 font-size-18">{{@$depart->name}}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">                   
                    <li class="breadcrumb-item"><a href="javascript: void(0);">ข้อมูลหลัก</a></li>
                    <li class="breadcrumb-item"><a href="{{url("backend/masters/department")}}">แผนก</a> </li>
                    <li class="breadcrumb-item active">{{@$depart->name}} </li>
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
              <div class="row mb-2">
                <div class="col-md-3">
                  <select id="search_sort" name="search_sort" class="form-control myLike">
                    <option value="new_sort">เรียงตามข้อมูลใหม่ - เก่า</option>
                    <option value="old_sort">เรียงตามข้อมูลเก่า - ใหม่</option>
                    <option value="abc_sort">เรียงตามตัวอักษร ก - ฮ</option>
                    <option value="zyx_sort">เรียงตามตัวอักษร ฮ - ก</option>
                  </select>
                </div>
              </div>
                <div class="row">
                  <div class="col-12">
                    <input type="text" class="form-control float-left text-center w250 myLike" placeholder="ค้นหาตามชื่อ" name="name">
                  </div>
                  <div class="col-12 text-right">
                    <a class="btn btn-info btn-sm mt-1" href="{{ url("backend/masters/station/$main_id/create") }}">
                      <i class="bx bx-plus font-size-16 align-middle mr-1"></i>เพิ่มข้อมูล
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
    var main_id = '<?php echo $main_id ?>';
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
          url: '{{ url('backend/masters/station/datatable') }}/'+ main_id,
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
			{data: 'id', 					title :'จัดการ', 								className: 'text-center w20'},
			{data: 'DT_RowIndex', 			title :'<center>#</center>', 				className: 'text-center w20'},
            {data: 'name', 					title :'ชื่อ', 									className: 'text-left w200'},
            {data: 'created_at', 			title :'<center>วันที่เพิ่มข้อมูล</center>', 			className: 'text-center w60'},  
        ],
        rowCallback: function(nRow, aData, dataIndex){
		
			$('td:eq(0)', nRow).html(''									
				+ '<a href="{{ url('backend/masters/station/') }}/'+aData['department_id']+'/'+aData['id']+'/edit" class="btn btn-sm btn-primary"><i class="bx bx-edit font-size-16 align-middle"></i></a> '
				+ '<a href="javascript: void(0);" data-url="{{ url('backend/masters/station/destroy') }}/'+aData['id']+'" class="btn btn-sm btn-danger cDelete"><i class="bx bx-trash font-size-16 align-middle"></i></a>'
			).addClass('input');	

        }
    });
    $('.myWhere,.myLike,.myCustom,#onlyTrashed').on('change', function(e){
		oTable.draw();
    });
});
</script>
@endsection

