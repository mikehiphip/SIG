<div class="form-group row"><label class="col-md-12 col-form-label"><b>PROSTATE/BLADDER TUMOR SIZE DATA</b></label></div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">Prostate/Bladder tumor size</label>
	<div class="col-md-8">
		<input class="form-control" type="text" name="prostate_bladder_tumor_size" value="{{ $sRow->prostate_bladder_tumor_size??'' }}" placeholder="Prostate/Bladder tumor size" >
	</div>
	<label for="example-password-input" class="col-md-1 col-form-label">gm/cm</label>
</div>

<div class="form-group row"><label class="col-md-12 col-form-label"><b>TRANSURETHRAL PROCEDURES DATA</b></label></div>
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Transurethral procedures </label>
	<div class="col-md-9">
		<div class="outer-repeater">
			<div data-repeater-list="outer-group5" class="outer">
				<div data-repeater-item class="outer">								
					
					<div class="inner-repeater">
						<div data-repeater-list="inner-group5" class="inner form-group" >
							<!-- Loop Start -->
							@if($sDetail_TransurethralProcedures)
							@foreach($sDetail_TransurethralProcedures AS $rs) 
							<div data-repeater-item class="inner row">
								<div class="col-md-10">
									<select class="form-control c_add_select2_group5"  name="transurethral_procedures">
										<option value="">Select</option>
										@if($sTransurethralProcedures)
										@foreach($sTransurethralProcedures AS $r)
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
									<select class="form-control c_add_select2_group5"  name="transurethral_procedures">
										<option value="">Select</option>
										@if($sTransurethralProcedures)
										@foreach($sTransurethralProcedures AS $r) 
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
						<input data-repeater-create type="button" class="btn btn-success inner btn_run_select2_group5" value="Add"/>						
					</div>								
					
				</div>
			</div>
		</div>
	</div>
</div>
<div class="form-group row">
	<label class="col-md-3 col-form-label">Transurethral procedures orther</label>
	<div class="col-md-9">
		<textarea class="form-control" id="transurethral_procedures_other" name="transurethral_procedures_other" rows="4" cols="50">{{ $sRow->transurethral_procedures_other??'' }}</textarea>
	</div>
</div>

<div class="form-group row"><label class="col-md-12 col-form-label"><b>ENDOSCOPIC SHEATH DATA</b></label></div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">Endoscopic sheath #</label>
	<div class="col-md-9">
		<input class="form-control" type="text" name="endoscopic_sheath" value="{{ $sRow->endoscopic_sheath??'' }}" placeholder="Endoscopic sheath #" >
	</div>	
</div>

<div class="form-group row"><label class="col-md-12 col-form-label"><b>HOLMIUM LASER DATA</b></label></div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">Holmium laser no.</label>
	<div class="col-md-9">
		<input class="form-control" type="text" name="holmium_laser_no" value="{{ $sRow->holmium_laser_no??'' }}" placeholder="Holmium laser no." >
	</div>	
</div>	

<div class="form-group row"><label class="col-md-12 col-form-label"><b>OPTICAL FIBER SIZE DATA</b></label></div>
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Optical fiber size </label>
	<div class="col-md-9">
		<div class="outer-repeater">
			<div data-repeater-list="outer-group6" class="outer">
				<div data-repeater-item class="outer">								
					
					<div class="inner-repeater">
						<div data-repeater-list="inner-group6" class="inner form-group" >
							<!-- Loop Start -->
							@if($sConclusion_fiber_size)
							@foreach($sConclusion_fiber_size AS $rs) 
							<div data-repeater-item class="inner row">
								<div class="col-md-10">
									<select class="form-control c_add_select2_group6"  name="optical_fiber_size">
										<option value="">Select</option>
										@if($sOpticalFiberSize)
										@foreach($sOpticalFiberSize AS $r)
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
									<select class="form-control c_add_select2_group6"  name="optical_fiber_size">
										<option value="">Select</option>
										@if($sOpticalFiberSize)
										@foreach($sOpticalFiberSize AS $r) 
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
						<input data-repeater-create type="button" class="btn btn-success inner btn_run_select2_group6" value="Add"/>						
					</div>								
					
				</div>
			</div>
		</div>
	</div>
</div>

<div class="form-group row"><label class="col-md-12 col-form-label"><b>BIPOLAR RESECTOSCOPE DATA</b></label></div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">Electrode no.</label>
	<div class="col-md-9">
		<input class="form-control" type="text" name="electrode_no" value="{{ $sRow->electrode_no??'' }}" placeholder="Electrode no." >
	</div>	
</div>
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Electrode Detail. </label>
	<div class="col-md-9">
		<div class="outer-repeater">
			<div data-repeater-list="outer-group7" class="outer">
				<div data-repeater-item class="outer">								
					
					<div class="inner-repeater">
						<div data-repeater-list="inner-group7" class="inner form-group" >
							<!-- Loop Start -->
							@if($sDetail_BipolarResectoscope)
							@foreach($sDetail_BipolarResectoscope AS $rs) 
							<div data-repeater-item class="inner row">
								<div class="col-md-10">
									<select class="form-control c_add_select2_group7"  name="electrode_select">
										<option value="">Select</option>
										@if($sBipolarResectoscope)
										@foreach($sBipolarResectoscope AS $r)
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
									<select class="form-control c_add_select2_group7"  name="electrode_select">
										<option value="">Select</option>
										@if($sBipolarResectoscope)
										@foreach($sBipolarResectoscope AS $r) 
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
						<input data-repeater-create type="button" class="btn btn-success inner btn_run_select2_group7" value="Add"/>						
					</div>								
					
				</div>
			</div>
		</div>
	</div>
</div>