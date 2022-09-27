<div class="form-group row"><label class="col-md-12 col-form-label"><b>MEDICAL PERSONNEL</b></label></div>									
<div class="form-group row">
	<label class="col-md-4 col-form-label">Treating Physician :</label>
	<div class="col-md-8">
		<select class="form-control select2-templating" id="medical_treating_physician" name="medical_treating_physician">
			<option value="">Select</option>
			@if($sPhysician)
			@foreach($sPhysician AS $r)
			<option value="{{$r->id}}"  {{ (isset($sRow) && $sRow->medical_treating_physician==$r->id)?'selected':'' }}>{{$r->names}}</option>
			@endforeach
			@endif
		</select>
	</div>
</div>								

<div class="form-group row">
	<label class="col-md-4 col-form-label">Machine Types :</label>
	<div class="col-md-8">
		<select class="form-control select2-templating" id="medical_machine_types" name="medical_machine_types">
			<option value="">Select</option>
			@if($sMachine)
			@foreach($sMachine AS $r)
			<option value="{{$r->id}}"  {{ (isset($sRow) && $sRow->medical_machine_types==$r->id)?'selected':'' }}>
				{{$r->machinecode}} {{$r->description}}
			</option>
			@endforeach
			@endif
		</select>
	</div>
</div>

<div class="outer-repeater">
	<div data-repeater-list="outer-group1" class="outer">
		<div data-repeater-item class="outer">								
			
			<div class="inner-repeater">
				<div data-repeater-list="inner-group1" class="inner form-group" >
					<label class="col-form-label">Radiographer :</label>
					
					<!-- Loop Start -->
					@if($sMedical_radiographer)
					@foreach($sMedical_radiographer AS $rs)
					<div data-repeater-item class="inner row">
						<div class="col-md-10">
							<select class="form-control c_add_select2_group1"  name="medical_radiographer">
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
							<select class="form-control c_add_select2_group1"  name="medical_radiographer">
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
				<input data-repeater-create type="button" class="btn btn-success inner btn_run_select2_group1" value="Add"/>
			</div>								
			
		</div>
	</div>
</div>
<br>								

<div class="outer-repeater">
	<div data-repeater-list="outer-group2" class="outer">
		<div data-repeater-item class="outer">								
			
			<div class="inner-repeater">
				<div data-repeater-list="inner-group2" class="inner form-group" >
					<label class="col-form-label">Assistant Radiographers :</label>
					<!-- Loop Start -->		
					@if($sMedical_assistant_radiographers)
					@foreach($sMedical_assistant_radiographers AS $rs)
					<div data-repeater-item class="inner row">
						<div class="col-md-10">
							<select class="form-control c_add_select2_group2" name="medical_assistant_radiographers">
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
							<select class="form-control c_add_select2_group2" name="medical_assistant_radiographers">
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
				<input data-repeater-create type="button" class="btn btn-success inner btn_run_select2_group2" value="Add"/>
			</div>								
			
		</div>
	</div>
</div>								
<br>

<div class="form-group row"><label class="col-md-12 col-form-label"><b>STONE (S) SIZE</b></label></div>								
<div class="form-group row">
	<label for="example-password-input" class="col-md-4 col-form-label">Stone 1 Size (h x w) mm.</label>
	<div class="col-md-8">
		<input class="form-control" type="text" id="stone_size_1" value="{{ $sRow->stone_size_1??'' }}" name="stone_size_1" placeholder="Stone 1 Size (h x w) mm.">
	</div>
</div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-4 col-form-label">Stone 2 Size (h x w) mm.</label>
	<div class="col-md-8">
		<input class="form-control" type="text" id="stone_size_2" value="{{ $sRow->stone_size_2??'' }}" name="stone_size_2" placeholder="Stone 2 Size (h x w) mm.">
	</div>
</div>