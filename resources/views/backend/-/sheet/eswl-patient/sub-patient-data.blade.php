<div class="form-group row"><label class="col-md-12 col-form-label"><b>PATIENT DATA</b></label></div>
<input type="hidden" id="patient_id_old" 	name="patient_id_old" value="{{ $sRow->patient_id??'' }}">
<input type="hidden" id="patient_name" 		name="patient_name" value="{{ $sRow->patient_name??'' }}">

<div class="form-group row">
	<label class="col-md-3 col-form-label">Name :</label>
	<div class="col-md-9">									
		<select class="form-control select2-templating" id="patient_id" name="patient_id" {{ (isset($sRow) && $sRow->patient_id!='')?'disabled':'' }}>
			<option value="">Select</option>
			@if($sPatient)
			@foreach($sPatient AS $r)
			<option value="{{$r->id}}"  {{ (isset($sRow) && $sRow->patient_id==$r->id)?'selected':'' }}>
				{{$r->name_pre}} {{$r->name_first}} {{$r->name_last}}  HN No : {{$r->hn_no}}
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
<!--
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Phone No</label> 
	<div class="col-md-9">
		<input class="form-control" style="background-color:#F5F5F5;" type="text" value="{{ $sRow->patient_phone_no??'' }}" id="patient_phone_no" name="patient_phone_no" placeholder="Phone No" readonly>
	</div>
</div>
-->
<input type="hidden" id="patient_phone_no" name="patient_phone_no">
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Sex</label>
	<div class="col-md-9">
		<input class="form-control" style="background-color:#F5F5F5;" type="text" value="{{ $sRow->patient_sex_name??'' }}" id="patient_sex_name" name="patient_sex_name" placeholder="Sex" readonly>
	</div>
</div>								

<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Age</label>
	<div class="col-md-9">
		<input class="form-control" style="background-color:#F5F5F5;" type="number" value="{{ $sRow->patient_age??'' }}" id="patient_age" name="patient_age" placeholder="Age" readonly>
	</div>
</div> 
<br>

<div class="form-group row"><label class="col-md-12 col-form-label"><b>STONE (S) LOCATION</b></label></div>								
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">Picture</label>
	<div class="col-md-9">
		<input class="form-control" type="file" name="image" accept="image/*" {{ isset($sRow) && !empty($sRow->thumb)?'':'' }}  />
		<!--jpeg,png,jpg,gif,svg-->
		<!--<sub>Size (Width 502 * Height 463 | jpg | ขนาดไม่เกิน 2048kb)</sub> <br>-->
	</div>									
</div>
<div class="form-group row">
	@if(isset($sRow) && !empty($sRow->thumb))
	<img width="100%" src="{{ asset('asset/images/eswlpatient/'.$sRow->thumb) }} " />
	@else
	<img width="100%" src="{{ asset('backend/images/backend/form-eswl.jpg') }} " />
	@endif
</div>


