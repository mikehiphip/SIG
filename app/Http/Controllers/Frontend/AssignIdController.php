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
use App\Models\TrainEmp;

class AssignIdController extends FrontendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
		// return "Test1";
        return view('frontend.assignId');        
        // return view('frontend.test');        
        // return view('welcome');
    }

    public function assignIdCall(Request $request)    
    {            
       // dd($request->all());
        $v_id 		= $request['p_id'];			
        $sqlcall   	= "select * from sg_employee where code='$v_id'";
        // echo $sqlcall; exit();
        $rowcalls 	= DB::select($sqlcall);
        // dd($rowcalls);
        // $rowcall	= $rowcalls['0'];
        $rowcallnum = count($rowcalls);	
        // dd($rowcallnum);

        if($rowcallnum > 0){
            $v_status   = 'yes';
            $v_value    = $rowcalls['0'];
        }else{
            $v_status   = 'no';
            $v_value    = '';
        }

        $datas 		= array(
            "r_status"  => $v_status,
            "r_data"	=> $v_value
        );
        return json_encode($datas);
    
    }

    public function assignIdAction(Request $request)    
    {    
        // dd($request->all());

        \DB::beginTransaction();
        try {
          
            $sData = new Train;            
            $sData->save();
            $id_train = $sData->id;
            // dd($id_train);
            // dd($request->c_emp_v1);

            if(!empty($request->c_emp_v1)){
                $sDataS = new TrainEmp;
                $sDataS->id_train        =  $id_train;  
                $sDataS->id_emp          =  $request->c_emp_v1;  
                $sDataS->save();
            }

            if(!empty($request->c_emp_v2)){
                $sDataS = new TrainEmp;
                $sDataS->id_train        =  $id_train;  
                $sDataS->id_emp          =  $request->c_emp_v2;  
                $sDataS->save();
            }
            
            if(!empty($request->c_emp_v3)){
                $sDataS = new TrainEmp;
                $sDataS->id_train        =  $id_train;  
                $sDataS->id_emp          =  $request->c_emp_v3;  
                $sDataS->save();
            }
            
            if(!empty($request->c_emp_v4)){
                $sDataS = new TrainEmp;
                $sDataS->id_train        =  $id_train;  
                $sDataS->id_emp          =  $request->c_emp_v4;  
                $sDataS->save();
            }
            
            if(!empty($request->c_emp_v5)){
                $sDataS = new TrainEmp;
                $sDataS->id_train        =  $id_train;  
                $sDataS->id_emp          =  $request->c_emp_v5;  
                $sDataS->save();
            }
            \DB::commit();

            // return view('frontend.takePhoto')->with([
                // 'id'      => $id_train,
            // ]); // จะไปที่หน้านั้น path จะไม่เปลี่ยน
            
            /* ส่งแบบ get -> https://dev.sig.top.orangeworkshop.info/takePhoto?id=126 */
            // 1.
            // return redirect("backend/masters/hospitals/$request->vHosId")->with(['alert'=>array('status'=>'success', 'msg'=>'บันทึกเรียบร้อย', 'vStatus'=>$request->vHosId)]);
            // 2.
            return redirect()->route('frontend.takephoto', ['id'=>$id_train]);
            
            
        } catch (\Exception $e) {
            dd($e->getMessage());
            \DB::rollback();
            exit;
            return redirect()->action('Frontend\AssignIdController@index')->with(['alert'=>array('status'=>'danger', 'msg'=>'danger')]);
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
