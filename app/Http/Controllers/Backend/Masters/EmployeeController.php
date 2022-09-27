<?php

	namespace App\Http\Controllers\Backend\Masters;

	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;

	class EmployeeController extends Controller
	{
		public function index(Request $request)
		{
			// return "Test";
			return view('backend.masters.employee.index');
		}

		public function create()
		{	
			$sRowPfn = \App\Models\Prefixname::get();	
			$sRowPos = \App\Models\Position::get();	
			$sRowDep = \App\Models\Department::get();	
			
			return view('backend.masters.employee.form')->with(
				[
					'sRowPfn' => $sRowPfn,										
					'sRowPos' => $sRowPos,										
					'sRowDep' => $sRowDep,										
				]
			);
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
			// dd('test');
			// dd(json_decode(request('position_id')));

			\DB::beginTransaction();
			try {
				if( $id ){
					$sRow = \App\Models\Employee::find($id);
					
				}else{
					$sRow = new \App\Models\Employee;
				}
				$sRow->code    			= request('code');
				$sRow->id_card_code    	= request('id_card_code');

				$sRow->prefixideng  	= json_decode(request()->prefixideng)->id;
				$sRow->prefixnameeng  	= json_decode(request()->prefixideng)->nameeng;
				$sRow->nameeng    		= request('nameeng');
				$sRow->lastnameeng  	= request('lastnameeng');

				$sRow->prefixidthai  	= json_decode(request()->prefixideng)->id;
				$sRow->prefixnamethai  	= json_decode(request()->prefixideng)->namethai;
				$sRow->namethai  		= request('namethai');
				$sRow->lastnamethai  	= request('lastnamethai');
				
				$sRow->position_id  	= json_decode(request('position_id'))->id;
				$sRow->position_name  	= json_decode(request('position_id'))->name;

				$sRow->department_id  	= json_decode(request('department_id'))->id;
				$sRow->department_name	= json_decode(request('department_id'))->name;
				
				$sRow->save();
				\DB::commit();

				return redirect()->action('Backend\Masters\EmployeeController@index')->with(['alert'=>\App\Models\Alert::Msg('success')]);
			} catch (\Exception $e) {			
				dd($e->getMessage());
				\DB::rollback();
				return redirect()->action('Backend\Masters\EmployeeController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}


		public function edit($id)
		{
			try {
				$sRowPfn = \App\Models\Prefixname::get();	
				$sRowPos = \App\Models\Position::get();	
				$sRowDep = \App\Models\Department::get();
				$sRow 	 = \App\Models\Employee::find($id);
				return View('backend.masters.employee.form')->with(
					[
						'sRowPfn' 	=> $sRowPfn,										
						'sRowPos' 	=> $sRowPos,										
						'sRowDep' 	=> $sRowDep,									
						'sRow' 		=> $sRow,									
					]
				);
				
			} catch (\Exception $e) {
				return redirect()->action('Backend\Masters\EmployeeController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}

		public function destroy($id)
		{
			$sRow = \App\Models\Employee::find($id);
			if( $sRow ){
				// $sRow->forceDelete(); // ลบจริง
				$sRow->delete();
			}
			return response()->json(\App\Models\Alert::Msg('success'));
		}

		public function Datatable(Request $request){
			$like = $request->Like;
			$sTable = \App\Models\Employee::
			when($like, function ($query) use ($like) {
				
				if (@$like['search_sort'] != "") {
					if (@$like['search_sort'] == "new_sort"){
						$query->orderby('id','desc');
					}
					if (@$like['search_sort'] == "old_sort"){
						$query->orderby('id','asc');
					}
					if (@$like['search_sort'] == "abc_sort"){
						$query->orderby('namethai','asc');
						$query->orderby('lastnamethai','asc');
					}
					if (@$like['search_sort'] == "zyx_sort"){
						$query->orderby('namethai','desc');
						$query->orderby('lastnamethai','desc');
					}
				}
				if (@$like['name'] != "") {
					$query->where('prefixnamethai', 'like', '%' . $like['name'] . '%');
					$query->orwhere('namethai', 'like', '%' . $like['name'] . '%');
					$query->orwhere('lastnamethai', 'like', '%' . $like['name'] . '%');
					$query->orwhere('prefixnameeng', 'like', '%' . $like['name'] . '%');
					$query->orwhere('nameeng', 'like', '%' . $like['name'] . '%');
					$query->orwhere('lastnameeng', 'like', '%' . $like['name'] . '%');
				}
				if (@$like['code'] != "") {
					$query->where('code', $like['code']);
				}
			});
			// dd($sTable->get());
			$sQuery = \DataTables::of($sTable);
			return $sQuery
			->addColumn('nameeng', function($row) {
				return $row->nameeng;
			})
			->addColumn('updated_at', function($row) {
				return is_null($row->updated_at) ? '-' : $row->updated_at;
			})
			->make(true);
		}
	}
