<?php
	
	namespace App\Http\Controllers\Backend\Sheet;
	
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Yajra\DataTables\DataTables;
	use DB;
	
	class EswlPriceController extends Controller 
	{
		
		public function index(Request $request)
		{
			// return "Test";			
			return view('backend.sheet.eswl-price.index');
		}
		
		public function create()
		{		
			// return "Test";
			$sPrice 		= array();
			
			$sHospital 		= \App\Models\Backend\Masters\Hospital::orderBy('id', 'asc')->get();
			$sSheetEswl 	= \App\Models\Backend\Masters\SheetEswl::orderBy('id', 'asc')->get();
			
			// dd($sPatientSex);
			return view('backend.sheet.eswl-price.form')->with(
				[
					'sHospital'		=> $sHospital, 
					'sSheetEswl'	=> $sSheetEswl,
					'sPrice'		=> $sPrice,
				]
			);
		}
		
		public function store(Request $request)
		{
			return $this->form();
		}
		
		public function update(Request $request, $id)
		{
			// dd($request->all());
			return $this->form($id);
		}
		
		public function form($id=NULL)
		{
			\DB::beginTransaction();
			try {
				if( $id ){
					$sRow = \App\Models\EswlPrice::find($id);
				}else{
					$sRow = new \App\Models\EswlPrice;
				}
				$sRow->id_hosp    	= request('id_hosp');
				$sRow->id_eswl    	= request('id_eswl');
				// $sRow->price 		= request('price');
				$price = "";
				foreach(request('outer-group1')['0']['inner-group1'] as $k => $v){
					if($k=='0'){
						$price = $v['price'];
					}else{
						$price .= ",".$v['price'];
					}
				}				
				$sRow->price			= $price;
				// $sRow->active    	= request('active')?request('active'):'N';				
				// if( request('locale_id') ){
					// $sRow->locale_id    = request('locale_id');
				// }else{
					// $sRow->locale_id    = \Auth::user()->locale_id;
				// }		
				// dd($sRow);
				$sRow->save();
				\DB::commit();
				
				return redirect()->action('Backend\Sheet\EswlPriceController@index')->with(['alert'=>\App\Models\Alert::Msg('success')]);
			} catch (\Exception $e) {
				echo $e->getMessage();
				\DB::rollback();
				return redirect()->action('Backend\Sheet\EswlPriceController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}
		
		
		public function edit($id)
		{
			try {
				$sRow 			= \App\Models\EswlPrice::find($id);				
				$sPrice 		= explode(",",$sRow->price);
				
				$sHospital 		= \App\Models\Backend\Masters\Hospital::orderBy('id', 'asc')->get();
				$sSheetEswl 	= \App\Models\Backend\Masters\SheetEswl::orderBy('id', 'asc')->get();
				
				// return View('backend.sheet.eswl-patient.form')->with(array('sRow'=>$sRow) );
				return view('backend.sheet.eswl-price.form')->with(
					[
						'sRow'			=> $sRow, 
						'sHospital'		=> $sHospital, 
						'sSheetEswl'	=> $sSheetEswl,
						'sPrice'		=> $sPrice,
					]
				);				
			} catch (\Exception $e) {
				return redirect()->action('Backend\Sheet\EswlPriceController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}
		
		
		public function destroy($id)
		{
			$sRow = \App\Models\EswlPrice::find($id);
			if( $sRow ){				
				// $sRow->forceDelete(); // ลบจริง
				$sRow->delete();
			}
			return response()->json(\App\Models\Alert::Msg('success'));
		}
		
		public function Datatable(){
			$sTable = \App\Models\EswlPrice::search()->orderBy('id', 'asc');
			/* For Debug
			// $sTable = $sTable->with('hospital', 'sheetEswl'); 
			// dd($sTable->get());
			*/
			$sQuery = DataTables::of($sTable);
			
			return $sQuery	
			->editColumn('name_open_invoice', function($row) {
				return $row->hospital->name_open_invoice;				
			})
			->editColumn('name_sheet_eswl', function($row) {
				return $row->sheetEswl->name;				
			})
			->addColumn('price', function($row) {
				$prices_arr 	= explode(",",$row->price);
				$prices			= "";
				foreach($prices_arr as $k => $v){
					if($k==0){
						$prices = ($k+1)."). ".$v;
					}else{
						$prices .= "<br>".($k+1)."). ".$v;
					}					
				}
				return $prices;
			})
			->addColumn('updated_at', function($row) {
				return is_null($row->updated_at) ? '-' : $row->updated_at;
			})
			->escapeColumns('price')
			->make(true);
		}		
		
	}
