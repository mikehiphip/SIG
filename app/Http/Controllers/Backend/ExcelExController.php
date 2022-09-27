<?php
	
	namespace App\Http\Controllers\Backend;
	
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use DB;
	// use File;
	// use Excel;
	
	class ExcelController extends Controller
	{
		
		public function excelImport()
		{			
			return view('backend.aboutfile.excelsfile');
		}

		public function excelImportUpload(Request $request)
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
