<?php
namespace App\Http\Controllers\Backend\Promotion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class MatchController extends Controller
{

    public function index()
    {
		$sLocale  = \App\Models\Locale::all();
        return view('backend.promotion.match.index',['sLocale'=>$sLocale]);
    }

    public function create()
    {
        $sLocale  = \App\Models\Locale::all();
        $sGiveaway  = \App\Models\Promotion\Giveaway::where('status','Y')->get();
        return view('backend.promotion.match.form',['sLocale'=>$sLocale,'sGiveaway'=>$sGiveaway]);
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
                $sData = \App\Models\Promotion\Match::find($id);
            }else{
                $sData = new \App\Models\Promotion\Match;
            }

            $product_id = array_unique(request('product_id'));

            $daterange = explode(' - ',request('daterange'));
            $sData->region_id   = request('region_id');
            $sData->name       = request('name');
            $sData->price       = request('price');
            $sData->promotion   = request('promotion');
            $sData->giveaway_id = request('giveaway_id');
            $sData->date_start  = date('Y-m-d H:i:s',strtotime($daterange[0]));
            $sData->date_end    = date('Y-m-d H:i:s',strtotime($daterange[1]));
            $sData->type        = request('type');
            $sData->discount    = request('discount');
            $sData->status      = request('status');
            $sData->product_id  = implode(',',$product_id);
            $sData->save();
            \DB::commit();
            \Cache::forget('Cart');
                
            return redirect()->action('Backend\Promotion\MatchController@edit', $sData->id)->with(['alert'=>array('status'=>'success', 'msg'=>'บันทึกโปรโมชั่นเรียบร้อย')]);
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->action('Backend\Promotion\MatchController@index')->with(['alert'=>array('status'=>'danger', 'msg'=>$e->getMessage())]);
        }
    }

    public function edit($id)
    {
        try {
            $sRow       = \App\Models\Promotion\Match::find($id);
            $sLocale  = \App\Models\Locale::all();
            $sGiveaway  = \App\Models\Promotion\Giveaway::where('status','Y')->get();

 
            $product = explode(',',$sRow->product_id);
            $sProduct= \App\Models\Product::whereIn('pd_id',$product)->get();
            if($sProduct->count()){
                $i = 1;
                foreach($sProduct AS $r){
                    $name = 'product_name'.$i;
                    $id = 'product_id'.$i;
                    $sRow->$id = $r->pd_id;
                    $sRow->$name = $r->to->category->name.' > '.$r->name;
                    $i++;
                }
            }


            return View('backend.promotion.match.form')->with(array('sRow'=>$sRow,'sLocale'=>$sLocale,'sGiveaway'=>$sGiveaway) );
        } catch (\Exception $e) {
            return redirect()->action('Backend\Promotion\MatchController@index')->with(['alert'=>array('status'=>'danger', 'msg'=>'danger')]);
        }
    }


    public function destroy($id)
    {
        $sRow = \App\Models\Promotion\Match::find($id);
        if( $sRow ){
            $sRow->forceDelete();
        }
        return response()->json(array('status'=>'success', 'msg'=>'ลบโปรโมชั่นเรียบร้อย'));  
    }
    
    public function Datatable(){
        $sTable = \App\Models\Promotion\Match::with(['region'])->search()->orderBy('id', 'asc');
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

    public function Autocomplete(){
        return \App\Models\Product::with(['to:shop_id,product_id','to.category:sp_id,sp_name'])->has('to')
            ->select('pd_name_inter', 'pd_id', 'pd_sub_name_inter')
            ->where('pd_name_inter', 'like','%'.request('query').'%')
            ->whereHas('to', function($q){
                $q->wherenotnull('shop_id');
            })
            ->limit(20)
            ->get();




    }
}
