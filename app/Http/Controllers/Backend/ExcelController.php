<?php
	
	namespace App\Http\Controllers\Backend;
	
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use DB;
	// use File;
	// use Excel;
	
	class ExcelController extends Controller
	{
		/* โรงพยาบาล */
		public function excelImportSheetHospital()
		{	
			return "Complete";		
			return view('backend.aboutfile.excel-file-sheet-hospital');
		}
		public function excelImportSheetHospitalUpload(Request $request)
		{			
			$pathExcel		= $request->file('upload')->getRealPath();
			$objPHPExcel 	= \PhpOffice\PhpSpreadsheet\IOFactory::load($pathExcel);
			$countPHPExcel	= 3;
			$c_yes			= 0;
			$c_no			= 0;
			$c_status		= 0;
			$c_total		= 0;
			
			for ($i=0; $i<$countPHPExcel; $i++) {
				$c_total_sub	= 0;
				$objWorksheet 	= $objPHPExcel->setActiveSheetIndex($i);	// e.g. 0 -> page first
				$highestRow 	= $objWorksheet->getHighestRow(); 		// e.g. 10
				$highestColumn 	= $objWorksheet->getHighestColumn();	// e.g 'F'				

				echo "<table border='1'>";

				for ($row = 2; $row <= $highestRow; ++$row) {
					$c_total++;
					$c_total_sub++;

					/* 2. E. Hospitals */
					$hospitals 				= trim($objWorksheet->getCell('E' . $row)->getValue());			// ชื่อโรงพยาบาล
					
					$sqlhosp   				= "select id, name from nm_hospital where name='$hospitals'";					
					$rowhosp_arr 			= DB::select($sqlhosp);
					$rowhosp_count 			= count($rowhosp_arr);	
					if($rowhosp_count>0){
						$c_yes++;
						$c_status = '1';
					}else{
						$c_no++;
						$c_status = '0';											
					}	

					if($c_status=='0'){
						$sDataHospital = new \App\Models\Backend\Masters\Hospital;
						$sDataHospital->name       = $hospitals;						
						$sDataHospital->save();
						$hospitals_id 		= $sDataHospital->id;
					}					

					/* Log 1.*/
					// $sExcelHospital = new \App\Models\Backend\Masters\ExcelHospital;
					// $sExcelHospital->names       	= $hospitals;						
					// $sExcelHospital->chk_status     = $c_status;						
					// $sExcelHospital->chk_yes      	= $c_yes;						
					// $sExcelHospital->chk_no       	= $c_no;						
					// $sExcelHospital->sheet       	= ($i+1);						
					// $sExcelHospital->sheet_number   = $c_total_sub;						
					// $sExcelHospital->save();					

					echo "<tr>";
												
						echo "<td>".$c_total_sub."</td>";
						echo "<td>".$hospitals."</td>";
						echo "<td>".$c_status."</td>";
						echo "<td>".$c_yes."</td>";
						echo "<td>".$c_no."</td>";

					echo "</tr>";					
				}				
				echo "</table>";
				echo "<br><center>---------</center><br>";
			}

			echo "<br>";
			echo "ทั้งหมด : ".$c_total."<br>";
			echo "มีอยู่ในฐานข้อมูล : ".$c_yes."<br>";
			echo "ไม่มีอยู่ในฐานข้อมูล : ".$c_no."<br>";
		}

		/* ผู้ป่วย */
		public function excelImportSheetPatient()
		{	
			// return "ผู้ป่วย";	
			return "Complete";	
			return view('backend.aboutfile.excel-file-sheet-patient');
		}
		public function excelImportSheetPatientUpload(Request $request)
		{			
			$pathExcel		= $request->file('upload')->getRealPath();
			$objPHPExcel 	= \PhpOffice\PhpSpreadsheet\IOFactory::load($pathExcel);
			$countPHPExcel	= 3;
			$c_yes			= 0;		// ลำดับมีข้อมูลในฐานข้อมูล
			$c_no			= 0;		// ลำดับไม่มีข้อมูลในฐานข้อมูล
			$c_status		= 0;		// 1 : มีข้อมูลในฐานข้อมูล, 0 : ไม่มีข้อมูลในฐานข้อมูล
			$c_total		= 0;
			
			for ($i=0; $i<$countPHPExcel; $i++) {
				$c_total_sub	= 0;
				$objWorksheet 	= $objPHPExcel->setActiveSheetIndex($i);	// e.g. 0 -> page first
				$highestRow 	= $objWorksheet->getHighestRow(); 		// e.g. 10
				$highestColumn 	= $objWorksheet->getHighestColumn();	// e.g 'F'				

				echo "<table border='1'>";

				for ($row = 2; $row <= $highestRow; ++$row) {
					$c_total++;
					$c_total_sub++;

					/* 1. A. Sheet For Make ID*/					
					$sheetall 				= trim($objWorksheet->getCell('A' . $row)->getValue());			// หัตถการ
					$book1 					= trim($objWorksheet->getCell('C' . $row)->getValue());			// เล่มที่
					$book2 					= trim($objWorksheet->getCell('D' . $row)->getValue());			// เลขที่
					

					/* 2. Patient */
					$namepre 				= trim($objWorksheet->getCell('G' . $row)->getValue());			// คำนำหน้า
					$namefirst 				= trim($objWorksheet->getCell('H' . $row)->getValue());			// ชื่อ
					$namelast 				= trim($objWorksheet->getCell('I' . $row)->getValue());			// นามสกุล					
					$namefull				= $namepre.' '.$namefirst.' '.$namelast;						// สำหรับไว้ที่ sheetment ต่าง ๆ 
					$hn 					= trim($objWorksheet->getCell('F' . $row)->getValue());			// HN No.
					
					$sqldata   				= "
						select * from nm_patient 
						where name_first='$namefirst'
							and name_last='$namelast'						
					";					
					$rowdata_arr 			= DB::select($sqldata);
					$patient 				= count($rowdata_arr);	
					if($patient>0){
						$c_yes++;
						$c_status = '1';
					}else{
						$c_no++;
						$c_status = '0';											
					}

					/* Log 1. เอาข้อมูลเข้า log*/
					// $sExcelPatient = new \App\Models\Backend\Masters\ExcelPatient;
					// $sExcelPatient->chk_status     	= $c_status;						
					// $sExcelPatient->chk_yes      	= $c_yes;						
					// $sExcelPatient->chk_no       	= $c_no;						
					// $sExcelPatient->sheet       	= ($i+1);						
					// $sExcelPatient->sheet_number   	= $c_total_sub;		

					// $sExcelPatient->namesp       	= $namepre;
					// $sExcelPatient->namesf       	= $namefirst;
					// $sExcelPatient->namesl       	= $namelast;
					// $sExcelPatient->namesfull      	= $namefull;
					// $sExcelPatient->hn_no       	= $hn;
					
					// switch ($sheetall) {
					// 	case "ESWL Treatment":													
					// 		$sExcelPatient->book_number3       	= $book1;
					// 		$sExcelPatient->book_number5       	= $book2;
					// 		break;
					// 	case "Endourological Treatment":
					// 		$sExcelPatient->book_number3_endo  	= $book1;
					// 		$sExcelPatient->book_number4_endo  	= $book2;							
					// 		break;
					// 	case "Transurethral Surgical Treatment":
					// 		$sExcelPatient->book_number3_surg  	= $book1;
					// 		$sExcelPatient->book_number4_surg 	= $book2;
					// 		break;													
					// 	default:
					// 		$technique_all = '';
					// }

					// $hospitals 				= trim($objWorksheet->getCell('E' . $row)->getValue());			// ชื่อโรงพยาบาล					
					// $sqlhosp   				= "select id, name from nm_hospital where name='$hospitals'";					
					// $rowhosp_arr 			= DB::select($sqlhosp);	
					
					// $sExcelPatient->hospid  = $rowhosp_arr['0']->id;
					
					// $sExcelPatient->save();
					
					/* นำข้อมูลเข้าตารางจริง */
					if($c_status=='0'){
						$sDataPatient = new \App\Models\Backend\Masters\Patient;
						$sDataPatient->name_pre       	= $namepre;
						$sDataPatient->name_first      	= $namefirst;
						$sDataPatient->name_last       	= $namelast;
						$sDataPatient->name_full      	= $namefull;
						$sDataPatient->hn_no       		= $hn;	
						
						switch ($sheetall) {
							case "ESWL Treatment":													
								$sDataPatient->book_number3       	= $book1;
								$sDataPatient->book_number5       	= $book2;
								break;
							case "Endourological Treatment":
								$sDataPatient->book_number3_endo  	= $book1;
								$sDataPatient->book_number4_endo  	= $book2;							
								break;
							case "Transurethral Surgical Treatment":
								$sDataPatient->book_number3_surg  	= $book1;
								$sDataPatient->book_number4_surg 	= $book2;
								break;													
							default:
								$technique_all = '';
						}
						
						$hospitals 				= trim($objWorksheet->getCell('E' . $row)->getValue());			// ชื่อโรงพยาบาล					
						$sqlhosp   				= "select id, name from nm_hospital where name='$hospitals'";					
						$rowhosp_arr 			= DB::select($sqlhosp);	
						
						$sDataPatient->id_hosp  	= $rowhosp_arr['0']->id;
						$sDataPatient->name_hosp  	= $hospitals;

						$sDataPatient->save();	
											
					}					

					echo "<tr>";
												
						echo "<td>".$c_total_sub."</td>";

						echo "<td>".$namepre."</td>";
						echo "<td>".$namefirst."</td>";
						echo "<td>".$namelast."</td>";
						echo "<td>".$namefull."</td>";
						echo "<td>".$hn."</td>";						

						echo "<td>".$c_status."</td>";
						echo "<td>".$c_yes."</td>";
						echo "<td>".$c_no."</td>";

					echo "</tr>";					
				}				
				echo "</table>";
				echo "<br><center>---------</center><br>";
			}

			echo "<br>";
			echo "ทั้งหมด : ".$c_total."<br>";
			echo "มีอยู่ในฐานข้อมูล : ".$c_yes."<br>";
			echo "ไม่มีอยู่ในฐานข้อมูล : ".$c_no."<br>";
		}

		/* แพทย์ */
		public function excelImportSheetPhysician()
		{	
			// return "Complete";		
			return view('backend.aboutfile.excel-file-sheet-physician');
		}
		public function excelImportSheetPhysicianUpload(Request $request)
		{			
			$pathExcel		= $request->file('upload')->getRealPath();
			$objPHPExcel 	= \PhpOffice\PhpSpreadsheet\IOFactory::load($pathExcel);
			$countPHPExcel	= 3;
			$c_yes			= 0;
			$c_no			= 0;
			$c_status		= 0;
			$c_total		= 0;
			
			for ($i=0; $i<$countPHPExcel; $i++) {
				$c_total_sub	= 0;
				$objWorksheet 	= $objPHPExcel->setActiveSheetIndex($i);	// e.g. 0 -> page first
				$highestRow 	= $objWorksheet->getHighestRow(); 		// e.g. 10
				$highestColumn 	= $objWorksheet->getHighestColumn();	// e.g 'F'				

				echo "<table border='1'>";

				for ($row = 2; $row <= $highestRow; ++$row) {
					$c_total++;
					$c_total_sub++;

					/* 2. E. Hospitals */
					$physician 				= trim($objWorksheet->getCell('J' . $row)->getValue());			// ชื่อโรงพยาบาล
					
					$sqlphys   				= "select id, names from nm_physician where names='$physician'";					
					$rowphys_arr 			= DB::select($sqlphys);
					$rowphys_count 			= count($rowphys_arr);	
					if($rowphys_count > 0){
						$c_yes++;
						$c_status = '1';
					}else{
						$c_no++;
						$c_status = '0';											
					}	

					if($c_status=='0'){
						$sDataPhysician = new \App\Models\Backend\Masters\Physician;
						$sDataPhysician->names       = $physician;						
						$sDataPhysician->save();
						$physician_id 		= $sDataPhysician->id;
					}					

					/* Log 1.*/
					// $sExcelHospital = new \App\Models\Backend\Masters\ExcelPhysician;
					// $sExcelHospital->names       	= $physician;						
					// $sExcelHospital->chk_status     = $c_status;						
					// $sExcelHospital->chk_yes      	= $c_yes;						
					// $sExcelHospital->chk_no       	= $c_no;						
					// $sExcelHospital->sheet       	= ($i+1);						
					// $sExcelHospital->sheet_number   = $c_total_sub;						
					// $sExcelHospital->save();					

					echo "<tr>";
												
						echo "<td>".$c_total_sub."</td>";
						echo "<td>".$physician."</td>";
						echo "<td>".$c_status."</td>";
						echo "<td>".$c_yes."</td>";
						echo "<td>".$c_no."</td>";

					echo "</tr>";					
				}				
				echo "</table>";
				echo "<br><center>---------</center><br>";
			}

			echo "<br>";
			echo "ทั้งหมด : ".$c_total."<br>";
			echo "มีอยู่ในฐานข้อมูล : ".$c_yes."<br>";
			echo "ไม่มีอยู่ในฐานข้อมูล : ".$c_no."<br>";
		}

		public function excelImportSheet()
		{	
			// return "Complete";		
			return view('backend.aboutfile.excel-file-sheet');
		}
		public function excelImportSheetUpload(Request $request)
		{			
			$pathExcel		= $request->file('upload')->getRealPath();
			$objPHPExcel 	= \PhpOffice\PhpSpreadsheet\IOFactory::load($pathExcel);
			$countPHPExcel	= 3;
			$c_yes			= 0;
			$c_no			= 0;
			$c_status		= 0;
			$c_total		= 0;
			
			for ($i=0; $i<$countPHPExcel; $i++) {

				$objWorksheet 	= $objPHPExcel->setActiveSheetIndex($i);	// e.g. 0 -> page first
				$highestRow 	= $objWorksheet->getHighestRow(); 		// e.g. 10
				$highestColumn 	= $objWorksheet->getHighestColumn();	// e.g 'F'				
			
				echo "<table border='1'>";

				for ($row = 2; $row <= $highestRow; ++$row) {

					/* 1. E. Hospitals For Get ID*/
					$hospitals 				= trim($objWorksheet->getCell('E' . $row)->getValue());			// ชื่อโรงพยาบาล
			
					$sqlhosp   				= "select id, name from nm_hospital where name='$hospitals'";					
					$rowhosp_arr 			= DB::select($sqlhosp);
					$rowhosp_count 			= count($rowhosp_arr);				
					switch ($rowhosp_count) {
						case 0:	break;
						case 1:
							/* มีข้อมูล 1 ให้ทำดึงข้อมูล */
							$rowhosp			= $rowhosp_arr['0'];
							$hospitals_id 		= $rowhosp->id;
							$hospitals_name		= $rowhosp->name;
							break;																		
						default:
							/* มีข้อมูล มากกว่า 1 ให้ทำดึงข้อมูล */
							$rowhosp			= $rowhosp_arr['0'];
							$hospitals_id 		= $rowhosp->id;
							$hospitals_name		= $rowhosp->name;							
					}
			
					/* 2. หากค้นหาไม่เจอที่ตารางผู้ป่วยให้เก็บที่ตารางผู้ป่วยแล้ว get id ออกมา ก่อนที่จะเก็บ sheetment ต่าง ๆ  */
					$namepre 				= trim($objWorksheet->getCell('G' . $row)->getValue());			// คำนำหน้า
					$namefirst 				= trim($objWorksheet->getCell('H' . $row)->getValue());			// ชื่อ
					$namelast 				= trim($objWorksheet->getCell('I' . $row)->getValue());			// นามสกุล					
					$namefull				= $namepre.' '.$namefirst.' '.$namelast;						// สำหรับไว้ที่ sheetment ต่าง ๆ 
					$hn 					= trim($objWorksheet->getCell('F' . $row)->getValue());			// HN No.	
			
					$sql_patient   			= "select * from nm_patient where name_first='$namefirst' and name_last='$namelast'";					
					$row_patient_arr		= DB::select($sql_patient);					
					$row_patient_count		= count($row_patient_arr);
					// dd($row_patient_arr);
					switch ($row_patient_count) {
						case 0: break;
						case 1:
							/* มีข้อมูล 1 ให้ทำดึงข้อมูล */
							$row_patient		= $row_patient_arr['0'];
							$patient_id 		= $row_patient->id;
			
							$patient_id_number 	= $row_patient->number_id;
							$patient_age 		= $row_patient->age;
							
							
							break;																		
						default:
							/* มีข้อมูล มากกว่า 1 ให้ทำดึงข้อมูล */
							$row_patient		= $row_patient_arr['0'];
							$patient_id 		= $row_patient->id;		
							
							$patient_id_number 	= $row_patient->number_id;
							$patient_age 		= $row_patient->age;
							
					}					
			
					/* B. Date */
					$excel_date 			= trim($objWorksheet->getCell('B' . $row)->getValue());			// Date
					$unix_date 				= ($excel_date - 25569) * 86400;
					$excel_date 			= 25569 + ($unix_date / 86400);
					$unix_date 				= ($excel_date - 25569) * 86400;
			
					$v_dates_m				= gmdate("m", $unix_date);
					$v_dates_y				= gmdate("Y", $unix_date);
					$v_dates_d				= gmdate("d", $unix_date);
					$dates_only				= ($v_dates_y+543).$v_dates_m.$v_dates_d;
					$dates					= gmdate("Y-m-d", $unix_date)."00:00:00";
			
					$v_book_auto_m			= gmdate("m", $unix_date);
					$v_book_auto_y			= gmdate("Y", $unix_date);					
										
					$book1 					= trim($objWorksheet->getCell('C' . $row)->getValue());			// เล่มที่
					$book2 					= trim($objWorksheet->getCell('D' . $row)->getValue());			// เลขที่	
					
					// dd($dates.' -> '.$v_book_auto_m.' : '.$v_book_auto_y.' = '.$rowmax.' = '.$reference_code);
			
					/* J. Physician For Get ID*/
					$physician 				= trim($objWorksheet->getCell('J' . $row)->getValue());			// คำนำหน้า + ชื่อ นายแพทย์				
					$sqlphys   				= "select id, names from nm_physician where names='$physician'";
					$rowphys_arr 			= DB::select($sqlphys);	
					$rowphys_count 			= count($rowphys_arr);	
					// dd($rowphys_count);			
					switch ($rowphys_count) {
						case 0:	break;
						case 1:
							/* มีข้อมูล 1 ให้ทำดึงข้อมูล */		
							$rowphys			= $rowphys_arr['0'];					
							$physician_id 		= $rowphys->id;
							$physician_name		= $rowphys->names;
							break;																		
						default:
							/* มีข้อมูล มากกว่า 1 ให้ทำดึงข้อมูล */	
							$rowphys			= $rowphys_arr['0'];					
							$physician_id 		= $rowphys->id;
							$physician_name		= $rowphys->names;							
					}	
			
					/* Technique All */
					$technique_all			= "";	// main1
			
					/* K. Technique1 For Get ID*/
					$technique1				= trim($objWorksheet->getCell('K' . $row)->getValue());			// ชื่อเทคนิคเชี่ยน 1					
					if(empty($technique1)){		
						// dd("ว่าง");				
						$technique1_id		= "";						
					}else{
						// dd("มี");						
						$sqltech   			= "select id, names from nm_technician where names='$technique1'";					
						$rowtech_arr 		= DB::select($sqltech);
						$rowtech_count 		= count($rowtech_arr);				
						switch ($rowtech_count) {
							case 0:								
								/* ไม่มีข้อมูลให้ทำการบันทึก */
								$sDataTechnician = new \App\Models\Backend\Masters\Technician;
								$sDataTechnician->names  = $technique1;						
								$sDataTechnician->types  = "Technician";						
								$sDataTechnician->save();
								$technique1_id 		= $sDataTechnician->id;								
								break;
							case 1:
								/* มีข้อมูล 1 ให้ทำดึงข้อมูล */
								$rowtech			= $rowtech_arr['0'];
								$technique1_id		= $rowtech->id;							
								break;																		
							default:
								/* มีข้อมูล มากกว่า 1 ให้ทำดึงข้อมูล */
								$rowtech			= $rowtech_arr['0'];
								$technique1_id		= $rowtech->id;								
						}		
						$technique_all		= $technique1_id;					
					}												
					
					/* L. Technique2 For Get ID*/
					$technique2				= trim($objWorksheet->getCell('L' . $row)->getValue());			// ชื่อเทคนิคเชี่ยน 2	
					if(empty($technique2)){		
						// dd("ว่าง");				
						$technique2_id		= "";						
					}else{
						// dd("มี");	
						$sqltech   			= "select id, names from nm_technician where names='$technique2'";	
						$rowtech_arr 		= DB::select($sqltech);
						$rowtech_count 		= count($rowtech_arr);	
						// echo $rowtech_count; exit();
						switch ($rowtech_count) {
							case 0:								
								/* ไม่มีข้อมูลให้ทำการบันทึก */
								$sDataTechnician = new \App\Models\Backend\Masters\Technician;
								$sDataTechnician->names  = $technique2;						
								$sDataTechnician->types  = "Technician";						
								$sDataTechnician->save();
								$technique2_id 		= $sDataTechnician->id;								
								break;
							case 1:
								/* มีข้อมูล 1 ให้ทำดึงข้อมูล */
								$rowtech			= $rowtech_arr['0'];
								$technique2_id		= $rowtech->id;							
								break;																		
							default:
								/* มีข้อมูล มากกว่า 1 ให้ทำดึงข้อมูล */
								$rowtech			= $rowtech_arr['0'];
								$technique2_id		= $rowtech->id;								
						}			
						$technique_all		.= ",".$technique2_id;				
					}								
					
					/* M. Technique3 For Get ID*/
					$technique3 			= trim($objWorksheet->getCell('M' . $row)->getValue());			// ชื่อเทคนิคเชี่ยน 3					
					if(empty($technique3)){		
						// dd("ว่าง");				
						$technique3_id		= "";				
					}else{
						// dd("มี");			
						$sqltech   			= "select id, names from nm_technician where names='$technique3'";					
						$rowtech_arr 		= DB::select($sqltech);			
						$rowtech_count 		= count($rowtech_arr);				
						switch ($rowtech_count) {
							case 0:								
								/* ไม่มีข้อมูลให้ทำการบันทึก */
								$sDataTechnician = new \App\Models\Backend\Masters\Technician;
								$sDataTechnician->names  = $technique3;						
								$sDataTechnician->types  = "Technician";						
								$sDataTechnician->save();
								$technique3_id 		= $sDataTechnician->id;								
								break;
							case 1:
								/* มีข้อมูล 1 ให้ทำดึงข้อมูล */
								$rowtech			= $rowtech_arr['0'];
								$technique3_id		= $rowtech->id;							
								break;																		
							default:
								/* มีข้อมูล มากกว่า 1 ให้ทำดึงข้อมูล */
								$rowtech			= $rowtech_arr['0'];
								$technique3_id		= $rowtech->id;								
						}
						$technique_all		.= ",".$technique3_id;
					}					
			
					
					/* Technique Assistant All */
					$techniqueass_all			= "";	// main2
			
					/* N. Technical Assistant1 For Get ID*/
					$technical_assistant1 			= trim($objWorksheet->getCell('N' . $row)->getValue());			// ชื่อผู้ช่วยเทคนิคเชี่ยน 1					
					if(empty($technical_assistant1)){		
						// dd("ว่าง");				
						$technical_assistant1_id	= "";				
					}else{
						// dd("มี");		
						$sqltechass   				= "select id, driver_names from nm_assistance where driver_names='$technical_assistant1'";					
						$rowtechass_arr 			= DB::select($sqltechass);				
						$rowtechass_count 			= count($rowtechass_arr);				
						switch ($rowtechass_count) {
							case 0:								
								/* ไม่มีข้อมูลให้ทำการบันทึก */
								$sDataTechnicianAssistance = new \App\Models\Backend\Masters\Assistance;
								$sDataTechnicianAssistance->driver_names  	= $technical_assistant1;						
								$sDataTechnicianAssistance->types  			= "Assistant Radiographers";						
								$sDataTechnicianAssistance->save();
								$technical_assistant1_id 		= $sDataTechnicianAssistance->id;								
								break;
							case 1:
								/* มีข้อมูล 1 ให้ทำดึงข้อมูล */		
								$rowtechass					= $rowtechass_arr['0'];						
								$technical_assistant1_id	= $rowtechass->id;							
								break;																		
							default:
								/* มีข้อมูล มากกว่า 1 ให้ทำดึงข้อมูล */
								$rowtechass					= $rowtechass_arr['0'];
								$technical_assistant1_id	= $rowtechass->id;							
						}		
						$techniqueass_all			= $technical_assistant1_id;				
					}
					
			
					/* O. Technical Assistant2 For Get ID*/
					$technical_assistant2 			= trim($objWorksheet->getCell('O' . $row)->getValue());			// ชื่อผู้ช่วยเทคนิคเชี่ยน 2					
					if(empty($technical_assistant2)){		
						// dd("ว่าง");				
						$technical_assistant2_id	= "";				
					}else{
						// dd("มี");			
						$sqltechass   				= "select id, driver_names from nm_assistance where driver_names='$technical_assistant2'";					
						$rowtechass_arr 			= DB::select($sqltechass);			
						$rowtechass_count 			= count($rowtechass_arr);				
						switch ($rowtechass_count) {
							case 0:								
								/* ไม่มีข้อมูลให้ทำการบันทึก */
								$sDataTechnicianAssistance = new \App\Models\Backend\Masters\Assistance;
								$sDataTechnicianAssistance->driver_names  	= $technical_assistant2;						
								$sDataTechnicianAssistance->types  			= "Assistant Radiographers";						
								$sDataTechnicianAssistance->save();
								$technical_assistant2_id 		= $sDataTechnicianAssistance->id;								
								break;
							case 1:
								/* มีข้อมูล 1 ให้ทำดึงข้อมูล */	
								$rowtechass					= $rowtechass_arr['0'];							
								$technical_assistant2_id	= $rowtechass->id;							
								break;																		
							default:
								/* มีข้อมูล มากกว่า 1 ให้ทำดึงข้อมูล */
								$rowtechass					= $rowtechass_arr['0'];
								$technical_assistant2_id	= $rowtechass->id;							
						}		
						$techniqueass_all			.= ','.$technical_assistant2_id;				
					}
			
					$machine 				= trim($objWorksheet->getCell('P' . $row)->getValue());			// 
			
					$claim 					= trim($objWorksheet->getCell('Q' . $row)->getValue());			// สิทธิ
					$tx_no 					= trim($objWorksheet->getCell('R' . $row)->getValue());			// ครั้งที่
					$total_bef 				= trim($objWorksheet->getCell('S' . $row)->getValue());			// ไม่ต้องเก็บ
					$vat 					= trim($objWorksheet->getCell('T' . $row)->getValue());			// ไม่ต้องเก็บ			
					$total 					= trim($objWorksheet->getCell('U' . $row)->getValue());			// แต่ละชีพเก็บไม่เหมือนกัน
										
					$sDataPatientEdit = \App\Models\Backend\Masters\Patient::find($patient_id);
			
					/* 3. A. Sheet For Make ID*/
					// เดี๋ยวแยกเก็บที่ต่าง ๆ 
					$sheetall 				= trim($objWorksheet->getCell('A' . $row)->getValue());			// หัตถการ
					switch ($sheetall) {
						case "ESWL Treatment":
							$sheetall_id 	= '2';
							$sData 									= new \App\Models\SheetEswlTransaction;			
							$sData->book_number5    				= $book2;													
							$sData->treatment_hos_id    			= $hospitals_id;						
							$sData->treatment_txno    				= $tx_no;						
							$sData->medical_expenses    			= $total;						
							$sData->medical_treating_physician		= $physician_id;						
							$sData->medical_radiographer			= $technique_all;						
							$sData->medical_assistant_radiographers	= $techniqueass_all;	
			
							$sData->treatment_date     				= $dates_only;
			
							$sqlmax 	= "
								select (MAX(CONVERT(book_auto, SIGNED))+1) as idmax from nm_sheet_eswl_transaction where book_auto_y='$v_book_auto_y' and book_auto_m='$v_book_auto_m'
							";					
							$rowmax_arr = DB::select($sqlmax);		
							$rowmax		= ($rowmax_arr['0']->idmax!='') ? str_pad($rowmax_arr['0']->idmax, 5, '0', STR_PAD_LEFT) : '00001';		
							
							$sDataPatientEdit->book_number3   = $book1;
							$sDataPatientEdit->book_number5   = $book2;							
							
							break;
						case "Endourological Treatment":
							$sheetall_id 	= '4';
							$sData 									= new \App\Models\SheetEndourologicTransaction;
							$sData->book_number4    				= $book2;
							$sData->detail_hos_id    				= $hospitals_id;							
							$sData->conclusion_equipment_charge    	= $total;
							$sData->detail_treating_physician    	= $physician_id;
							$sData->detail_radiographer    			= $technique_all;
							$sData->detail_assistant_radiographers	= $techniqueass_all;
			
							$sData->detail_date     				= $dates_only;
			
							$sqlmax 	= "
								select (MAX(CONVERT(book_auto, SIGNED))+1) as idmax from nm_sheet_endourologic_transaction where book_auto_y='$v_book_auto_y' and book_auto_m='$v_book_auto_m'
							";					
							$rowmax_arr = DB::select($sqlmax);		
							$rowmax		= ($rowmax_arr['0']->idmax!='') ? str_pad($rowmax_arr['0']->idmax, 5, '0', STR_PAD_LEFT) : '00001';
			
							$sDataPatientEdit->book_number3_endo   = $book1;
							$sDataPatientEdit->book_number4_endo   = $book2;
			
							break;
						case "Transurethral Surgical Treatment":
							$sheetall_id 	= '5';
							$sData 									= new \App\Models\SheetSurgicalTransaction;
							$sData->book_number4    				= $book2;
							$sData->detail_hos_id    				= $hospitals_id;							
							$sData->treatment_free    				= $total;
							$sData->detail_treating_physician		= $physician_id;
							$sData->detail_radiographer				= $technique_all;
							$sData->detail_assistant_radiographers	= $techniqueass_all;
							
							$sData->detail_date     				= $dates_only;
							
							$sqlmax 	= "
								select (MAX(CONVERT(book_auto, SIGNED))+1) as idmax from nm_sheet_surgical_transaction where book_auto_y='$v_book_auto_y' and book_auto_m='$v_book_auto_m'
							";					
							$rowmax_arr = DB::select($sqlmax);		
							$rowmax		= ($rowmax_arr['0']->idmax!='') ? str_pad($rowmax_arr['0']->idmax, 5, '0', STR_PAD_LEFT) : '00001';
			
							$sDataPatientEdit->book_number3_surg   = $book1;
							$sDataPatientEdit->book_number4_surg   = $book2;
			
							break;													
						default:
							$sheetall_id = '0';
					}
					$reference_code					= $v_book_auto_y.$v_book_auto_m.$rowmax;
			
					$sData->patient_id       		= $patient_id;					//
					$sData->patient_hn_no			= $hn;							//
					$sData->patient_name       		= $namefull;					//
					$sData->patient_id_number  		= $patient_id_number;	
					$sData->patient_age       		= $patient_age;					
						
					$sData->created_at       		= $dates;	
					$sData->updated_at       		= $dates;	
			
					$sData->book_auto       		= $rowmax;
					$sData->book_auto_m       		= $v_book_auto_m;	
					$sData->book_auto_y       		= $v_book_auto_y;	
					$sData->reference_code     		= $reference_code;	
					$sData->book_number3     		= $book1;			
					
					// dd($sData);		
					$sData->save();
					$sheet_id = $sData->id;		
			
					/* 3. A. Sheet For Make ID*/					
					$sheetall 				= trim($objWorksheet->getCell('A' . $row)->getValue());			// หัตถการ
					switch ($sheetall) {
						case "ESWL Treatment":
			
							// insert เทคนิก 160							
							if(empty($technique_all)){
								// echo "no";
							}else{
								// echo "yes";								
								$technique_all_arr = explode(",",$technique_all);
								foreach($technique_all_arr as $x => $val) {
									// echo "$x = $val<br>";
									$sDataSheet = new \App\Models\SheetEswlTransactionRadiographer;
									$sDataSheet->nm_sheet_eswl_transaction_id  			= $sheet_id;						
									$sDataSheet->nm_technician_id  						= $val;						
									$sDataSheet->save();
								}								
							}							
							
							break;
						case "Endourological Treatment":
							
							// insert เทคนิก 160							
							if(empty($technique_all)){
								// echo "no";
							}else{
								// echo "yes";								
								$technique_all_arr = explode(",",$technique_all);
								foreach($technique_all_arr as $x => $val) {
									// echo "$x = $val<br>";
									$sDataSheet = new \App\Models\SheetEndourologicTransactionRadiographer;
									$sDataSheet->nm_sheet_endourologic_transaction_id  	= $sheet_id;						
									$sDataSheet->nm_technician_id  						= $val;						
									$sDataSheet->save();
								}								
							}
			
							break;
						case "Transurethral Surgical Treatment":
							
							// insert เทคนิก 160							
							if(empty($technique_all)){
								// echo "no";
							}else{
								// echo "yes";								
								$technique_all_arr = explode(",",$technique_all);
								foreach($technique_all_arr as $x => $val) {
									// echo "$x = $val<br>";
									$sDataSheet = new \App\Models\SheetSurgicalTransactionRadiographer;
									$sDataSheet->nm_sheet_surgical_transaction_id  		= $sheet_id;						
									$sDataSheet->nm_technician_id  						= $val;						
									$sDataSheet->save();
								}								
							}
			
							break;													
						default:
							$technique_all = '';
					}
					
			
					$sDataPatientEdit->hn_no   = $hn;
					// dd($sDataPatientEdit);
					$sDataPatientEdit->save();
			
					echo "<tr>";	
			
						echo "<td>".$sheetall."</td>";
						echo "<td>".$sheetall_id."</td>";
						echo "<td>".$dates."</td>";
						echo "<td>".$hn."</td>";
						echo "<td>".$book1."</td>";
						echo "<td>".$book2."</td>";
						echo "<td>".$namepre."</td>";						
						echo "<td>".$namefirst."</td>";						
						echo "<td>".$namelast."</td>";						
			
					echo "</tr>";					
				}
			}

			
		}

		public function excelImportEmployee()
		{			
			return view('backend.aboutfile.excel-file-employee');
		}

		public function excelImportEmployeeUpload(Request $request)
		{	
			// dd("Test");		
			$pathExcel		= $request->file('upload')->getRealPath();
			$objPHPExcel 	= \PhpOffice\PhpSpreadsheet\IOFactory::load($pathExcel);
			$countPHPExcel	= 1;

			for ($i=0; $i<$countPHPExcel; $i++) {

				$objWorksheet 	= $objPHPExcel->setActiveSheetIndex(1);
				$highestRow 	= $objWorksheet->getHighestRow(); // e.g. 10
				$highestColumn 	= $objWorksheet->getHighestColumn(); // e.g 'F'				

				echo "<table border='1'>";			
				for ($row = 2; $row <= $highestRow; ++$row) {
					$sheetall 				= trim($objWorksheet->getCell('A' . $row)->getValue());	
					$dates 					= trim($objWorksheet->getCell('B' . $row)->getValue());	
					$book1 					= trim($objWorksheet->getCell('C' . $row)->getValue());	
					$book2 					= trim($objWorksheet->getCell('D' . $row)->getValue());	
					$hospitals 				= trim($objWorksheet->getCell('E' . $row)->getValue());	
					$hn 					= trim($objWorksheet->getCell('F' . $row)->getValue());	
					$namepre 				= trim($objWorksheet->getCell('G' . $row)->getValue());	
					$namefirst 				= trim($objWorksheet->getCell('H' . $row)->getValue());	
					$namelast 				= trim($objWorksheet->getCell('I' . $row)->getValue());	
					$physician 				= trim($objWorksheet->getCell('J' . $row)->getValue());	
					$technique1				= trim($objWorksheet->getCell('K' . $row)->getValue());	
					$technique2				= trim($objWorksheet->getCell('L' . $row)->getValue());	
					$technique3 			= trim($objWorksheet->getCell('M' . $row)->getValue());	
					$technical_assistant1 	= trim($objWorksheet->getCell('N' . $row)->getValue());	
					$technical_assistant2 	= trim($objWorksheet->getCell('O' . $row)->getValue());					
					$machine 				= trim($objWorksheet->getCell('P' . $row)->getValue());	
					$claim 					= trim($objWorksheet->getCell('Q' . $row)->getValue());		// สิทธิ
					$tx_no 					= trim($objWorksheet->getCell('R' . $row)->getValue());		// ครั้งที่
					$total_bef 				= trim($objWorksheet->getCell('S' . $row)->getValue());	
					$vat 					= trim($objWorksheet->getCell('T' . $row)->getValue());						
					$total 					= trim($objWorksheet->getCell('U' . $row)->getValue());		

					// $sData = new \App\Models\Backend\ECommerce\Orders;
					// $sData->email       		= $email;				// B
					// $sData->save();
					
					echo "<tr>";	

						echo "<td>".$sheetall."</td>";
						echo "<td>".$dates."</td>";
						echo "<td>".$book1."</td>";

						// echo "<td>";
						// if(!empty($items)){
						// 	$index = 1;
						// 	foreach($items as $k => $v){
						// 		$dummys 		= str_replace(")", "", $v);					
						// 		$dummys_array	= explode("(", $dummys);					
						// 		echo $index . ". ".$dummys_array[0].' จำนวน '.$dummys_array[1]."<br>";
						// 		$index++;
						// 	}
						// }
						// echo "</td>";

						// echo "<td>";						
						// if(!empty($items_code)){
						// 	$index = 1;
						// 	foreach($items_code as $k => $v){										
						// 		$dummys_array	= explode("(", $v);					
						// 		echo $index . ". ".$dummys_array[0]."<br>";
						// 		$index++;
						// 	}
						// }
						// echo "</td>";

					echo "</tr>";					
				}				
				echo "</table>";
				echo "<br><center>---------</center><br>";
			}
		}

		
		public function excelExport($sTable)
		{
			/* 
			// call by function orther
			$sTable = \App\Models\SheetSurgicalTransaction::search()->get();			
			if(request('excel')){
				return $this->recordSurgExport($sTable);
			}
			*/
			$pathread	= "public/excel/template/recordeswl_excel.xlsx";
			$pathwriter	= "public/excel/export/recordeswl_excel"."_".strtotime("now").".xlsx";			
			
			$reader = \PhpOffice\PhpSpreadsheet\IOFactory::load($pathread);			
			$sheet  = $reader->getActiveSheet();
			if($sRow = $sTable){
				$iRow = 4;
				foreach($sRow AS $iNum=>$r){
					$iRow++;
					// $sheet->setCellValue('A'.$iRow, ($iNum+1));
					$sheet->setCellValue('A'.$iRow, (is_null($r->reference_code)) ? "-" : $r->reference_code);
					$sheet->setCellValue('B'.$iRow, (is_null($r->treatment_date)) ? "-" : $r->treatment_date);
					$sheet->setCellValue('C'.$iRow, (is_null($r->patient_name)) ? "-" : $r->patient_name);
					$sheet->setCellValue('D'.$iRow, (is_null($r->hospital->name)) ? "-" : $r->hospital->name);
					$sheet->setCellValue('E'.$iRow, (is_null($r->physician->names)) ? "-" : $r->physician->names);
					$sheet->setCellValue('F'.$iRow, (is_null($r->treatment_txno)) ? "-" : $r->treatment_txno);
					$sheet->setCellValue('G'.$iRow, (is_null($r->medical_expenses)) ? "-" : $r->medical_expenses);					
				}
			}
			
			// $iRow++;
			// $sheet->removeRow($iRow,1990-$iRow);
			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($reader);
			
			$writer->save($pathwriter);
			return response(['status' => 'success', 'redirect' => $pathwriter ]);	
		}
		
	}
