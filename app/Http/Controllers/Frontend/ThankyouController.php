<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Frontend\NotiController;

####### Include
use Auth;
use DB;
use Session;
use Cookie;
use General;
use Socialite;

use App\Models\Train;
use App\Models\Video;

class ThankyouController extends FrontendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($v_id)
    {

        // dd(date("h:i:s"));
        $id_v = explode(",", $v_id)['0'];       // transaction วีดีโอ
        $id_t = explode(",", $v_id)['1'];       // transaction หลั$sData = Train::findOrFail($request->id);    
         
        \DB::beginTransaction();
        try {
            $sDataV = Video::findOrFail($id_v);
            $sDataV->views           = $sDataV->views + 1;
            $sDataV->save();

            $sData = Train::findOrFail($id_t);            
            $sData->id_vi           = $sDataV->id;
            $sData->vi_name         = $sDataV->name;
            $sData->vi_detail       = $sDataV->details;
            $sData->vi_time_stop    = date("h:i:s"); 
            $sData->save();	
            
            $sData->vi_time_unit    = $this->diff2time($sData->vi_time_start, $sData->vi_time_stop);

           
            // dd($sData);   
            $sData->save();
            \DB::commit();
            $noti = new NotiController();
            $noti->notiEmail($sData);
  
            // die();
            return view('frontend.thankyou');      
        }
         catch (\Exception $e) {
            //  dd($e->getMessage());
             \DB::rollback();
             exit;
        }
    }

    public function diff2time($time_a,$time_b){
        $now_time1=strtotime(date("Y-m-d ".$time_a));
        $now_time2=strtotime(date("Y-m-d ".$time_b));
        $time_diff=abs($now_time2-$now_time1);
        $time_diff_h=floor($time_diff/3600); // จำนวนชั่วโมงที่ต่างกัน
        $time_diff_m=floor(($time_diff%3600)/60); // จำวนวนนาทีที่ต่างกัน
        $time_diff_s=($time_diff%3600)%60; // จำนวนวินาทีที่ต่างกัน
        return $time_diff_h." ชั่วโมง ".$time_diff_m." นาที ".$time_diff_s." วินาที";
    }

    public function diff2time2($time_a,$time_b){
        $now_time1=strtotime(date("Y-m-d ".$time_a));
        $now_time2=strtotime(date("Y-m-d ".$time_b));
        $time_diff=abs($now_time2-$now_time1);
        $time_diff_h=floor($time_diff/3600); // จำนวนชั่วโมงที่ต่างกัน
        $time_diff_m=floor(($time_diff%3600)/60); // จำวนวนนาทีที่ต่างกัน
        $time_diff_s=($time_diff%3600)%60; // จำนวนวินาทีที่ต่างกัน
        return $time_diff_h.":".$time_diff_m.":".$time_diff_s;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		//
    }

    public function logout()
    {
       // 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
