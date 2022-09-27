<div class="form-group row"><label class="col-md-12 col-form-label"><b>Laser teatment recommendation: urothelial tumors (excision & fulguration) and incision of prostate/stricture</b></label></div>
<div class="form-group row">
	<div class="col-lg-12">
		<div class="table-responsive">
			<table class="table table-bordered mb-0">
				<thead>
					<tr>
						<th><center>Application</center></th>
						<th><center>Energy (joules/pulse)</center></th>
						<th><center>Frequency (hertz)</center></th>
						<th><center>Power (watts)</center></th>
						<th><center>Filber size (um)</center></th>
					</tr>
				</thead>
				<tbody>					
					<tr>
						<td style="width: 400px; text-align: left; vertical-align: middle;">Ureteral tumors</td>
						<td><input class="form-control" type="text" name="tumore_ureteral_enerry" 		value="{{ $sRow->tumore_ureteral_enerry??'' }}" 	placeholder="" ></td>
						<td><input class="form-control" type="text" name="tumore_ureteral_frequency" 	value="{{ $sRow->tumore_ureteral_frequency??'' }}" 	placeholder="" ></td>
						<td><input class="form-control" type="text" name="tumore_ureteral_power" 		value="{{ $sRow->tumore_ureteral_power??'' }}" 		placeholder="" ></td>
						<td><input class="form-control" type="text" name="tumore_ureteral_fiber" 		value="{{ $sRow->tumore_ureteral_fiber??'' }}" 		placeholder="" ></td>
					</tr>
					<tr>
						<td style="width: 400px; text-align: left; vertical-align: middle;">Bladder tumors</td>
						<td><input class="form-control" type="text" name="tumore_blader_enerry" 	value="{{ $sRow->tumore_blader_enerry??'' }}" 		placeholder="" ></td>
						<td><input class="form-control" type="text" name="tumore_blader_frequency" 	value="{{ $sRow->tumore_blader_frequency??'' }}" 	placeholder="" ></td>
						<td><input class="form-control" type="text" name="tumore_blader_power" 		value="{{ $sRow->tumore_blader_power??'' }}" 		placeholder="" ></td>
						<td><input class="form-control" type="text" name="tumore_blader_fiber" 		value="{{ $sRow->tumore_blader_fiber??'' }}" 		placeholder="" ></td>
					</tr>	
					<tr>
						<td style="width: 400px; text-align: left; vertical-align: middle;">Incision of prostate/stricture</td>
						<td><input class="form-control" type="text" name="tumore_incision_enerry" 		value="{{ $sRow->tumore_incision_enerry??'' }}" 	placeholder="" ></td>
						<td><input class="form-control" type="text" name="tumore_incision_frequency" 	value="{{ $sRow->tumore_incision_frequency??'' }}" 	placeholder="" ></td>
						<td><input class="form-control" type="text" name="tumore_incision_power" 		value="{{ $sRow->tumore_incision_power??'' }}" 		placeholder="" ></td>
						<td><input class="form-control" type="text" name="tumore_incision_fiber" 		value="{{ $sRow->tumore_incision_fiber??'' }}" 		placeholder="" ></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>