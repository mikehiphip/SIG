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
use App\Models\Trainlist;

class ListTrainingController extends FrontendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {  
		// dd($id);
        $sRow = Video::where('id','<>','')->orderby('id','desc')->get();
      

        return view('frontend.listTraining')->with([
            'id'      => $id,
            'sRow'    => $sRow,
        ]);
    }
    public function index_new($id)
    {  
		// dd($id);
        $departments = DB::table('sg_department')->where('deleted_at',null)->where('show_status','on')->orderby('sort','asc')->get();
        return view('frontend.index-new')->with([
            'id' => $id,
            'departs' => $departments,
        ]);
    }
    public function station($id,$train_id)
    {  
		// dd($id);
        $rows = DB::table('sg_station')->where('deleted_at',null)->where('show_status','on')->where('department_id',$id)->get();
        $depart = DB::table('sg_department')->where('id',$id)->first();
        return view('frontend.station')->with([
            'id' => $id,
            'train_id' => $train_id,
            'rows' => $rows,
            'depart' => $depart,
        ]);
    }
    public function training(Request $request,$id)
    {  
		// dd($id);
        $departid = $request->departid;
        $station = $request->station;
        $like = [
            'department_id' => $departid,
            'station_id' => $station
        ];
        $sRow = Video::where('id','<>','')
        ->when($like, function ($query, $like) {
            if($like['department_id'] != null)
            {
                $query->where('department_id', $like['department_id']);
            }
            if($like['station_id'] != null)
            {
                $query->where('station_id', $like['station_id']);
            }
        })
        ->orderby('id','desc')->get();
        return view('frontend.listTraining')->with([
            'id'      => $id,
            'sRow'    => $sRow,
        ]);
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

    public function submit_train(Request $request)
    {

        $id_t = $request->id;
        $id_v = $request->v_id;
    

        \DB::beginTransaction();
        try {
            $sDataV = Video::findOrFail($id_v);
            $sDataV->views           = $sDataV->views + 1;
            $sDataV->save();

            $data = new Trainlist();
            $data->sg_train_id = $id_t;
            $data->id_vi = $id_v;
            $data->vi_name = $sDataV->name;
            $data->vi_detail = $sDataV->details;
            $data->vi_time_stop = date("h:i:s"); 
            $data->vi_time_start = $request->v_start; 
            
            
            $data->save();

            $data->vi_time_unit  = $this->diff2time($data->vi_time_start, $data->vi_time_stop);   

            $video_time = $sDataV->unit; // เวลาวีดีโอ
            $video_view = date('H:i:s',strtotime($this->diff2time2($data->vi_time_start, $data->vi_time_stop))); // เวลาที่ดูคลิปไป
            $vi_stand_unit = $this->diff2time($video_time, $video_view); // เวลาที่ดูคลิปไป
            $data->vi_stand_unit = $vi_stand_unit;
          
            $data->save();
            
            \DB::commit();
           
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

}
