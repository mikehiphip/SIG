<div class="form-group row"><label class="col-md-12 col-form-label"><b>PATIENT DATA</b></label></div>
<input type="hidden" id="patient_id_old" 	name="patient_id_old" value="{{ $sRow->patient_id??'' }}">
<input type="hidden" id="patient_name" 		name="patient_name" value="{{ $sRow->patient_name??'' }}">

<div class="form-group row">
	<label class="col-md-3 col-form-label">Hospital :</label>
	<div class="col-md-9">
		<input type="hidden" id="detail_hos_id" name="detail_hos_id" value="{{ $sRow->detail_hos_id??'' }}">
		<select class="form-control select2-templating" id="detail_hos_detail_id" disabled>
			<option value="">Select</option>
			@if($sHospital)
			@foreach($sHospital AS $r)
			<option value="{{$r->id}}"  {{ (isset($sRow) && $sRow->detail_hos_id==$r->id)?'selected':'' }}>
				{{$r->name}} {{$r->name_open_invoice}}
			</option>
			@endforeach
			@endif
		</select>
	</div>
</div>
<div class="form-group row">
	<label class="col-md-3 col-form-label">Name :</label>
	<div class="col-md-9">									
		<select class="form-control select2-templating" id="patient_id" name="patient_id" {{ (isset($sRow) && $sRow->patient_id!='')?'disabled':'' }}>
			<option value="">Select</option>
			@if($sPatient)
			@foreach($sPatient AS $r)
			<option value="{{$r->id}}"  {{ (isset($sRow) && $sRow->patient_id==$r->id)?'selected':'' }}>
				{{$r->name_pre}} {{$r->name_first}} {{$r->name_last}}
			</option>
			@endforeach
			@endif
		</select>
	</div>
</div>
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">ID Number</label>
	<div class="col-md-9">										
		<input class="form-control" style="background-color:#F5F5F5;" type="text" value="{{ $sRow->patient_id_number??'' }}" id="patient_id_number" name="patient_id_number" placeholder="ID Number" readonly>
	</div>
</div>
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">HN No</label>
	<div class="col-md-9">
		<input class="form-control" style="background-color:#F5F5F5;" type="text" value="{{ $sRow->patient_hn_no??'' }}" id="patient_hn_no" name="patient_hn_no" placeholder="HN No" readonly>
	</div>
</div>								
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Phone No</label> 
	<div class="col-md-9">
		<input class="form-control" style="background-color:#F5F5F5;" type="text" value="{{ $sRow->patient_phone_no??'' }}" id="patient_phone_no" name="patient_phone_no" placeholder="Phone No" readonly>
	</div>
</div>
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Sex</label>
	<div class="col-md-9">
		<input class="form-control" style="background-color:#F5F5F5;" type="text" value="{{ $sRow->patient_sex_name??'' }}" id="patient_sex_name" name="patient_sex_name" placeholder="Sex" readonly>
	</div>
</div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">Birthdate</label>
	<div class="col-md-9">
		<!-- <input class="form-control" type="Date" name="treatment_date" value="{{ $sRow->treatment_date??'' }}" placeholder="Treatment Date" > -->
		<input class="form-control mydateth" style="background-color:#F5F5F5;" type="text" 
		value="<?php echo (empty($sRow->patient_birthdate)?'':date_format(date_create($sRow->patient_birthdate), 'd-m-Y'));?>" 
		data-date-language="th-th" id="patient_birthdate" name="patient_birthdate" readonly>
	</div>
</div>
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Age</label>
	<div class="col-md-9">
		<input class="form-control" style="background-color:#F5F5F5;" type="number" value="{{ $sRow->patient_age??'' }}" id="patient_age" name="patient_age" placeholder="Age" readonly>
	</div>
</div>
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Payment </label>
	<div class="col-md-9">
		<div class="outer-repeater">
			<div data-repeater-list="outer-group1" class="outer">
				<div data-repeater-item class="outer">								
					
					<div class="inner-repeater">
						<div data-repeater-list="inner-group1" class="inner form-group" >
							<!-- Loop Start -->
							@if($sDetail_payment)
							@foreach($sDetail_payment AS $rs) 
							<div data-repeater-item class="inner row">
								<div class="col-md-10">
									<select class="form-control c_add_select2_group1"  name="detail_payment">
										<option value="">Select</option>
										@if($sPayment)
										@foreach($sPayment AS $r)
										<option value="{{$r->id}}"  {{ ($rs==$r->id)?'selected':'' }}>{{$r->name}}</option>
										@endforeach
										@endif
									</select>
								</div>
								<div class="col-md-2">
									<input data-repeater-delete type="button" class="btn btn-primary btn-block inner" style="margin-bottom: 5%" value="Delete"/>
								</div>	
								<br><br>													
							</div>
							@endforeach
							@else
							<div data-repeater-item class="inner row">
								<div class="col-md-10">
									<select class="form-control c_add_select2_group1"  name="detail_payment">
										<option value="">Select</option>
										@if($sPayment)
										@foreach($sPayment AS $r) 
										<option value="{{$r->id}}" >{{$r->name}}</option>
										@endforeach
										@endif
									</select>
								</div>
								<div class="col-md-2">
									<input data-repeater-delete type="button" class="btn btn-primary btn-block inner" style="margin-bottom: 5%" value="Delete"/>
								</div>	
								<br><br>													
							</div>
							@endif
							<!-- Loop End -->
							
						</div>
						<input data-repeater-create type="button" class="btn btn-success inner btn_run_select2_group1" value="Add"/>
						<!--<input data-repeater-create type="button" class="btn btn-success inner" onclick="f_run_select2()" value="Add"/>-->
					</div>								
					
				</div>
			</div>
		</div>
	</div>
</div>
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Payment Other</label>
	<div class="col-md-9">
		<textarea class="form-control" id="detail_payment_other" name="detail_payment_other" rows="4" cols="50"></textarea>
	</div>
</div>