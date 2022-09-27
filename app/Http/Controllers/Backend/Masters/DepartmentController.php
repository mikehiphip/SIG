<?php

	namespace App\Http\Controllers\Backend\Masters;

	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;

	class DepartmentController extends Controller
	{
		public function index(Request $request)
		{
			// return "Test";
			return view('backend.masters.department.index');
		}

		public function create()
		{
			return view('backend.masters.department.form');
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
				if( $id )
				{
					$sRow = \App\Models\Department::find($id);
					// $sRow->sort = request('sort');
				}
				else
				{
					$sRow = new \App\Models\Department;
					$count = \App\Models\Department::where('deleted_at',null)->count();
					// $sRow->sort = $count+1;
				}				
				$sRow->name = request('name');
				$sRow->show_status = request('show_status');
				$sRow->save();
				if (request('image')) {		
					// if(!empty($sDataM->files)){		
					//     @unlink('public/asset/images/regis_part2/'.$sDataM->pic.$sDataM->ext);
					// }
					
					$path   = 'public/asset/department/images/';
					$sName  = str_pad($sRow->id."_".strtotime(date("Y-m-d H:i:s")), 20, '0', STR_PAD_LEFT);
					$ext    = '.' . strtolower(request('image')->getClientOriginalExtension());                    
					
					$image  = \Image::make(request('image')->getPathName());					
					$image->save($path . $sName . $ext);
					$image->destroy();
					
					$sRow->image   = $sName . $ext;
					$sRow->save();
				}
				\DB::commit();

				return redirect()->action('Backend\Masters\DepartmentController@index')->with(['alert'=>\App\Models\Alert::Msg('success')]);
			} catch (\Exception $e) {
				echo $e->getMessage();
				\DB::rollback();
				return redirect()->action('Backend\Masters\DepartmentController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}


		public function edit($id)
		{
			try {
				$sRow 	= \App\Models\Department::find($id);
				
				return View('backend.masters.department.form')->with(
					[
						'sRow'			=> $sRow,						
					]
				);
			} catch (\Exception $e) {
				return redirect()->action('Backend\Masters\DepartmentController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}


		public function destroy($id)
		{
			$sRow = \App\Models\Department::find($id);
			if( $sRow ){
				// $sRow->forceDelete(); // ลบจริง
				$sRow->delete();
			}
			return response()->json(\App\Models\Alert::Msg('success'));
		}

		public function Datatable(Request $request){
			$like = $request->Like;
			// $sTable = \App\Models\Department::search();
			$sTable = \App\Models\Department::
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
			->addColumn('name', function($row) 
			{
				$data = "";
				$status = "";
				if($row->show_status == "on")
				{
					$status = "<span class='badge badge-sm badge-success'>แสดงผล</span>";
				}
				else{
					$status = "<span class='badge badge-sm badge-danger'>ไม่แสดงผล</span>";
				}

				$data = "$status $row->name";

				return "$data";
			})
			->addColumn('updated_at', function($row) {
				return is_null($row->updated_at) ? '-' : $row->updated_at;
			})
			->rawColumns(['name'])
			->make(true);
		}
	}
