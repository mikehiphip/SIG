<?php

namespace App\Http\Controllers\Backend\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class DashboardController extends Controller
{
    public function recordEswlDatatable(){			
		$sTable = \App\Models\SheetEswlTransaction::search()->orderBy('id', 'desc');
		$sQuery = \DataTables::of($sTable);
		return $sQuery
		->addIndexColumn()	
		->addColumn('hospital_name', function($row) {
			return is_null($row->hospital->name) ? '-' : $row->hospital->name;
		})
		->addColumn('physician_name', function($row) {
			return is_null($row->physician->names) ? '-' : $row->physician->names;
		})			
		->addColumn('medical_expenses', function($row) {
			$total = is_null($row->medical_expenses) ? '-' : $row->medical_expenses;
			return ($total == 0.00) ? '-' : number_format($total ,2);
		})
		->addColumn('medical_expenses_vat_bef', function($row) {				
			$total = is_null($row->medical_expenses) ? '-' : ($row->medical_expenses*100)/107;
			return ($total == 0.00) ? '-' : number_format($total ,2);
		})
		->addColumn('medical_expenses_vat', function($row) { 
			$total = is_null($row->medical_expenses) ? '-' : $row->medical_expenses-(($row->medical_expenses*100)/107);
			return ($total == 0.00) ? '-' : number_format($total ,2);
		})
		->addColumn('treatment_date', function($row) {
			return is_null($row->treatment_date) ? '-' : date_format(date_create($row->treatment_date), 'd-m-Y');
		})
		->escapeColumns('treatment_date')
		->make(true);
	}

	public function recordEndoDatatable(){			
		$sTable = \App\Models\SheetEndourologicTransaction::search()->orderBy('id', 'desc');			
		if(request('excel')){
			return $this->recordEndoExport($sTable);
		}
		$sQuery = \DataTables::of($sTable);
		return $sQuery
		->addIndexColumn()	
		->addColumn('hospital_name', function($row) {
			return is_null($row->hospital->name) ? '-' : $row->hospital->name;
		})
		->addColumn('physician_name', function($row) {
			return is_null($row->physician->names) ? '-' : $row->physician->names;
		})
		->addColumn('conclusion_equipment_charge', function($row) {
			$total = is_null($row->conclusion_equipment_charge) ? '-' : $row->conclusion_equipment_charge;
			return ($total == 0.00) ? '-' : number_format($total ,2); 
		})
		->addColumn('conclusion_equipment_charge_vat_bef', function($row) {				
			$total = is_null($row->conclusion_equipment_charge) ? '-' : ($row->conclusion_equipment_charge*100)/107;
			return ($total == 0.00) ? '-' : number_format($total ,2);
		})
		->addColumn('conclusion_equipment_charge_vat', function($row) {				
			$total = is_null($row->conclusion_equipment_charge) ? '-' : $row->conclusion_equipment_charge-(($row->conclusion_equipment_charge*100)/107);
			return ($total == 0.00) ? '-' : number_format($total ,2);
		})
		->addColumn('detail_date', function($row) {
			return is_null($row->detail_date) ? '-' : date_format(date_create($row->detail_date), 'd-m-Y');
		})
		->escapeColumns('detail_date')
		->make(true);
	}

	public function recordSurgDatatable(){
		$sTable = \App\Models\SheetSurgicalTransaction::search()->orderBy('id', 'desc');	
		$sQuery = \DataTables::of($sTable);
		return $sQuery
		->addIndexColumn()	
		->addColumn('hospital_name', function($row) {
			return is_null($row->hospital->name) ? '-' : $row->hospital->name;
		})
		->addColumn('physician_name', function($row) {
			return is_null($row->physician->names) ? '-' : $row->physician->names;
		})
		->addColumn('treatment_free', function($row) {
			$total = is_null($row->treatment_free) ? '-' : $row->treatment_free;
			return ($total == 0.00) ? '-' : number_format($total ,2);
		})
		->addColumn('treatment_free_vat_bef', function($row) {				
			$total = is_null($row->treatment_free) ? '-' : ($row->treatment_free*100)/107;
			return ($total == 0.00) ? '-' : number_format($total ,2);
		})
		->addColumn('treatment_free_vat', function($row) {				
			$total = is_null($row->treatment_free) ? '-' : $row->treatment_free-(($row->treatment_free*100)/107);
			return ($total == 0.00) ? '-' : number_format($total ,2);
		})
		->addColumn('detail_date', function($row) {
			return is_null($row->detail_date) ? '-' : date_format(date_create($row->detail_date), 'd-m-Y');
		})
		->escapeColumns('detail_date')
		->make(true);
	}	

	public function hospitalEswlDatatable(){
		$sTable = \App\Models\SheetEswlTransaction::search()		
			->select(
				'nm_sheet_eswl_transaction.*', 
				DB::raw('count(treatment_hos_id) as hos_count')
			)	
			->with('hospital')	
			->groupBy('treatment_hos_id')
			->orderBy('hos_count', 'desc');

		// dd($sTable->all());
		
		$sQuery = \DataTables::of($sTable);
		return $sQuery
		->addIndexColumn()			
		->editColumn('name', function($row) {
			return $row->hospital->name;
		})		
		// ->escapeColumns('customer')
		->make(true);
	}

