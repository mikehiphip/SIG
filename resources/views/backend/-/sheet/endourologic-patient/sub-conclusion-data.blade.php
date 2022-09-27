<div class="form-group row"><label class="col-md-12 col-form-label"><b>CONCLUSION DATA</b></label></div>
<div class="form-group row">
	<label for="example-text-input" class="col-md-3 col-form-label">Fiber size </label>
	<div class="col-md-9">
		<div class="outer-repeater">
			<div data-repeater-list="outer-group5" class="outer">
				<div data-repeater-item class="outer">								
					
					<div class="inner-repeater">
						<div data-repeater-list="inner-group5" class="inner form-group" >
							<!-- Loop Start -->
							@if($sConclusion_fiber_size)
							@foreach($sConclusion_fiber_size AS $rs) 
							<div data-repeater-item class="inner row">
								<div class="col-md-10">
									<select class="form-control c_add_select2_group5"  name="conclusion_fiber_size">
										<option value="">Select</option>
										@if($sFiberSize)
										@foreach($sFiberSize AS $r)
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
									<select class="form-control c_add_select2_group5"  name="conclusion_fiber_size">
										<option value="">Select</option>
										@if($sFiberSize)
										@foreach($sFiberSize AS $r) 
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
						<!--<input data-repeater-create type="button" class="btn btn-success inner" onclick="f_run_select2()" value="Add"/>-->
					</div>								
					
				</div>
			</div>
		</div>
	</div>
</div>
<!--
<div class="form-group row"><label class="col-md-12 col-form-label">Fiber size</label></div>
<div class="form-group row">
	<?php 
		// $countoption = 0;
	?>
	@if($sFiberSize)
		@foreach($sFiberSize AS $r)
		<div class="col-md-3">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="conclusion_size_id[]" value=""><label class="form-check-label" for="conclusion_size_id"></label><br>
			</div>
		</div>
		<?php 
			// $countoption++;
			// $finaloption = $countoption%4;			
		?>
		<?php // if($finaloption==0){ ?>
		<div class="col-md-12"><br></div>
		<?php // } ?>
		@endforeach
	@endif	
</div>
-->
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">Frequency(repetition rate)</label>
	<div class="col-md-8">
		<input class="form-control" type="text" name="conclusion_frequency" value="{{ $sRow->conclusion_frequency??'' }}" placeholder="Frequency" >
	</div>
	<label for="example-password-input" class="col-md-1 col-form-label">hertz</label>
</div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">Total energy</label>
	<div class="col-md-9">
		<input class="form-control" type="text" name="conclusion_total_energy" value="{{ $sRow->conclusion_total_energy??'' }}" placeholder="Total energy" >
	</div>
</div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">Total shocks</label>
	<div class="col-md-9">
		<input class="form-control" type="text" name="conclusion_total_shocks" value="{{ $sRow->conclusion_total_shocks??'' }}" placeholder="Total shocks" >
	</div>
</div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">Equipment charge</label>
	<div class="col-md-9">
		<input class="form-control" type="text" name="conclusion_equipment_charge" value="{{ $sRow->conclusion_equipment_charge??'' }}" placeholder="Equipment charge" >
	</div>
</div>