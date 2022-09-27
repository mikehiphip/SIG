<div class="form-group row"><label class="col-md-12 col-form-label"><b>TREATMENT CONCLUSION DATA</b></label></div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">Incision/cutting power</label>
	<div class="col-md-8">
		<input class="form-control" type="text" name="treatment_conclusion_incision_cutting" value="{{ $sRow->treatment_conclusion_incision_cutting??'' }}" placeholder="Incision/cutting power" >
	</div>
	<label for="example-password-input" class="col-md-1 col-form-label">watt</label>
</div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">Coagulation power</label>
	<div class="col-md-8">
		<input class="form-control" type="text" name="treatment_conclusion_coagulation" value="{{ $sRow->treatment_conclusion_coagulation??'' }}" placeholder="Coagulation power" >
	</div>
	<label for="example-password-input" class="col-md-1 col-form-label">watt</label>
</div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">Vaporization power</label>
	<div class="col-md-8">
		<input class="form-control" type="text" name="treatment_conclusion_vaporization" value="{{ $sRow->treatment_conclusion_vaporization??'' }}" placeholder="Vaporization power" >
	</div>
	<label for="example-password-input" class="col-md-1 col-form-label">watt</label>
</div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">Total energy</label>
	<div class="col-md-8">
		<input class="form-control" type="text" name="treatment_conclusion_total_energy" value="{{ $sRow->treatment_conclusion_total_energy??'' }}" placeholder="Total energy" >
	</div>
	<label for="example-password-input" class="col-md-1 col-form-label">joules</label>
</div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">Total time</label>
	<div class="col-md-8">
		<input class="form-control" type="text" name="treatment_conclusion_total_time" value="{{ $sRow->treatment_conclusion_total_time??'' }}" placeholder="Total time" >
	</div>
	<label for="example-password-input" class="col-md-1 col-form-label">min</label>
</div>

<div class="form-group row"><label class="col-md-12 col-form-label"><b>REMARK DATA</b></label></div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">Remark</label>
	<div class="col-md-9">
		<input class="form-control" type="text" name="remart" value="{{ $sRow->remart??'' }}" placeholder="Remark" >
	</div>	
</div>