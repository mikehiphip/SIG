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

class TakePhotoController extends FrontendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {  
	    // return view('frontend.takePhoto');
        
        return view('frontend.takePhoto')->with([
            'id'      => $id,   // id_train
        ]); // จะไปที่หน้านั้น path จะไม่เปลี่ยน
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function takePhotoAction(Request $request)    
    {
        // dd($request->all());
        $id_train   = $request->id;
        $imagedata  = $request->takeaphoto;
        // dd($imagedata);       
        $fileName = '';

        \DB::beginTransaction();
        try {
           
            if(strlen($imagedata) > 128) {
                list($ext, $data)   = explode(';', $imagedata);
                list(, $data)       = explode(',', $data);
                $data = base64_decode($data);
                
                $fileName = uniqid().'.png'; 
                $path           = 'public/asset/photo/';
                // dd($fileName);
                file_put_contents($path.$fileName, $data);
            }

            $sData = Train::findOrFail($request->id);            
            $sData->proto  = $fileName;
            // dd($sData);
            $sData->save();
        
            \DB::commit();
            
            // return redirect("listTraining/$id_train")->with(['alert'=>array('status'=>'success', 'msg'=>'บันทึกเรียบร้อย')]);
            
            return redirect()->route('frontend.takephotodraft', ['id'=>$id_train]);
        }
        catch (\Exception $e) {
            dd($e->getMessage());
            \DB::rollback();
            exit;
        }    
    }
    
    public function indexDraft($id)
    {   
        // dd($id);
        $sData = Train::findOrFail($id);
        $path           = 'public/asset/photo/';
        $fileName       = $path.$sData->proto;
        // dd($fileName);
        return view('frontend.takePhotoDraft')->with([
            'id'        => $id,         // id_train
            'fileName'  => $fileName,   // img
        ]); 
    }
    
    public function takePhotoDraftAction(Request $request)    
    {
        // dd($request->all());
         
        $fileName = '';

        \DB::beginTransaction();
        try {
           
            $id_train = $request->id;
            // dd($id_train);
        
            \DB::commit();
            
            // return redirect("listTraining/$id_train")->with(['alert'=>array('status'=>'success', 'msg'=>'บันทึกเรียบร้อย')]);
            return redirect()->route('frontend.list-department', ['id'=>$id_train]);
            // return redirect()->route('frontend.listtraining', ['id'=>$id_train]);
        }
        catch (\Exception $e) {
            dd($e->getMessage());
            \DB::rollback();
            exit;
        }    
    }

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
