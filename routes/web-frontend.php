<?php

#=======================================================================================================================================================
// Route::group(['prefix' => '{locale}', 'where' => ['locale' => '[a-zA-Z-]{2,5}'], 'middleware' => 'setlocale', 'namespace' => 'Frontend'], function() {
Route::group(['namespace' => 'Frontend',  'as' => 'frontend.'], function() {
#=======================================================================================================================================================

  // Authentication Routes...
  // Route::get('signin', 'Auth\LoginController@showLoginForm')->name('login');
  // Route::post('signin', 'Auth\LoginController@login')->name('login');
  // Route::get('logout', 'Auth\LoginController@logout')->name('logout');

  #=======================================================================================================================================================
  
  # Homepage
  Route::get('', 'HomepageController@index'); 
  Route::get('index', 'HomepageController@index');
  
  /*Noti E-Mail*/
  Route::get('noti-email', 'NotiController@notiEmail');
  Route::post('train/sendmail', 'NotiController@trainSendmail')->name('train.sendmail');
  
  /* 1. กรุณากรอกเลขรหัสพนักงาน */
  Route::get('assignId', 'AssignIdController@index');                                                   // หน้าหลัก กรุณากรอกเลขรหัสพนักงาน
  Route::post('assignIdCall', 'AssignIdController@assignIdCall')->name('assignidcall');                 // ตรวจสอบ เลขรหัสพนักงาน
  Route::post('assignIdAction', 'AssignIdController@assignIdAction')->name('assignidaction');           // บันทึก เลขรหัสพนักงาน และไปสู่การถ่ายรูป
  
  /* 2. ถ่ายรูปผู้เข้าร่วมอบรม */
  Route::get('takePhoto/{id?}', 'TakePhotoController@index')->name('takephoto');  
  Route::post('takePhotoAction', 'TakePhotoController@takePhotoAction')->name('takephotoaction');
  Route::get('takePhotoDraft/{id?}', 'TakePhotoController@indexDraft')->name('takephotodraft');
  Route::post('takePhotoDraftAction', 'TakePhotoController@takePhotoDraftAction')->name('takephotodraftaction');

  // == Route new Menu
  Route::get('listTraining/{id?}', 'ListTrainingController@index_new')->name('listtraining');
  Route::get('list-department/{id?}', 'ListTrainingController@index_new')->name('list-department');
  Route::get('list-station/{id?}/{train_id?}', 'ListTrainingController@station')->name('list-station');
  Route::get('list-training/{id?}', 'ListTrainingController@training')->name('list-training');

  //===
  
  // Route::get('listTraining/{id?}', 'ListTrainingController@index')->name('listtraining');
  Route::post('listTraining-submit/{id}', 'ListTrainingController@submit_train');

  Route::get('videoTraining/{v_id?}', 'VideoTrainingController@index')->name('videotraining');
  
  Route::get('thankyou/{v_id?}', 'ThankyouController@index')->name('thankyou');

  #=====================================================================================================================================================
  Route::group(['middleware' => ['auth:user']], function () {
  #=====================================================================================================================================================

    #=======================================================================================================================================================
    Route::group(['prefix' => 'member','namespace' => 'Member',  'as' => 'member.'], function() {
    #=======================================================================================================================================================
      Route::get('', 'MyprofilesController@index')->name('index');
      
    #=======================================================================================================================================================
    }); //route group member
  #=====================================================================================================================================================
  }); //route group auth:user
#=======================================================================================================================================================
}); //route group setlocale



