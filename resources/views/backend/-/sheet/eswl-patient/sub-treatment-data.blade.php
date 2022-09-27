
<div class="form-group row"><label class="col-md-12 col-form-label"><b>TREATMENT DATA</b></label></div>
@if( !empty($sRow) )
<div class="form-group row">								
	<label for="example-password-input" class="col-md-3 col-form-label">Book Reference</label>
	<div class="col-md-9">
		<input class="form-control" style="background-color:#F5F5F5;" type="text" value="{{ $sRow->book_auto_y??'' }}{{ $sRow->book_auto_m??'' }}{{ $sRow->book_auto??'' }}" readonly>
	</div>
</div>
@endif
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">เล่มที่ (3 digit)</label>
	<div class="col-md-9">
		<input class="form-control" type="text" id="book_number3" name="book_number3" value="{{ $sRow->book_number3??'' }}" placeholder="Book number (001)" >
	</div>
</div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">เลขที่ (5 digit)</label>
	<div class="col-md-9">
		<input class="form-control" type="text" id="book_number5" name="book_number5" value="{{ $sRow->book_number5??'' }}" placeholder="Book number (00001)" >
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3 col-form-label">Hospital :</label>
	<div class="col-md-9">
		<input type="hidden" id="treatment_hos_id" 	name="treatment_hos_id" value="{{ $sRow->treatment_hos_id??'' }}">
		<select class="form-control select2-templating" id="treatment_hos_display_id" disabled>
			<option value="">Select</option>
			@if($sHospital)
			@foreach($sHospital AS $r)
			<option value="{{$r->id}}"  {{ (isset($sRow) && $sRow->treatment_hos_id==$r->id)?'selected':'' }}>
				{{$r->name}} {{$r->name}} 
			</option>
			@endforeach
			@endif
		</select>
	</div>
</div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">Date</label>
	<div class="col-md-9">
		<!-- <input class="form-control" type="Date" name="treatment_date" value="{{ $sRow->treatment_date??'' }}" placeholder="Treatment Date" > -->
		<input class="form-control mydateth" type="text" 
			value="<?php echo (empty($sRow->treatment_date)?'':date_format(date_create($sRow->treatment_date), 'd-m-Y'));?>" 
			data-date-language="th-th" name="treatment_date" >
	</div>
</div>
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Lithotripter</label>
	<div class="col-md-9">
		<input class="form-control" type="text" value="{{ $sRow->treatment_lithotripter??'' }}" name="treatment_lithotripter" placeholder="Lithotripter" >
	</div>
</div>
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Tx No</label>
	<div class="col-md-9">
		<input class="form-control" style="background-color:#F5F5F5;" type="text" value="{{ $sRow->treatment_txno??'' }}" id="treatment_txno" name="treatment_txno" placeholder="Tx No" readonly >
	</div>
</div>
<div class="form-group row">
	<label class="col-md-3 col-form-label">Tx. Free :</label>
	<div class="col-md-9">
		<select class="form-control select2-templating" id="treatment_hos_price_id" name="treatment_hos_price_id" style="background-color:#F5F5F5;">
			<option value="">Select</option>
			@if($sSheetEswl)
			@foreach($sSheetEswl AS $r)
			<option value="{{$r->id}}"  {{ (isset($sRow) && $sRow->treatment_hos_price_id==$r->id)?'selected':'' }}>{{$r->name}}</option>
			@endforeach
			@endif
		</select>
	</div>
</div>
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Tx. Free Manual</label>
	<div class="col-md-9">
		<input class="form-control" type="text" value="{{ $sRow->treatment_hos_price_manual??'' }}" id="treatment_hos_price_manual" name="treatment_hos_price_manual" placeholder="Tx. Free Manual">
	</div>
</div>

<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Shock count - start</label>
	<div class="col-md-9">
		<input class="form-control" type="text" value="{{ $sRow->treatment_shock_count_start??'' }}" id="treatment_shock_count_start" name="treatment_shock_count_start" placeholder="Shock count - start">
	</div>
</div>
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Shock count - finish</label>
	<div class="col-md-9">
		<input class="form-control" type="text" value="{{ $sRow->treatment_shock_count_finish??'' }}" id="treatment_shock_count_finish" name="treatment_shock_count_finish" placeholder="Shock count - finish">
	</div>
</div>

<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Time In</label>
	<div class="col-md-9">
		<input class="form-control" type="time" value="{{ $sRow->treatment_timein??'' }}" name="treatment_timein" placeholder="Time In" >
	</div>
</div>
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Time Out</label>
	<div class="col-md-9">
		<input class="form-control" type="time" value="{{ $sRow->treatment_timeout??'' }}" name="treatment_timeout" placeholder="Time Out" >
	</div>
</div>			