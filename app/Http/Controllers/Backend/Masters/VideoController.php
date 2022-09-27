<?php

	namespace App\Http\Controllers\Backend\Masters;

	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
use App\Models\Station;

	class VideoController extends Controller
	{
		public function index(Request $request)
		{
			// return "Test";
			return view('backend.masters.video.index');
		}

		public function create()
		{
			$sRowDep = \App\Models\Department::get();	
			
			return view('backend.masters.video.form')->with(
				[													
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
					$sRow = \App\Models\Video::find($id);
					
				}else{
					$sRow = new \App\Models\Video;
				}							
				$sRow->name_m  			= request('name_m');
				$sRow->name_status  	= request('name_status');
				$sRow->details  		= request('details');
				$sRow->views  			= request('views');
				$sRow->unit  			= request('unit');

				$sRow->department_id  	= json_decode(request('department_id'))->id;
				$sRow->station_id  	= request('station_id');
				$sRow->department_name	= json_decode(request('department_id'))->name;
				// dd($sRow);
				$sRow->save();
				
				if (request('pic')) {		
					// if(!empty($sDataM->files)){		
					//     @unlink('public/asset/images/regis_part2/'.$sDataM->pic.$sDataM->ext);
					// }
					
					$path   = 'public/asset/video/images/';
					$sName  = str_pad($sRow->id."_".strtotime(date("Y-m-d H:i:s")), 20, '0', STR_PAD_LEFT);
					$ext    = '.' . strtolower(request('pic')->getClientOriginalExtension());                    
					
					$image  = \Image::make(request('pic')->getPathName());					
					$image->save($path . $sName . $ext);
					$image->destroy();
					
					$sRow->pic   = $sName . $ext;
					$sRow->save();
				}
				
				if (request('files')) {		
					// if(!empty($sDataM->files)){		
					//     @unlink('public/asset/images/regis_part2/'.$sDataM->pic.$sDataM->ext);
					// }
					
					$path   = 'public/asset/video/';
					$sName  = str_pad($sRow->id."_".strtotime(date("Y-m-d H:i:s")), 20, '0', STR_PAD_LEFT);
					$ext    = '.' . strtolower(request('files')->getClientOriginalExtension());                    
					
					$fileTmpPath    = request('files')->getPathName();                    
                    move_uploaded_file($fileTmpPath, $path . $sName . $ext);
					
					$sRow->name   = $sName . $ext;
					// dd($sRow);
					$sRow->save();
				}
				
				\DB::commit();

				return redirect()->action('Backend\Masters\VideoController@index')->with(['alert'=>\App\Models\Alert::Msg('success')]);
			} catch (\Exception $e) {			
				dd($e->getMessage());
				\DB::rollback();
				return redirect()->action('Backend\Masters\VideoController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}


		public function edit($id)
		{
			try {				
				$sRowDep = \App\Models\Department::get();
				$sRow 	 = \App\Models\Video::find($id);
				return View('backend.masters.video.form')->with(
					[										
						'sRowDep' 	=> $sRowDep,									
						'sRow' 		=> $sRow,									
					]
				);
				
			} catch (\Exception $e) {
				return redirect()->action('Backend\Masters\VideoController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}

		public function destroy($id)
		{
			$sRow = \App\Models\Video::find($id);
			if( $sRow ){
				// $sRow->forceDelete(); // ลบจริง
				$sRow->delete();
			}
			return response()->json(\App\Models\Alert::Msg('success'));
		}

		public function Datatable(Request $request){
			$like = $request->Like;
			// $sTable = \App\Models\Video::search()->orderby('id','desc');
			$sTable = \App\Models\Video::when($like, function ($query) use ($like) {
				
				if (@$like['search_sort'] != "") {
					if (@$like['search_sort'] == "new_sort"){
						$query->orderby('id','desc');
					}
					if (@$like['search_sort'] == "old_sort"){
						$query->orderby('id','asc');
					}
					if (@$like['search_sort'] == "abc_sort"){
						$query->orderby('details','asc');
					}
					if (@$like['search_sort'] == "zyx_sort"){
						$query->orderby('details','desc');
					}
				}
				if (@$like['name'] != "") {
					$query->where('details', 'like', '%' . $like['name'] . '%');
				}
			});
			// dd($sTable->get());
			$sQuery = \DataTables::of($sTable);
			return $sQuery
			
			// ->addColumn('nameeng', function($row) {
				// return $row->nameeng;
			// })
			->addColumn('updated_at', function($row) {
				return is_null($row->updated_at) ? '-' : $row->updated_at;
			})
			
			->make(true);
		}

		public function get_station(Request $request)
		{
			$id = json_decode(request('id'))->id;
			$row = Station::where('department_id',$id)->get();
			if($row->count() > 0)
			{
				foreach($row as $r)
				{
					$json_result[] = [
						'id'=> $r->id,
						'name'=> $r->name,
					];
					
				}
				echo json_encode($json_result);
			}
			else
			{
				$json_result[] = null;
				echo json_encode($json_result);
			}
			
		}
	}
