<div class="form-group row"><label class="col-md-12 col-form-label"><b>TEATMENT RESULT DATA</b></label></div>

<div class="form-group row"><label class="col-md-12 col-form-label">Result</label></div>
<div class="form-group row">
	<?php $countoption = 0;	?>
	@if($sTreatmentResult)
		@foreach($sTreatmentResult AS $r)
		<div class="col-md-3">
			<div class="form-check">
				<?php 
					$selected = "";
					if($sRow->treatment_result_id??'' == $r->id){
						$selected = "checked";
					}else{
						$selected = "";
					}
				?>
				<input class="form-check-input" type="radio" name="treatment_result_id" 
				value="{{$r->id}}" 				
				<?php echo $selected; ?>				
				>
				<label class="form-check-label" for="treatment_result_id"> {{$r->name}}</label><br>
			</div>
		</div>
		<?php 
			$countoption++;
			$finaloption = $countoption%4;			
		?>
		<?php if($finaloption==0){ ?>
		<div class="col-md-12"><br></div>
		<?php } ?>
		@endforeach
	@endif	
</div>
<div class="form-group row">
	<label class="col-md-12 col-form-label">Commment</label>
	<div class="col-md-12">
		<textarea class="form-control" id="treatment_comment" name="treatment_comment" rows="4" cols="50">{{ $sRow->treatment_comment??'' }}</textarea>
	</div>
</div>