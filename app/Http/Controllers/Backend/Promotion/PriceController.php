<?php
namespace App\Http\Controllers\Backend\Promotion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class PriceController extends Controller
{

    public function index()
    {
		$sLocale  = \App\Models\Locale::all();
        return view('backend.promotion.price.index',['sLocale'=>$sLocale]);
    }

    public function create()
    {
        $sLocale  = \App\Models\Locale::all();
        $sGiveaway  = \App\Models\Promotion\Giveaway::where('status','Y')->get();
        return view('backend.promotion.price.form',['sLocale'=>$sLocale,'sGiveaway'=>$sGiveaway]);
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
                $sData = \App\Models\Promotion\Price::find($id);
            }else{
                $sData = new \App\Models\Promotion\Price;
            }
            $daterange = explode(' - ',request('daterange'));
            $sData->region_id   = request('region_id');
            $sData->price       = request('price');
            $sData->promotion   = request('promotion');
            $sData->giveaway_id = request('giveaway_id');
            $sData->date_start  = date('Y-m-d H:i:s',strtotime($daterange[0]));
            $sData->date_end    = date('Y-m-d H:i:s',strtotime($daterange[1]));
            $sData->type        = request('type');
            $sData->discount    = request('discount');
            $sData->status      = request('status');
            $sData->save();
            \DB::commit();
            \Cache::forget('Cart');
                
            return redirect()->action('Backend\Promotion\PriceController@index')->with(['alert'=>array('status'=>'success', 'msg'=>'บันทึกโปรโมชั่นเรียบร้อย')]);
        } catch (\Exception $e) {
            echo $e->getMessage();
            \DB::rollback();
            return redirect()->action('Backend\Promotion\PriceController@index')->with(['alert'=>array('status'=>'danger', 'msg'=>'danger')]);
        }
    }

    public function edit($id)
    {
        try {
            $sRow       = \App\Models\Promotion\Price::find($id);
            $sLocale  = \App\Models\Locale::all();
            $sGiveaway  = \App\Models\Promotion\Giveaway::where('status','Y')->get();
            return View('backend.promotion.price.form')->with(array('sRow'=>$sRow,'sLocale'=>$sLocale,'sGiveaway'=>$sGiveaway) );
        } catch (\Exception $e) {
            return redirect()->action('Backend\Promotion\PriceController@index')->with(['alert'=>array('status'=>'danger', 'msg'=>'danger')]);
        }
    }


    public function destroy($id)
    {
        $sRow = \App\Models\Promotion\Price::find($id);
        if( $sRow ){
            $sRow->forceDelete();
        }
        return response()->json(array('status'=>'success', 'msg'=>'ลบโปรโมชั่นเรียบร้อย'));  
    }
    
    public function Datatable(){
        $sTable = \App\Models\Promotion\Price::with(['region'])->search()->orderBy('id', 'asc');
        $sQuery = DataTables::of($sTable);
        return $sQuery
        ->addColumn('daterange', function($row) {
            return date('d-m-Y',strtotime($row->date_start)).' - '.date('d-m-Y',strtotime($row->date_end));
        })
        ->editColumn('discount', function($row) {
            if($row->promotion=='D'){
                return ($row->type=='P'?'ส่วนลด '.$row->discount.'%':'ส่วนลด '.$row->discount.' บาท');
            }else{
                return $row->giveaway->name;
            }
        })
        ->editColumn('status', function($row) {
            return ($row->status=='Y'?'ใช้งาน':'ไม่ใช้งาน');
        })
        ->editColumn('promotion', function($row) {
            return ($row->promotion=='D'?'ส่วนลด':'ของแถม');
        })
        ->escapeColumns([])
        ->make(true);
    }
    
}
