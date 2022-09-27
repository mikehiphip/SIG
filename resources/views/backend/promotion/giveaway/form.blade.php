@extends('backend.layouts.layouts')

@section('content')
<section class="content">
	<div class="page-heading">
		<h1>กลุ่มของแถม</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0);">Home</a></li>
			<li><a href="javascript:void(0);">โปรโมชั่น</a></li>
			<li class="active">กลุ่มของแถม</li>
		</ol>
	</div>



	<div class="page-body">
		<div class="row clearfix">

			<div class="col-lg-12 col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">จัดการกลุ่มของแถม</div>
					<div class="panel-body">
						<form action="@if(empty($sRow)) {{ action('Backend\Promotion\GiveawayController@store') }}@else {{action('Backend\Promotion\GiveawayController@update', $sRow->id )}}@endif" method="POST" autocomplete="off">
						{{ csrf_field() }}
						@if( !empty($sRow) )<input name="_method" type="hidden" value="PUT">@endif
							<div class="row col-lg-6 col-md-6 ">

								<div class="col-sm-12">
									<div class="form-group">
										<label>ชื่อกลุ่มของแถม :</label>
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-server"></i>
											</span>
											<input type="text" class="form-control" placeholder="ชื่อกลุ่มของแถม" value="{{ $sRow->name??'' }}" name="name" />
										</div>
									</div>
								</div>
							

								
							</div>
							<div class="row col-lg-6 col-md-6 ">
								<div class="col-sm-6">
									<div class="form-group">
										<label>สถานะ :</label>
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-server"></i>
											</span>
                                    		<select class="form-control" name="status">
                                    			<option value="Y" {{ (@$sRow->status=='Y')?'selected':'' }}>ใช้งาน</option>
												<option value="N" {{ (@$sRow->status=='N')?'selected':'' }}>ไม่ใช้งาน</option>
                                    		</select>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>ประเทศ :</label>
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-server"></i>
											</span>
                                    		<select class="form-control" name="region_id">
											@if($sRegion->count())
												@foreach($sRegion AS $r)
												<option value="{{$r->rg_id}}" {{ (@$sRow->region_id==$r->rg_id)?'selected':'' }}>{{$r->rg_comment}}</option>
												@endforeach
											@endif
                                    		</select>
										</div>
									</div>
								</div>

							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 m-t-10 m-b-15 align-center">
								<button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		

		</div>
	</div>
</section>
@endsection

@push('css')


@endpush
@push('scripts')

<script>
$(function() {
    $(document).ready(function() {




   });
});


</script>
@endpush
