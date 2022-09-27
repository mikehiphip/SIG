<?php

	namespace App\Http\Controllers\Backend\Masters;

	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;

	class ReceiveEmailController extends Controller
	{
		public function index(Request $request)
		{
			// return "Test";
			return view('backend.masters.receive-email.index');
		}

		public function create()
		{
			return view('backend.masters.receive-email.form');
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
					$sRow = \App\Models\ReceiveEmail::find($id);					
				}else{
					$sRow = new \App\Models\ReceiveEmail;
				}	
				$sRow->name  			= request('name');
				$sRow->email  			= request('email');
				$sRow->password  		= request('password');
				
				$sRow->isActive 		= request('active')?request('active'):'N';
				
				$sRow->save();
				
				\DB::commit();

				return redirect()->action('Backend\Masters\ReceiveEmailController@index')->with(['alert'=>\App\Models\Alert::Msg('success')]);
			} catch (\Exception $e) {			
				dd($e->getMessage());
				\DB::rollback();
				return redirect()->action('Backend\Masters\ReceiveEmailController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}


		public function edit($id)
		{
			try {
				$sRow 	 = \App\Models\ReceiveEmail::find($id);
				return View('backend.masters.receive-email.form')->with(
					[									
						'sRow' 		=> $sRow,									
					]
				);
				
			} catch (\Exception $e) {
				return redirect()->action('Backend\Masters\ReceiveEmailController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}

		public function destroy($id)
		{
			$sRow = \App\Models\ReceiveEmail::find($id);
			if( $sRow ){
				// $sRow->forceDelete(); // ลบจริง
				$sRow->delete();
			}
			return response()->json(\App\Models\Alert::Msg('success'));
		}

		public function Datatable(){
			$sTable = \App\Models\ReceiveEmail::search();
			// dd($sTable->get());
			$sQuery = \DataTables::of($sTable);
			return $sQuery
			->addIndexColumn()
			// ->addColumn('nameeng', function($row) {
				// return $row->nameeng;
			// })
			->addColumn('updated_at', function($row) {
				return is_null($row->updated_at) ? '-' : $row->updated_at;
			})
			
			->make(true);
		}
	}
