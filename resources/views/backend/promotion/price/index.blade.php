@extends('backend.layouts.layouts')

@section('content')
<section class="content">
	<div class="page-heading">
		<h1>ส่วนลดตามสเตปราคา</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0);">Home</a></li>
			<li><a href="javascript:void(0);">โปรโมชั่น</a></li>
			<li class="active">ส่วนลดตามสเตปราคา</li>
		</ol>
	</div>
	<div class="page-body">

		<div class="panel panel-default">
			<div class="panel-body">
				
				<div class="form-horizontal">
					<div class="form-group m-b-0 hidden-xs hidden-sm">
						<div class="col-sm-8">
							<select class="form-control pull-left w120 myWhere" name="region_id">
								<option value="">- Language -</option>
							@if($sRegion->count())
								@foreach($sRegion AS $r)
								<option value="{{$r->rg_id}}">{{$r->rg_comment}}</option>
								@endforeach
							@endif
							</select>

							
							
                              
						</div>
						<div class="col-sm-4 align-right">
                            <a class="btn btn-info btn-sm" href="{{ action("Backend\Promotion\PriceController@create") }}">เพิ่มโปรโมชั่น</a>
						</div>
					</div>
				</div>
				<table id="data-table" class="table table-bordered" width="100%"></table>
			</div>
		</div>
	
	</div>
</section>
@endsection




@push('scripts')
<script>
var oTable;
$(function() {
		oTable = $('#data-table').DataTable({
		"sDom": "<'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
        processing: true,
        serverSide: true,
        scroller: true,
		scrollCollapse: true,
        scrollX: true,
		ordering: false,
		scrollY: ''+($(window).height()-370)+'px',
		iDisplayLength: 25,
        ajax: {
			url: '{{ action("Backend\Promotion\PriceController@Datatable") }}',
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
            {data: 'region.rg_comment', title :'Language', className: 'text-center w80'},
            {data: 'promotion', title :'ประเภท', className: 'text-center w60'},
            {data: 'price', title :'ราคาที่กำหนด', className: 'text-center'},
            {data: 'discount', title :'ส่วนลด/เซตของแถม', className: 'text-center'},
            {data: 'daterange', title :'ช่วงวันที่', className: 'text-center w150'},
            {data: 'status', title :'สถานะ', className: 'text-center w60'},
            {data: 'id', title :'Action', className: 'text-center w110'},
        ],
		rowCallback: function(nRow, aData, dataIndex){
			$('td:last-child', nRow).html(''
				+ '<a href="{{ action("Backend\Promotion\PriceController@index") }}/'+aData['id']+'/edit'+(aData['deleted_at']?'?withTrashed=true':'')+'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> แก้ไข</a> '
				+ '<a data-url="{{ action("Backend\Promotion\PriceController@index") }}/'+aData['id']+'/" class="btn btn-xs btn-danger cDelete" ><i class="glyphicon glyphicon-remove"></i> ลบ</a>'
			).addClass('input');
		}
    });
	$('.myWhere,.myLike,.myCustom,#onlyTrashed').on('change', function(e){
		oTable.draw();
	});
});
</script>
@endpush

