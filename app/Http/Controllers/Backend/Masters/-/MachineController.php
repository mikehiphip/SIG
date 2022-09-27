<?php
	
	namespace App\Http\Controllers\Backend\Masters;
	
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	
	class MachineController extends Controller 
	{
		public function index(Request $request)
		{
			// return "Test";
			return view('backend.masters.machine.index');
		}
		
		public function create()
		{		
			// return "Test";
			$sMachineType = \App\Models\Backend\Masters\MachineType::orderBy('id', 'asc')->get();
			return view('backend.masters.machine.form')->with(['sMachineType'=>$sMachineType]);
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
					$sRow = \App\Models\Backend\Masters\Machine::find($id);
					}else{
					$sRow = new \App\Models\Backend\Masters\Machine;
				}
				$sRow->machinecode    		= request('machinecode');
				$sRow->description    		= request('description');
				$sRow->machineid  			= request('machineid');
				$sRow->status  				= request('status');										
				$sRow->machinetypeid  		= request('machinetypeid');										
				// $sRow->active    			= request('active')?request('active'):'N';
				
				// if( request('locale_id') ){
					// $sRow->locale_id    = request('locale_id');
					// }else{
					// $sRow->locale_id    = \Auth::user()->locale_id;
				// }
				
				$sRow->save();
				\DB::commit();
				
				return redirect()->action('Backend\Masters\MachineController@index')->with(['alert'=>\App\Models\Alert::Msg('success')]);
			} catch (\Exception $e) {
				echo $e->getMessage();
				\DB::rollback();
				return redirect()->action('Backend\Masters\MachineController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}
		
		
		public function edit($id)
		{
			try {				
				$sRow = \App\Models\Backend\Masters\Machine::find($id);
				
				$sMachineType = \App\Models\Backend\Masters\MachineType::orderBy('id', 'asc')->get();
				
				return view('backend.masters.machine.form')->with(['sRow'=>$sRow, 'sMachineType'=>$sMachineType]);
				// return View('backend.masters.machine.form')->with(array('sRow'=>$sRow) );
			} catch (\Exception $e) {
				return redirect()->action('Backend\Masters\MachineController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}
		
		
		public function destroy($id)
		{
			$sRow = \App\Models\Backend\Masters\Machine::find($id);
			if( $sRow ){
				$sRow->forceDelete();
			}
			return response()->json(\App\Models\Alert::Msg('success'));
		}
		
		public function Datatable(){
			$sTable = \App\Models\Backend\Masters\Machine::search()->orderBy('id', 'asc');
			/* For Debug
			// $sTable = $sTable->with('machineType');
			// dd($sTable->get());		
			*/
			
			$sQuery = \DataTables::of($sTable);
			return $sQuery
			->addColumn('machinetypename', function($row) {
				return $row->machineType->names;				
			})
			->addColumn('machinecode', function($row) {
				return is_null($row->machinecode) ? '-' : $row->machinecode;
			})
			->addColumn('description', function($row) {
				return is_null($row->description) ? '-' : $row->description;
			})
			->addColumn('machineid', function($row) {
				return is_null($row->machineid) ? '-' : $row->machineid;
			})
			->addColumn('status', function($row) {
				return is_null($row->status) ? '-' : $row->status;
			})
			->addColumn('updated_at', function($row) {
				return is_null($row->updated_at) ? '-' : $row->updated_at;
			})
			->make(true);
		}
	}
