<!--<div class="form-group row"><label class="col-md-12 col-form-label"><b>Medical Personnel</b></label></div>-->									
<div class="form-group row">
	<label class="col-md-3 col-form-label">Treating Physician</label>
	<div class="col-md-9">
		<select class="form-control select2-templating " id="detail_treating_physician" name="detail_treating_physician">
			<option value="">Select</option>
			@if($sPhysician)
			@foreach($sPhysician AS $r)
			<option value="{{$r->id}}"  {{ (isset($sRow) && $sRow->detail_treating_physician==$r->id)?'selected':'' }}>{{$r->names}}</option>
			@endforeach
			@endif
		</select>
	</div>
</div>								

<div class="form-group row">
	<label class="col-md-3 col-form-label">Machine Types</label>
	<div class="col-md-9">
		<select class="form-control select2-templating" id="detail_machine_types" name="detail_machine_types">
			<option value="">Select</option>
			@if($sMachine)
			@foreach($sMachine AS $r)
			<option value="{{$r->id}}"  {{ (isset($sRow) && $sRow->detail_machine_types==$r->id)?'selected':'' }}>
				{{$r->machinecode}} {{$r->description}}
			</option>
			@endforeach
			@endif
		</select>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3 col-form-label">Radiographer</label>
	<div class="col-md-9">
		<div class="outer-repeater">
			<div data-repeater-list="outer-group2" class="outer">
				<div data-repeater-item class="outer">								
					
					<div class="inner-repeater">
						<div data-repeater-list="inner-group2" class="inner form-group" >					
							
							<!-- Loop Start -->
							@if($sDetail_radiographer)
							@foreach($sDetail_radiographer AS $rs)
							<div data-repeater-item class="inner row">
								<div class="col-md-10">
									<select class="form-control c_add_select2_group2"  name="detail_radiographer">
										<option value="">Select</option>
										@if($sTechnician)
										@foreach($sTechnician AS $r)
										<option value="{{$r->id}}"  {{ ($rs==$r->id)?'selected':'' }}>{{$r->names}}</option>
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
									<select class="form-control c_add_select2_group2"  name="detail_radiographer">
										<option value="">Select</option>
										@if($sTechnician)
										@foreach($sTechnician AS $r)
										<option value="{{$r->id}}" >{{$r->names}}</option>
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
						<input data-repeater-create type="button" class="btn btn-success inner btn_run_select2_group2" value="Add"/>
					</div>								
					
				</div>
			</div>
		</div>
	</div>
</div>


<div class="form-group row">
	<label class="col-md-3 col-form-label">Assistant Radiographers</label>
	<div class="col-md-9">
		<div class="outer-repeater">
			<div data-repeater-list="outer-group3" class="outer">
				<div data-repeater-item class="outer">								
					
					<div class="inner-repeater">
						<div data-repeater-list="inner-group3" class="inner form-group" >				
							<!-- Loop Start -->		
							@if($sDetail_assistant_radiographers)
							@foreach($sDetail_assistant_radiographers AS $rs)
							<div data-repeater-item class="inner row">
								<div class="col-md-10">
									<select class="form-control c_add_select2_group3" name="detail_assistant_radiographers">
										<option value="">Select</option>
										@if($sAssistance)
										@foreach($sAssistance AS $r)
										<option value="{{$r->id}}"  {{ ($rs==$r->id)?'selected':'' }}>{{$r->driver_names}}</option>
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
									<select class="form-control c_add_select2_group3" name="detail_assistant_radiographers">
										<option value="">Select</option>
										@if($sAssistance)
										@foreach($sAssistance AS $r)
										<option value="{{$r->id}}" >{{$r->driver_names}}</option>
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
						<input data-repeater-create type="button" class="btn btn-success inner btn_run_select2_group3" value="Add"/>
					</div>								
					
				</div>
			</div>
		</div>	
	</div>
</div>						

<div class="form-group row">
	<label class="col-md-3 col-form-label">Anesthesia</label>
	<div class="col-md-9">
		<div class="outer-repeater">
			<div data-repeater-list="outer-group4" class="outer">
				<div data-repeater-item class="outer">								
					
					<div class="inner-repeater">
						<div data-repeater-list="inner-group4" class="inner form-group" >				
							<!-- Loop Start -->		
							@if($sDetail_anesthesia)
							@foreach($sDetail_anesthesia AS $rs)
							<div data-repeater-item class="inner row">
								<div class="col-md-10">
									<select class="form-control c_add_select2_group4" name="detail_anesthesia">
										<option value="">Select</option>
										@if($sAnesthesia)
										@foreach($sAnesthesia AS $r)
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
									<select class="form-control c_add_select2_group4" name="detail_anesthesia">
										<option value="">Select</option>
										@if($sAnesthesia)
										@foreach($sAnesthesia AS $r)
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
						<input data-repeater-create type="button" class="btn btn-success inner btn_run_select2_group4" value="Add"/>
					</div>								
					
				</div>
			</div>
		</div>	
	</div>
</div>
<!-- Commment For Anesthesia Other -->
<div class="form-group row">
	<label class="col-md-3 col-form-label">Anesthesia Other </label>
	<div class="col-md-9">
		<textarea class="form-control" id="detail_anesthesia_other" name="detail_anesthesia_other" rows="4" cols="50">{{ $sRow->detail_anesthesia_other??'' }}</textarea>
	</div>
</div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">Anesthesiologist</label>
	<div class="col-md-9">
		<input class="form-control" type="text" id="detail_anesthesiologist" value="{{ $sRow->detail_anesthesiologist??'' }}" name="detail_anesthesiologist" placeholder="Anesthesiologist">
	</div>
</div>