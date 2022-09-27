<?php
namespace App\Http\Controllers\Backend\Promotion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{

    public function index()
    {
		$sLocale  = \App\Models\Locale::all();
        return view('backend.promotion.product.index',['sLocale'=>$sLocale]);
    }

    public function create()
    {
        $sLocale  = \App\Models\Locale::all();
        $sProduct    = \App\Models\Product::whereNull('deleted_at')->get();
        return view('backend.promotion.product.form',['sLocale'=>$sLocale,'sProduct'=>$sProduct]);
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
                $sData = \App\Models\Promotion\Product::find($id);
            }else{
                $sData = new \App\Models\Promotion\Product;
            }
            $daterange = explode(' - ',request('daterange'));
            $sData->region_id   = request('region_id');
            $sData->product_id   = request('product_id');
            $sData->date_start  = date('Y-m-d',strtotime($daterange[0]));
            $sData->date_end    = date('Y-m-d',strtotime($daterange[1]));
            $sData->type        = request('type');
            $sData->discount    = request('discount');
            $sData->status      = request('status');
            $sData->note        = request('note');
            $sData->save();
            \DB::commit();
            \Cache::forget('Promotion');
                
            return redirect()->action('Backend\Promotion\ProductController@index')->with(['alert'=>array('status'=>'success', 'msg'=>'บันทึกโปรโมชั่นเรียบร้อย')]);
        } catch (\Exception $e) {
            echo $e->getMessage();
            \DB::rollback();
            return redirect()->action('Backend\Promotion\ProductController@index')->with(['alert'=>array('status'=>'danger', 'msg'=>'danger')]);
        }
    }

    public function edit($id)
    {
        try {
            $sRow       = \App\Models\Promotion\Product::find($id);
            $sLocale  = \App\Models\Locale::all();
            $sProduct   = \App\Models\Product::all();
            $sRow->expire_at = date('d-m-Y',strtotime($sRow->expire_at));
            return View('backend.promotion.product.form')->with(array('sRow'=>$sRow,'sLocale'=>$sLocale,'sProduct'=>$sProduct) );
        } catch (\Exception $e) {
            return redirect()->action('Backend\Promotion\ProductController@index')->with(['alert'=>array('status'=>'danger', 'msg'=>'danger')]);
        }
    }


    public function destroy($id)
    {
        $sRow = \App\Models\Promotion\Product::find($id);
        if( $sRow ){
            $sRow->forceDelete();
        }
        return response()->json(array('status'=>'success', 'msg'=>'ลบโปรโมชั่นเรียบร้อย'));  
    }
    
    public function Datatable(){
        $sTable = \App\Models\Promotion\Product::with(['region','staff','product'])->search()->orderBy('id', 'asc');
        $sQuery = DataTables::of($sTable);
        return $sQuery
        ->addColumn('daterange', function($row) {
            return $row->date_start.' - '.$row->date_end;
        })
        ->editColumn('discount', function($row) {
            return ($row->type=='P'?'ส่วนลด '.$row->discount.'%':'ส่วนลด '.$row->discount.' บาท');
        })
        ->editColumn('status', function($row) {
            return ($row->status=='Y'?'ใช้งาน':'ไม่ใช้งาน');
        })
        ->make(true);
    }
    
}
