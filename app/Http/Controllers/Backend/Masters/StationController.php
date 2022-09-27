<?php

	namespace App\Http\Controllers\Backend\Masters;

	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use DB;

	class StationController extends Controller
	{
		public function index(Request $request,$id)
		{
			$depart = DB::table('sg_department')->find($id);
			return view('backend.masters.station.index',[
                'main_id' => $id,
				'depart' => $depart,
            ]);
		}

		public function create($id)
		{
			$depart = DB::table('sg_department')->find($id);
            return view('backend.masters.station.form',[
                'main_id' => $id,
				'depart' => $depart,
            ]);
		}
        public function edit($id,$sub_id)
		{
			try {
				$sRow 	= \App\Models\Station::find($sub_id);
				$depart = DB::table('sg_department')->find($id);
				return View('backend.masters.station.form')->with(
					[
                        'main_id' => $id,
						'sRow'			=> $sRow,		
						'depart' => $depart,				
					]
				);
			} catch (\Exception $e) {
                return redirect("backend/masters/station/$id")->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}


		public function store(Request $request,$id,$sub_id=null)
		{
			return $this->form($request,$id,$sub_id);
		}

		public function update(Request $request, $id, $sub_id)
		{
			return $this->form($request,$id,$sub_id);
		}

		public function form($request,$id,$sub_id=null)
		{
			\DB::beginTransaction();
			try {
				if( $sub_id )
                {
					$sRow = \App\Models\Station::find($sub_id);
				}
                else
                {
					$sRow = new \App\Models\Station;
				    $sRow->department_id = $id;
				    $sRow->created_at = date('Y-m-d H:i:s');
				    
				}				
				$sRow->name = request('name');
				$sRow->show_status = request('show_status');
				// $sRow->sort = request('sort');
                $sRow->updated_at = date('Y-m-d H:i:s');
				$sRow->save();
				\DB::commit();
                return redirect("backend/masters/station/$id")->with(['alert'=>\App\Models\Alert::Msg('success')]);
			} catch (\Exception $e) {
				\DB::rollback();
                return redirect("backend/masters/station/$id")->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}


		

		public function destroy($id)
		{
			$sRow = \App\Models\Station::find($id);
			if( $sRow ){
				// $sRow->forceDelete(); // ลบจริง
				$sRow->delete();
			}
			return response()->json(\App\Models\Alert::Msg('success'));
		}

		public function Datatable(Request $request,$id){
			$like = $request->Like;
			// $sTable = \App\Models\Station::search();
			$sTable = \App\Models\Station::where('department_id',$id)->
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
			->addColumn('name', function($row) {
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
