<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontendController;

####### Include
use Auth;
use DB;
use Session;
use Cookie;
use General;
use Socialite;

use App\Models\Train;
use App\Models\Video;

class VideoTrainingController extends FrontendController
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
            $sData = Train::findOrFail($id_t);            
            $sData->vi_time_start  = date("h:i:s");
            // dd($sData);
            $sData->save();		
            
            $sDataV = Video::findOrFail($id_v);

            \DB::commit();
            // return view('frontend.videoTraining');
            return view('frontend.videoTraining')->with([
                'sData'   => $sData,
                'sDataV'  => $sDataV,
            ]);
        }
        catch (\Exception $e) {
            dd($e->getMessage());
            \DB::rollback();
            exit;
        }
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
