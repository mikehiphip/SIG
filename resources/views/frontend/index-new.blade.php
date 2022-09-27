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
        <div class="container container-main pb-5 text-center pt-5 mt-5">
            {{-- <div class="row">
                <div class="col-md-12">
                    <a href="{{url("list-training/$id")}}" class="btn btn-secondary btn-sub mb-3 w-100" style="font-size:40px; padding: 60px 50px;"><b>GENERAL Training Course</b></a>
                </div>
            </div> --}}


            <div class="row">
                @if($departs)
                @foreach($departs as $d)
                    @php 
                    $rows = DB::table('sg_station')->where('deleted_at',null)->where('department_id',$d->id)->count();
                    @endphp
                    <div class="col-md-13">
                        @if($rows > 0)
                            <a href="{{url("list-station/$d->id/$id")}}" class="btn btn-secondary btn-sub mb-3 w-100"  style="font-size:40px; padding: 60px 50px;"><b>{{@$d->name}}</b></a>
                        @else
                            <a href="{{url("list-training/$id?departid=$d->id&station=")}}" class="btn btn-secondary btn-sub mb-3 w-100"  style="font-size:40px; padding: 60px 50px;"><b>{{@$d->name}}</b></a>
                        @endif
                    </div>
                @endforeach
                @endif
            </div>
        </div>
        <div class="container container-main pt-5 mt-5 fixed-bottom mb-5">
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
