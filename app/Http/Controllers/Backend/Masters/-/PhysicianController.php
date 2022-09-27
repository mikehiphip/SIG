<?php
	
	namespace App\Http\Controllers\Backend\Masters;
	
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	
	class PhysicianController extends Controller 
	{
		public function index(Request $request)
		{
			// return "Test";
			return view('backend.masters.physician.index');
		}
		
		public function create()
		{		
			// return "Test";
			return view('backend.masters.physician.form');
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
					$sRow = \App\Models\Backend\Masters\Physician::find($id);
				}else{
					$sRow = new \App\Models\Backend\Masters\Physician;
				}
				$sRow->names    			= request('names');
				$sRow->sex    				= request('sex');
				$sRow->types  				= request('types');
				$sRow->codes  				= request('codes');
				// $sRow->active    			= request('active')?request('active'):'N';
				
				// if( request('locale_id') ){
					// $sRow->locale_id    = request('locale_id');
					// }else{
					// $sRow->locale_id    = \Auth::user()->locale_id;
				// }
				
				$sRow->save();
				\DB::commit();
				
				return redirect()->action('Backend\Masters\PhysicianController@index')->with(['alert'=>\App\Models\Alert::Msg('success')]);
			} catch (\Exception $e) {
				echo $e->getMessage();
				\DB::rollback();
				return redirect()->action('Backend\Masters\PhysicianController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}
		
		
		public function edit($id)
		{
			try {				
				$sRow = \App\Models\Backend\Masters\Physician::find($id);
				return View('backend.masters.physician.form')->with(array('sRow'=>$sRow) );
			} catch (\Exception $e) {
				return redirect()->action('Backend\Masters\PhysicianController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}
		
		
		public function destroy($id)
		{
			$sRow = \App\Models\Backend\Masters\Physician::find($id);
			if( $sRow ){
				$sRow->forceDelete();
			}
			return response()->json(\App\Models\Alert::Msg('success'));
		}
		
		public function Datatable(){
			$sTable = \App\Models\Backend\Masters\Physician::search()->orderBy('id', 'asc');
			$sQuery = \DataTables::of($sTable);
			return $sQuery
			->addColumn('name', function($row) {				
				return is_null($row->names) ? '-' : $row->names;
			})
			->addColumn('sex', function($row) {				
				return is_null($row->sex) ? '-' : $row->sex;
			})
			->addColumn('types', function($row) {				
				return is_null($row->types) ? '-' : $row->types;
			})
			->addColumn('codes', function($row) {				
				return is_null($row->codes) ? '-' : $row->codes;
			})
			->addColumn('updated_at', function($row) {
				return is_null($row->updated_at) ? '-' : $row->updated_at;
			})
			->make(true);
		}
	}