	public function hospitalEndoDatatable(){
		$sTable = \App\Models\SheetEndourologicTransaction::search()		
			->select(
				'nm_sheet_endourologic_transaction.*', 
				DB::raw('count(detail_hos_id) as hos_count')
			)	
			->with('hospital')	
			->groupBy('detail_hos_id')
			->orderBy('hos_count', 'desc');

		// dd($sTable->all());
		
		$sQuery = \DataTables::of($sTable);
		return $sQuery
		->addIndexColumn()			
		->editColumn('name', function($row) {
			return $row->hospital->name;
		})		
		// ->escapeColumns('customer')
		->make(true);
	}

	public function hospitalSurgDatatable(){
		$sTable = \App\Models\SheetSurgicalTransaction::search()		
			->select(
				'nm_sheet_surgical_transaction.*', 
				DB::raw('count(detail_hos_id) as hos_count')
			)	
			->with('hospital')	
			->groupBy('detail_hos_id')
			->orderBy('hos_count', 'desc');

		// dd($sTable->all());
		
		$sQuery = \DataTables::of($sTable);
		return $sQuery
		->addIndexColumn()			
		->editColumn('name', function($row) {
			return $row->hospital->name;
		})		
		// ->escapeColumns('customer')
		->make(true);
	}

	public function physicianEswlDatatable(){
		$sTable = \App\Models\SheetEswlTransaction::search()		
			->select(
				'nm_sheet_eswl_transaction.*', 
				DB::raw('count(medical_treating_physician) as physician_count')
			)	
			->with('physician')	
			->groupBy('medical_treating_physician')
			->orderBy('physician_count', 'desc');

		// dd($sTable->all());
		
		$sQuery = \DataTables::of($sTable);
		return $sQuery
		->addIndexColumn()			
		->editColumn('name', function($row) {
			return $row->physician->names;
		})		
		// ->escapeColumns('customer')
		->make(true);
	}

	public function physicianEndoDatatable(){
		$sTable = \App\Models\SheetEndourologicTransaction::search()		
			->select(
				'nm_sheet_endourologic_transaction.*', 
				DB::raw('count(detail_treating_physician) as physician_count')
			)	
			->with('physician')	
			->groupBy('detail_treating_physician')
			->orderBy('physician_count', 'desc');

		// dd($sTable->all());
		
		$sQuery = \DataTables::of($sTable);
		return $sQuery
		->addIndexColumn()			
		->editColumn('name', function($row) {
			return $row->physician->names;
		})		
		// ->escapeColumns('customer')
		->make(true);
	}

	public function physicianSurgDatatable(){
		$sTable = \App\Models\SheetSurgicalTransaction::search()		
			->select(
				'nm_sheet_surgical_transaction.*', 
				DB::raw('count(detail_treating_physician) as physician_count')
			)	
			->with('physician')	
			->groupBy('detail_treating_physician')
			->orderBy('physician_count', 'desc');

		// dd($sTable->all());
		
		$sQuery = \DataTables::of($sTable);
		return $sQuery
		->addIndexColumn()			
		->editColumn('name', function($row) {
			return $row->physician->names;
		})		
		// ->escapeColumns('customer')
		->make(true);
	}

	public function radiographerEswlDatatable(){
		$sTable = \App\Models\SheetEswlTransactionRadiographer::search()		
			->select(
				'nm_sheet_eswl_transaction_radiographer.*', 
				DB::raw('count(nm_technician_id) as total_count')
			)	
			// ->with('sheetEswlTransaction')	
			// ->with('technician')	
			->groupBy('nm_technician_id')
			->orderBy('total_count', 'desc');

		// dd($sTable->all());
		
		$sQuery = \DataTables::of($sTable);
		return $sQuery
		->addIndexColumn()			
		->editColumn('name', function($row) {
			return $row->technician->names;
		})		
		// ->escapeColumns('customer')
		->make(true);
	}

	public function radiographerEndoDatatable(){
		$sTable = \App\Models\SheetEndourologicTransactionRadiographer::search()		
			->select(
				'nm_sheet_endourologic_transaction_radiographer.*', 
				DB::raw('count(nm_technician_id) as total_count')
			)	
			->with('technician')	
			->groupBy('nm_technician_id')
			->orderBy('total_count', 'desc');

		// dd($sTable->all());
		
		$sQuery = \DataTables::of($sTable);
		return $sQuery
		->addIndexColumn()			
		->editColumn('name', function($row) {
			return $row->technician->names;
		})		
		// ->escapeColumns('customer')
		->make(true);
	}
	 
	public function radiographerSurgDatatable(){
		$sTable = \App\Models\SheetSurgicalTransactionRadiographer::search()		
			->select(
				'nm_sheet_surgical_transaction_radiographer.*', 
				DB::raw('count(nm_technician_id) as total_count')
			)	
			->with('technician')	
			->groupBy('nm_technician_id')
			->orderBy('total_count', 'desc');

		// dd($sTable->all());
		
		$sQuery = \DataTables::of($sTable);
		return $sQuery
		->addIndexColumn()			
		->editColumn('name', function($row) {
			return $row->technician->names;
		})		
		// ->escapeColumns('customer')
		->make(true);
	}
}
