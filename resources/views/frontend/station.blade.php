@extends('frontend.layouts.components-index')

@section('style-css')
@endsection

@section('contents-boby')
    <div class="bg-imageG" id="content">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-4 text-left py-5">
                    <img src="{{asset("asset/frontend/images/SIG_Logo-removebg-preview.png")}}" style="width:250px">
                </div>
                <div class="col-8">
                    <h2 class="text-blue display-3 mb-0"><b>PRA - eSIGAR</b></h2>
                </div>
            </div>
        </div>
        <div class="container container-main pb-5 text-center mt-5" style="">
            <div class="row mb-5">
                {{-- <div class="col-md-12"> --}}
                    @if($rows)
                    @foreach($rows as $d)
                        <div class="col-md-6">
                        {{-- <a href="{{url("list-training/$train_id?departid=$d->department_id&station=$d->id")}}" class="btn btn-secondary btn-sub mb-3 w-100"  style="font-size:40px; padding: 30px 50px;">{{@$d->name}}</a> --}}
                            <a href="{{url("list-training/$train_id?departid=$d->department_id&station=$d->id")}}" class="btn btn-secondary btn-sub mb-3 w-100"  style="font-size:40px; padding: 10px 50px;">{{@$d->name}}</a>
                        </div>
                    @endforeach
                    @endif
                {{-- </div> --}}
                <div class="col-md-12">
                    <a href="{{url("list-department/$train_id")}}" class="btn btn-secondary btn-sub mb-3 w-20"  style="font-size:40px; padding: 10px 160px;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                </div>
            </div>
        </div>
        <div class="container container-main pt-5 mt-5 fixed-bottom mb-5">
        {{-- <div class="container container-main pt-5 mt-5  mb-5"> --}}
            @if($depart->image != null)
            <img src="{{asset("asset/department/images/$depart->image")}}" class="mw-100 mb-4">
            @endif
            <img src="{{asset("asset/frontend/images/img-bottomSub.jpg")}}" class="mw-100">
        </div>
    </div>
    <script>
        $('#content').css({
            'height': $(window).height()
        });
    </script>
@endsection

@section('scripts-js')
@endsection
