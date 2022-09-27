<?php

	namespace App\Http\Controllers\Backend\Masters;

	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;

	class PositionController extends Controller
	{
		public function index(Request $request)
		{
			// return "Test";
			return view('backend.masters.position.index');
		}

		public function create()
		{
			return view('backend.masters.position.form');
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
					$sRow = \App\Models\Position::find($id);
					}else{
					$sRow = new \App\Models\Position;
				}				
				$sRow->name    				= request('name');
        
				$sRow->save();
				\DB::commit();

				return redirect()->action('Backend\Masters\PositionController@index')->with(['alert'=>\App\Models\Alert::Msg('success')]);
			} catch (\Exception $e) {
				echo $e->getMessage();
				\DB::rollback();
				return redirect()->action('Backend\Masters\PositionController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}


		public function edit($id)
		{
			try {
				$sRow 	= \App\Models\Position::find($id);
				
				return View('backend.masters.position.form')->with(
					[
						'sRow'			=> $sRow,						
					]
				);
			} catch (\Exception $e) {
				return redirect()->action('Backend\Masters\PositionController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}


		public function destroy($id)
		{
			$sRow = \App\Models\Position::find($id);
			if( $sRow ){
				// $sRow->forceDelete(); // ลบจริง
				$sRow->delete();
			}
			return response()->json(\App\Models\Alert::Msg('success'));
		}

		public function Datatable(Request $request){
			$like = $request->Like;
			// $sTable = \App\Models\Position::search();
			$sTable = \App\Models\Position::
			when($like, function ($query) use ($like) {
				
				if (@$like['search_sort'] != "") {
					if (@$like['search_sort'] == "new_sort"){
						$query->orderby('id','desc');
					}
					if (@$like['search_sort'] == "old_sort"){
						$query->orderby('id','asc');
					}
					if (@$like['search_sort'] == "abc_sort"){
						$query->orderby('name','asc');
					}
					if (@$like['search_sort'] == "zyx_sort"){
						$query->orderby('name','desc');
					}
				}
				if (@$like['name'] != "") {
					$query->where('name', 'like', '%' . $like['name'] . '%');
				}
			});
			$sQuery = \DataTables::of($sTable);
			return $sQuery
			->addIndexColumn()
			// ->addColumn('name', function($row) {
				// return $row->name;
			// })
			->addColumn('updated_at', function($row) {
				return is_null($row->updated_at) ? '-' : $row->updated_at;
			})
			->make(true);
		}
	}
