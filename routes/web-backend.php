<?php
	#=================================================================================================================================================================
	Route::group(['prefix' => 'backend','namespace' => 'Backend',  'as' => 'backend.'], function() {
		#============================================================================================================================================================
		// Authentication Routes...
		Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
		Route::post('login', 'Auth\LoginController@login')->name('login');
		Route::get('logout', 'Auth\LoginController@logout')->name('logout');
		
		#=============================================================================================================================================================
		Route::group(['middleware' => ['auth:admin']], function () {
			#========================================================================================================================================================
			Route::get('', 'HomeController@index');
			Route::get('index', 'HomeController@index');
			
			Route::get('set-power-off', 'HomeController@setPowerOff');
			Route::post('set-power-off/action', 'HomeController@setPowerOffAction')->name('set-power-off.action');
			
			#========================================================================================================================================================
			Route::group(['prefix' => 'dashboard','namespace' => 'Dashboard',  'as' => 'dashboard.'], function() {
				#==================================================================================================================================================
				// Route::post('recordeswl', 'DashboardController@recordEswlDatatable')->name('recordeswl.datatable');	
				// Route::post('recordendo', 'DashboardController@recordEndoDatatable')->name('recordendo.datatable');			
				// Route::post('recordsurg', 'DashboardController@recordSurgDatatable')->name('recordsurg.datatable');					
				#===================================================================================================================================================
			}); //route group masters

			#========================================================================================================================================================
			Route::group(['prefix' => 'masters','namespace' => 'Masters',  'as' => 'masters.'], function() {
				#==================================================================================================================================================
				Route::resource('employee', 'EmployeeController');
				Route::post('employee/datatable', 'EmployeeController@Datatable')->name('employee.datatable');

				Route::resource('department', 'DepartmentController');
				Route::post('department/datatable', 'DepartmentController@Datatable')->name('department.datatable');

				Route::get('/station/{id}', 'StationController@index')->where(['id' => '[0-9]+']);
				Route::get('/station/{id}/create', 'StationController@create')->where(['id' => '[0-9]+']);
				Route::post('/station/{id}/create', 'StationController@store')->where(['id' => '[0-9]+']);

				Route::get('/station/{id}/{sub_id}/edit', 'StationController@edit')->where(['id' => '[0-9]+'])->where(['sub_id' => '[0-9]+']);
				Route::post('/station/{id}/{sub_id}/edit', 'StationController@update')->where(['id' => '[0-9]+'])->where(['sub_id' => '[0-9]+']);
				Route::post('/station/datatable/{id}', 'StationController@Datatable')->where(['id' => '[0-9]+']);
				Route::delete('/station/destroy/{id}', 'StationController@destroy')->where(['id' => '[0-9]+']);
				
				Route::resource('position', 'PositionController');
				Route::post('position/datatable', 'PositionController@Datatable')->name('position.datatable');

				Route::resource('video', 'VideoController');
				Route::get('/video/get-station/search', 'VideoController@get_station');
				
				Route::post('video/datatable', 'VideoController@Datatable')->name('video.datatable');
				
				Route::resource('receive-email', 'ReceiveEmailController');
				Route::post('receive-email/datatable', 'ReceiveEmailController@Datatable')->name('receive-email.datatable');
				#===================================================================================================================================================
			}); //route group masters
			
			#=========================================================================================================================================================
			Route::group(['prefix' => 'sheet','namespace' => 'Sheet',  'as' => 'sheet.'], function() {
				#====================================================================================================================================================				     
				Route::resource('eswl-price', 'EswlPriceController');					
				Route::post('eswl-price/datatable', 'EswlPriceController@Datatable')->name('eswl-price.datatable'); 
				
				Route::resource('eswl-patient', 'EswlPatientController');					
				Route::post('eswl-patient/datatable', 'EswlPatientController@Datatable')->name('eswl-patient.datatable');  				
				Route::post('eswl-patient/callexpenses', 'EswlPatientController@callExpenses');
				Route::post('eswl-patient/callpatient', 'EswlPatientController@callPatient');
				Route::post('eswl-patient/calltxnogetcount', 'EswlPatientController@callTxnoGetCount');
				
				Route::resource('endourologic-patient', 'EndourologicPatientController');					
				Route::post('endourologic-patient/datatable', 'EndourologicPatientController@Datatable')->name('endourologic-patient.datatable');
				Route::post('endourologic-patient/callpatient', 'EndourologicPatientController@callPatient');
				
				Route::resource('surgical-patient', 'SurgicalPatientController');					
				Route::post('surgical-patient/datatable', 'SurgicalPatientController@Datatable')->name('surgical-patient.datatable');
				Route::post('surgical-patient/callpatient', 'SurgicalPatientController@callPatient');
				
				#====================================================================================================================================================
			}); //route group sheet
			
			#=========================================================================================================================================================
			// Route::group(['prefix' => 'promotion','namespace' => 'Promotion',  'as' => 'promotion.'], function() {
			// 	#====================================================================================================================================================
			// 	Route::resource('web', 'WebDiscountController');
			// 	Route::post('web/datatable', 'WebDiscountController@Datatable')->name('web.datatable');     
			// 	#====================================================================================================================================================
			// }); //route group permission

			#=========================================================================================================================================================			
			Route::group(['prefix' => 'permission','namespace' => 'Permission',  'as' => 'permission.'], function() {
				#=====================================================================================================================================================
				Route::resource('admin', 'AdminController');
				Route::post('admin/datatable', 'AdminController@Datatable')->name('datatable');				
				#=====================================================================================================================================================
			}); //route group permission

			#=========================================================================================================================================================			
			Route::group(['prefix' => 'report', 'as' => 'report.'], function() {				 
				#====================================================================================================================================================
				Route::get('employee', 'ReportController@employee')->name('employee');
				Route::post('employee/datatable', 'ReportController@employeeDatatable')->name('employee.datatable');  

				Route::get('train', 'ReportController@train')->name('train');
				Route::post('train-del', 'ReportController@trainDel')->name('train.del');
				Route::post('train/datatable', 'ReportController@trainDatatable')->name('train.datatable');
				Route::post('train/sendmail', 'ReportController@trainSendmail')->name('train.sendmail');
				Route::get('train/excel', 'ReportController@trainExcel')->name('train.excel');

				
				#====================================================================================================================================================
			}); //route group report
			
			#=========================================================================================================================================================			
			Route::group(['prefix' => 'aboutfile', 'as' => 'aboutfile.'], function() {
				 
				#====================================================================================================================================================
				Route::get('excel-import', 'ExcelController@excelImport');				
				Route::post('excel-import-upload', 'ExcelController@excelImportUpload');				
				#====================================================================================================================================================
			}); //route group report

			#==========================================================================================================================================================
			
			// dd(Route::getRoutes());
			Route::get('template/{any?}', 'TemplateController@index')->name('template');
			#==========================================================================================================================================================
		}); //route group auth:admin
		#================================================================================================================================================================
	}); //route group backend
