<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

  public function index(Request $request)
  {    
    $sRowEmpC               = \App\Models\Employee::count();        // จำนวน พนักงานทั้งหมด 
    $sRowDepartmentC 	    = \App\Models\Department::count();      // จำนวน แผนกทั้งหมด
    $sRowPositionC 	        = \App\Models\Position::count();        // จำนวน ตำแหน่งทั้งหมด
    $sRowVideoC 	        = \App\Models\Video::count();           // จำนวน วีดีโอทั้งหมด
    $sRowReceiveEmailC 	    = \App\Models\ReceiveEmail::count();    // จำนวน ผู้ที่ได้อีเมล์ทั้งหมด    
    
    $sRowTrainC 	        = \App\Models\Train::count();                               // จำนวนการอบรมทั้งหมด
    $sRowTrainEmpC 	        = \App\Models\TrainEmp::groupBy('id_emp')->get()->count();  // จำนวนพนักงาน ที่เข้าอบรมทั้งหมด
    
  
    return view('backend.index')->with(
      [
        'form_status'	      => 'display',        
        'sRowEmpC'	          => $sRowEmpC,        
        'sRowDepartmentC'	  => $sRowDepartmentC,        
        'sRowPositionC'	      => $sRowPositionC,        
        'sRowVideoC'	      => $sRowVideoC,        
        'sRowReceiveEmailC'	  => $sRowReceiveEmailC,
        
        'sRowTrainC'	  => $sRowTrainC,        
        'sRowTrainEmpC'	  => $sRowTrainEmpC,        
      ]
    );

  } 
  
  public function setPowerOff()
  {
    // dd("tesr");
    try {       
        $sRow 	 = \App\Models\Setting::where('id', '<>', '')->first();
        // dd($sRow);
        return View('backend.set-power-off')->with(
            [
                'form_status'	    => 'display',									
                'sRow' 		        => $sRow,									
            ]
        );
        
    } catch (\Exception $e) {
        return redirect()->action('Backend\HomeController@setPowerOff')->with(['alert'=>\App\Models\Alert::e($e)]);
    }
  }
  
  public function setPowerOffAction(Request $request)
  {
      // dd($request->all());
      // dd($request->active);
      
      \DB::beginTransaction();
      try {
         
          $sRow = \App\Models\Setting::find('1');              
          
          $sRow->isStatus    = empty($request->active)?'n':$request->active;
                    
          $sRow->save();
          \DB::commit();

          return redirect()->action('Backend\HomeController@setPowerOff')->with(['alert'=>\App\Models\Alert::Msg('success')]);
      } catch (\Exception $e) {			
          dd($e->getMessage());
          \DB::rollback();
          return redirect()->action('Backend\HomeController@setPowerOff')->with(['alert'=>\App\Models\Alert::e($e)]);
      }
  }
}
