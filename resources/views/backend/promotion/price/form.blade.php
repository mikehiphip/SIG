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
		<div class="row clearfix">

			<div class="col-lg-12 col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">จัดส่วนลดตามสเตปราคา</div>
					<div class="panel-body">
						<form action="@if(empty($sRow)) {{ action('Backend\Promotion\PriceController@store') }}@else {{action('Backend\Promotion\PriceController@update', $sRow->id )}}@endif" method="POST" autocomplete="off">
						{{ csrf_field() }}
						@if( !empty($sRow) )<input name="_method" type="hidden" value="PUT">@endif
							<div class="row col-lg-6 col-md-6 ">

								<div class="col-sm-12">
									<div class="form-group">
										<label>ราคาที่กำหนด :</label>
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-server"></i>
											</span>
											<input type="text" class="form-control" placeholder="ราคาที่กำหนด" value="{{ $sRow->price??'' }}" name="price" />
										</div>
									</div>
									<div class="form-group">
										<label>ประเภทโปรโมชั่น :</label>
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-server"></i>
											</span>
                                    		<select class="form-control" name="promotion">
                                    			<option value="D" {{ (@$sRow->promotion=='D')?'selected':'' }}>เมื่อเข้าเงื่อนไขได้ส่วนลด</option>
                                    			<option value="B" {{ (@$sRow->promotion=='B')?'selected':'' }}>เมื่อเข้าเงื่อนไขได้ของแถม</option>
                                    		</select>
										</div>
									</div>
									<div class="form-group">
										<label>ช่วงวันที่ :</label>
										<div class="input-group">
											<span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
											</span>
                                        	<input type="text" class="form-control daterange" name="daterange" value="{{ isset($sRow)?$sRow->date_start.' - '.$sRow->date_end:'' }}" readonly="" />
										</div>
									</div>
								</div>
							

								
							</div>
							<div class="row col-lg-6 col-md-6 ">
							
								<div class="col-sm-6 discount">
									<div class="form-group">
										<label>ประเภทส่วนลด :</label>
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-server"></i>
											</span>
                                    		<select class="form-control" name="type">
                                    			<option value="P" {{ (@$sRow->type=='P')?'selected':'' }}>ส่วนลด %</option>
												<option value="B" {{ (@$sRow->type=='B')?'selected':'' }}>ส่วนลด บาท</option>
                                    		</select>
										</div>
									</div>
								</div>
								<div class="col-sm-6 discount">
									<div class="form-group">
										<label>ยอดส่วนลด	 :</label>
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-server"></i>
											</span>
											<input type="text" class="form-control" placeholder="ยอดส่วนลด" value="{{ $sRow->discount??'' }}" name="discount" />
										</div>
									</div>
								</div>

								<div class="col-sm-12 giveaway">
									<div class="form-group">
										<label>เซตของแถม :</label>
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-server"></i>
											</span>
                                    		<select class="form-control" name="giveaway_id">
											@if($sGiveaway->count())
												@foreach($sGiveaway AS $r)
												<option value="{{$r->id}}" {{ (@$sRow->giveaway_id==$r->id)?'selected':'' }}>{{$r->name}}</option>
												@endforeach
											@endif
                                    		</select>
										</div>
									</div>
								</div>

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
<!-- Bootstrap DateRangePicker Css -->
<link href="{!!asset('/public/backend/assets/plugins/bootstrap-daterangepicker/daterangepicker.css')!!}" rel="stylesheet" />
<style>
.codeinput input{
	padding:3px 0px;height:auto;background-color:transparent !important;border:transparent;
}
</style>
@endpush
@push('scripts')
<!-- MomentJs -->
<script src="{!!asset('/public/backend/assets/plugins/moment/moment.js')!!}"></script>
<!-- Bootstrap DateRangePicker Js -->
<script src="{!!asset('/public/backend/assets/plugins/bootstrap-daterangepicker/daterangepicker.js')!!}"></script>
<script>
$(function() {
    $(document).ready(function() {

            $('select[name="promotion"]').on('change', function(){    
                if($(this).val()=='D'){
                    $('.discount').show();
                    $('.giveaway').hide();
                }else{
                    $('.discount').hide();
                    $('.giveaway').show();
                }
            });
            
            if($('select[name="promotion"]').val()=='D'){
                $('.discount').show();
                $('.giveaway').hide();
            }else{
	            $('.discount').hide();
	            $('.giveaway').show();
            }


            $('.daterange').daterangepicker({
            	timePicker: true,
                ranges: {
                    "Today": [
                        "{{ date('Y/m/d') }}", "{{ date('Y/m/d') }}"
                    ],
                    "Yesterday": [
                        "{{ General::PlusDay(date('Y/m/d'),'-1') }}", "{{ General::PlusDay(date('Y/m/d'),'-1') }}"
                    ],
                    "Last 7 Days": [
                        "{{ General::PlusDay(date('Y/m/d'),'-7') }}", "{{ date('Y/m/d') }}"
                    ],
                    "Last 30 Days": [
                        "{{ General::PlusDay(date('Y/m/d'),'-30') }}", "{{ date('Y/m/d') }}"
                    ],
                    "This Month": [
                        "{{ date('Y/m/').'01' }}", "{{ date('Y/m/t') }}"
                    ],
                    "Last Month": [
                        "{{ date('Y/m/', strtotime('last month')).'01' }}", "{{ date('Y/m/t', strtotime('last month')) }}"
                    ]
                },
                showCustomRangeLabel: false,
                alwaysShowCalendars: true,
                @if( empty($sRow) )
                startDate: "{{ date('Y/m/d') }}",
                endDate: "{{ General::PlusDay(date('Y/m/d'),'+60') }}",
                @endif
                drops: "down",
                opens: "left",
                applyClass: "btn-primary",
                locale: {
                    format: 'YYYY/MM/DD HH:mm:ss'
                }
            });








   });
});


</script>
@endpush
