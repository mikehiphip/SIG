<?php
namespace App\Http\Controllers\Backend\Promotion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class GiveawayController extends Controller
{

    public function index()
    {
		$sLocale  = \App\Models\Locale::all();
        return view('backend.promotion.giveaway.index',['sLocale'=>$sLocale]);
    }

    public function create()
    {
        $sLocale  = \App\Models\Locale::all();
        return view('backend.promotion.giveaway.form',['sLocale'=>$sLocale]);
    }
    
    public function store(Request $request)
    {
        return $this->form();
    }
    
    public function update(Request $request, $id)
    {
        return $this->form($id);
    }

    public function form($id=NULL)
    {
        \DB::beginTransaction();
        try {
            if( $id ){
                $sData = \App\Models\Promotion\Giveaway::find($id);
            }else{
                $sData = new \App\Models\Promotion\Giveaway;
            }
            $sData->region_id   = request('region_id');
            $sData->name        = request('name');
            $sData->status      = request('status');
            $sData->save();
            \DB::commit();
            \Cache::forget('Cart');
                
            return redirect()->action('Backend\Promotion\GiveawayController@index')->with(['alert'=>array('status'=>'success', 'msg'=>'บันทึกโปรโมชั่นเรียบร้อย')]);
        } catch (\Exception $e) {
            echo $e->getMessage();
            \DB::rollback();
            return redirect()->action('Backend\Promotion\GiveawayController@index')->with(['alert'=>array('status'=>'danger', 'msg'=>'danger')]);
        }
    }

    public function edit($id)
    {
        try {
            $sRow       = \App\Models\Promotion\Giveaway::find($id);
            $sLocale  = \App\Models\Locale::all();
            $sProduct   = \App\Models\Product::all();
            $sRow->expire_at = date('d-m-Y',strtotime($sRow->expire_at));
            return View('backend.promotion.giveaway.form')->with(array('sRow'=>$sRow,'sLocale'=>$sLocale,'sProduct'=>$sProduct) );
        } catch (\Exception $e) {
            return redirect()->action('Backend\Promotion\GiveawayController@index')->with(['alert'=>array('status'=>'danger', 'msg'=>'danger')]);
        }
    }


    public function destroy($id)
    {
        $sRow = \App\Models\Promotion\Giveaway::find($id);
        if( $sRow ){
            $sRow->forceDelete();
        }
        return response()->json(array('status'=>'success', 'msg'=>'ลบโปรโมชั่นเรียบร้อย'));  
    }
    
    public function Datatable(){
        $sTable = \App\Models\Promotion\Giveaway::with(['region'])->search()->orderBy('id', 'asc');
        $sQuery = DataTables::of($sTable);
        return $sQuery
        ->addColumn('daterange', function($row) {
            return date('d-m-Y',strtotime($row->date_start)).' - '.date('d-m-Y',strtotime($row->date_end));
        })
        ->editColumn('discount', function($row) {
            if($row->promotion=='D'){
                return ($row->type=='P'?'ส่วนลด '.$row->discount.'%':'ส่วนลด '.$row->discount.' บาท');
            }else{
                
            }
        })
        ->editColumn('status', function($row) {
            return ($row->status=='Y'?'ใช้งาน':'ไม่ใช้งาน');
        })
        ->editColumn('promotion', function($row) {
            return ($row->promotion=='D'?'ส่วนลด':'ของแถม');
        })
        ->make(true);
    }
    
}
