@extends('backend.layouts.master')

@section('title') ส่วนลดทั้งเว็บไซต์ @endsection

@section('css')

@endsection

@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">ส่วนลดทั้งเว็บไซต์</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Backend</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Promotion</a></li>
                    <li class="breadcrumb-item active">ส่วนลดทั้งเว็บไซต์</li>
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
                    <input type="text" class="form-control float-left text-center w200 myLike" placeholder="โปรโมชั่น" name="name">
                  </div>
                  <div class="col-4 text-right">
                    <a class="btn btn-info btn-sm mt-1" href="{{ route('backend.promotion.web.create') }}">
                      <i class="bx bx-plus font-size-16 align-middle mr-1"></i>เพิ่มโปรโมชั่น
                    </a>
                  </div>
                </div>



                <table id="data-table" class="table table-bordered dt-responsive" style="width: 100%;">
                </table>

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
        scroller: true,
        scrollCollapse: true,
        scrollX: true,
        ordering: false,
        scrollY: ''+($(window).height()-370)+'px',
        iDisplayLength: 25,
        ajax: {
          url: '{{ route('backend.promotion.web.datatable') }}',
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
            @if(empty(\Auth::user()->locale_id))
            {data: 'locale.name', title :'Language', className: 'text-center w100'},
            @endif
            {data: 'name', title :'โปรโมชั่น', className: 'text-center'},
            {data: 'daterange', title :'ช่วงวันที่', className: 'text-center w150'},
            {data: 'discount', title :'ส่วนลด', className: 'text-center w100'},
            {data: 'status', title :'สถานะ', className: 'text-center w60'},
            {data: 'id', title :'Action', className: 'text-center w60'},
        ],
        rowCallback: function(nRow, aData, dataIndex){
          $('td:last-child', nRow).html(''
            + '<a href="{{ route('backend.promotion.web.index') }}/'+aData['id']+'/edit" class="btn btn-sm btn-primary"><i class="bx bx-edit font-size-16 align-middle"></i></a> '
            + '<a href="javascript: void(0);" data-url="{{ route('backend.promotion.web.index') }}/'+aData['id']+'" class="btn btn-sm btn-danger cDelete"><i class="bx bx-trash font-size-16 align-middle"></i></a>'
          ).addClass('input');
        }
    });
    $('.myWhere,.myLike,.myCustom,#onlyTrashed').on('change', function(e){
      oTable.draw();
    });
});
</script>
@endsection
