@extends('frontend.layouts.components-index')

@section('style-css')

@endsection

@section('contents-boby')
<div class="bg-imageB" id="content">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center py-5">
				<img src="{{ asset('asset/frontend/images/SIG_Logo-removebg-preview.png') }}" class="logo1">
			</div>
			<div class="col-12 py-4">
				<div class="boxThank">
					<h1 class="fw-bold display-4 text-blue mb-5">ดูวิดีโอเสร็จเรียบร้อย<br><span class="fw-light">Finished watching the video</span></h1>
					<h1 class="fw-normal text-blue">ขอบคุณพนักงานทุกท่านที่เข้ารับชมวิดีโออบรม<br>Thank you to all staff who attended the training video.</h1>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#content').css({
       'height': $(window).height()
    });
	
	function display(){ 

        seconds-=1;
     
        if(seconds==-1){
			window.location = "https://dev.sig.top.orangeworkshop.info/";
            return false;
        }    
        setTimeout("display()",1000);
    }    
    var seconds=5;
    display();
</script>
@endsection

@section('scripts-js')

@endsection