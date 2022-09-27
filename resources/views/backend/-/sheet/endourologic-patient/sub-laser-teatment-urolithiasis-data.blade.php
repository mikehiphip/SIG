<div class="form-group row"><label class="col-md-12 col-form-label"><b>Laser teatment recommendation: urolithiasis litrotripsy</b></label></div>
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
						<td style="width: 400px; text-align: left; vertical-align: middle;">Renal calculi (nephoscopy)</td>
						<td><input class="form-control" type="text" name="litrotripsy_renal_enerry" 	value="{{ $sRow->litrotripsy_renal_enerry??'' }}" 		placeholder="" ></td>
						<td><input class="form-control" type="text" name="litrotripsy_renal_frequency" 	value="{{ $sRow->litrotripsy_renal_frequency??'' }}" 	placeholder="" ></td>
						<td><input class="form-control" type="text" name="litrotripsy_renal_power" 		value="{{ $sRow->litrotripsy_renal_power??'' }}" 		placeholder="" ></td>
						<td><input class="form-control" type="text" name="litrotripsy_renal_fiber" 		value="{{ $sRow->litrotripsy_renal_fiber??'' }}" 		placeholder="" ></td>
					</tr>
					<tr>
						<td style="width: 400px; text-align: left; vertical-align: middle;">Ureteral calculi (rigid ureteroscopy)</td>
						<td><input class="form-control" type="text" name="litrotripsy_ureteral_enerry" 		value="{{ $sRow->litrotripsy_ureteral_enerry??'' }}" 	placeholder="" ></td>
						<td><input class="form-control" type="text" name="litrotripsy_ureteral_frequency" 	value="{{ $sRow->litrotripsy_ureteral_frequency??'' }}" placeholder="" ></td>
						<td><input class="form-control" type="text" name="litrotripsy_ureteral_power" 		value="{{ $sRow->litrotripsy_ureteral_power??'' }}" 	placeholder="" ></td>
						<td><input class="form-control" type="text" name="litrotripsy_ureteral_fiber" 		value="{{ $sRow->litrotripsy_ureteral_fiber??'' }}" 	placeholder="" ></td>
					</tr>
					<tr>
						<td style="width: 400px; text-align: left; vertical-align: middle;">Bladder calculi</td>
						<td><input class="form-control" type="text" name="litrotripsy_blader_enerry" 	value="{{ $sRow->litrotripsy_blader_enerry??'' }}" 		placeholder="" ></td>
						<td><input class="form-control" type="text" name="litrotripsy_blader_frequency" value="{{ $sRow->litrotripsy_blader_frequency??'' }}" 	placeholder="" ></td>
						<td><input class="form-control" type="text" name="litrotripsy_blader_power" 	value="{{ $sRow->litrotripsy_blader_power??'' }}" 		placeholder="" ></td>
						<td><input class="form-control" type="text" name="litrotripsy_blader_fiber" 	value="{{ $sRow->litrotripsy_blader_fiber??'' }}" 		placeholder="" ></td>
					</tr>
					<tr>
						<td style="width: 400px; text-align: left; vertical-align: middle;">Flexible ureteroscope</td>
						<td><input class="form-control" type="text" name="litrotripsy_flexible_enerry" 		value="{{ $sRow->litrotripsy_flexible_enerry??'' }}" placeholder="" ></td>
						<td><input class="form-control" type="text" name="litrotripsy_flexible_frequency" 	value="{{ $sRow->litrotripsy_flexible_frequency??'' }}" placeholder="" ></td>
						<td><input class="form-control" type="text" name="litrotripsy_flexible_power" 		value="{{ $sRow->litrotripsy_flexible_power??'' }}" placeholder="" ></td>
						<td><input class="form-control" type="text" name="litrotripsy_flexible_fiber" 		value="{{ $sRow->litrotripsy_flexible_fiber??'' }}" placeholder="" ></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>