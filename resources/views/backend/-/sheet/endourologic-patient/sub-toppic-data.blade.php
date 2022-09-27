<div class="form-group row"><label class="col-md-12 col-form-label"><b>NUMBER DATA</b></label></div>
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
		<input class="form-control" type="text" id="book_number3_endo" name="book_number3_endo" value="{{ $sRow->book_number3??'' }}" placeholder="Book number (001)" >
	</div>
</div>
<div class="form-group row">
	<label for="example-password-input" class="col-md-3 col-form-label">เลขที่ (4 digit)</label>
	<div class="col-md-9">
		<input class="form-control" type="text" id="book_number4_endo" name="book_number4_endo" value="{{ $sRow->book_number4??'' }}" placeholder="Book number (0001)" >
	</div>
</div>

<div class="form-group row"><label class="col-md-12 col-form-label"><b>PROCEDURE DATA</b></label></div>
<div class="form-group row">
	<?php $countoption = 0; ?>	
	{{-- dd($sSheet_endou) --}}
	@if($sSheetEndourologic)
		@foreach($sSheetEndourologic AS $r)
		<div class="col-md-3">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="sheet_endou[]" value="{{$r->id}}" <?php echo (in_array($r->id ,$sSheet_endou)?'checked':'')?> ><label class="form-check-label" for="sheet_endou"> {{$r->name}}</label><br>
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
	<div class="col-md-12">
		<center><img width="45%" src="{{ asset('backend/images/backend/form-eswl.jpg') }} " /></center>
	</div>
</div>
