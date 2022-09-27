<div class="form-group row"><label class="col-md-12 col-form-label"><b>DETAIL DATA</b></label></div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">Date</label>
	<div class="col-md-9">
		<!-- <input class="form-control" type="Date" name="treatment_date" value="{{ $sRow->treatment_date??'' }}" placeholder="Treatment Date" > -->
		<input class="form-control mydateth" type="text" 
			value="<?php echo (empty($sRow->detail_date)?'':date_format(date_create($sRow->detail_date), 'd-m-Y'));?>" 
			data-date-language="th-th" name="detail_date" >
	</div>
</div>
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Time In</label>
	<div class="col-md-9">
		<input class="form-control" type="time" value="{{ $sRow->detail_timein??'' }}" name="detail_timein" placeholder="Time In" >
	</div>
</div>
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Time Out</label>
	<div class="col-md-9">
		<input class="form-control" type="time" value="{{ $sRow->detail_timeout??'' }}" name="detail_timeout" placeholder="Time Out" >
	</div>
</div>			