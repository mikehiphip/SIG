<?php
	
	namespace App\Http\Controllers\Backend;
	
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use DB;
	use App\Http\Controllers\Frontend\NotiController;
	
	class ReportController extends Controller
	{
		
		public function employee()
		{
			// return "Test";
			return view('backend.report.employee');
		}
		public function employeeDatatable(){			
			$sTable = \App\Models\Employee::search()->orderBy('id', 'asc');
			$sQuery = \DataTables::of($sTable);
			return $sQuery
			->addIndexColumn()	

			
			// ->addColumn('medical_expenses_vat_bef', function($row) {				
			// 	$total = is_null($row->medical_expenses) ? '-' : (($row->medical_expenses*100)/107);
			// 	return ($total == 0.00) ? '-' : number_format($total ,2);
			// })
			// ->escapeColumns('treatment_date')

			// ->addColumn('treatment_date', function($row) {
			// 	return is_null($row->treatment_date) ? '-' : date_format(date_create($row->treatment_date), 'd-m-Y');
			// })
			// ->escapeColumns('treatment_date')

			// ->addColumn('medical_radiographer', function($row) {		
			// 	$objs		= "";
			// 	$row_check 	= (is_null($row->medical_radiographer) || $row->medical_radiographer=="") ? '-' : $row->medical_radiographer;
				
			// 	if($row_check!='-'){
			// 		$objs_arr 	= explode(",",$row_check);					
			// 		foreach($objs_arr as $k => $v){
			// 			$sRowObj = \App\Models\Backend\Masters\Technician::find($v);
			// 			if($k==0){
			// 				$objs = ($k+1)."). ".$sRowObj->names;
			// 			}else{
			// 				$objs .= "<br>".($k+1)."). ".$sRowObj->names;
			// 			}					
			// 		}
			// 	}else{
			// 		$objs = '-';
			// 	}
			// 	return $objs;
			// })
			// ->escapeColumns('medical_radiographer')

			
			->make(true);
		}		
		
		public function getMonth($month)
		{
			$printmonth = "";
			switch($month)
			{
				case "01": $printmonth = "มกราคม"; break;
				case "02": $printmonth = "กุมภาพันธ์"; break;
				case "03": $printmonth = "มีนาคม"; break;
				case "04": $printmonth = "เมษายน"; break;
				case "05": $printmonth = "พฤษภาคม"; break;
				case "06": $printmonth = "มิถุนายน"; break;
				case "07": $printmonth = "กรกฏาคม"; break;
				case "08": $printmonth = "สิงหาคม"; break;
				case "09": $printmonth = "กันยายน"; break;
				case "10": $printmonth = "ตุลาคม"; break;
				case "11": $printmonth = "พฤศจิกายน"; break;
				case "12": $printmonth = "ธันวาคม"; break;         
			}      
			return $printmonth;
		}

		
		public function train()
		{
			// return "Test";
			return view('backend.report.train');
		}
		public function trainDel(Request $request)
		{			
			$id 	= $request['id'];
			$sData 	= \App\Models\Train::find($id);
			$sData->delete();
		}
		public function trainDatatable(){			
			$sTable = \App\Models\Train::search()->orderBy('id', 'asc');
			$sQuery = \DataTables::of($sTable);
			return $sQuery
			->addIndexColumn()

			->editColumn('proto', function ($row) {
				// return asset('public/asset/video/images');
				// return $row->proto;
				if ($row->proto) {
					return '<img src="' . asset('public/asset/photo') . '/' . $row->proto . '" width="200px" height="100px"/>';
				} else {
					return '-';
				}
			})
			->escapeColumns('proto')

			->addColumn('detail_emp', function($row) {
				$objs		= "";
				$objs_arr 	= \App\Models\TrainEmp::where('id_train', $row->id)->get();			

				foreach($objs_arr as $k => $v){
					$sRowObjE = \App\Models\Employee::where('code', $v->id_emp)->first();
					if($sRowObjE){						
						if($k==0){
							$objs .= ($k+1)."). ".$sRowObjE->prefixnamethai.' '.$sRowObjE->namethai.' '.$sRowObjE->lastnamethai;
						}else{
							$objs .= "<br>".($k+1)."). ".$sRowObjE->prefixnamethai.' '.$sRowObjE->namethai.' '.$sRowObjE->lastnamethai;
						}	
					}else{						
						return '-';						
					}					
				}						
				return $objs;
			})
			->escapeColumns('detail_emp')

			
			->make(true);
		}	
		public function trainExcel(Request $request)
		{
			return view("backend.report.report_excel",[
				'namefile' => "Training Report",
			]);
		}

		
	}
