<?php

namespace App\Http\Controllers\Backend\Permission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
  public function index(Request $request)
  {
    return view('backend.permission.admin.index');
  }

  public function create()
  {
    $sLocale  = \App\Models\Locale::all();
    return view('backend.permission.admin.form',['sLocale'=>$sLocale]);
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
        if( $id ){
          $sRow = \App\Models\Backend\Permission\Admin::find($id);
        }else{
          $sRow = new \App\Models\Backend\Permission\Admin;
        }
        $sRow->name     = request('name');
        $sRow->email    = request('email');
        $sRow->isActive = request('active')?request('active'):'N';

        if( request('locale_id') ){
          $sRow->locale_id    = request('locale_id');
        }else{
          $sRow->locale_id    = \Auth::user()->locale_id;
        }

        
        if( request('password') ){
          $sRow->password    = \Hash::make( request('password') );
        }

        $sRow->save();
        \DB::commit();

      return redirect()->action('Backend\Permission\AdminController@index')->with(['alert'=>\App\Models\Alert::Msg('success')]);
    } catch (\Exception $e) {
      echo $e->getMessage();
      \DB::rollback();
      return redirect()->action('Backend\Permission\AdminController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
    }
  }


  public function edit($id)
  {
    try {
      $sLocale  = \App\Models\Locale::all();
      $sRow = \App\Models\Backend\Permission\Admin::find($id);
      return View('backend.permission.admin.form')->with(array('sRow'=>$sRow, 'sLocale'=>$sLocale) );
    } catch (\Exception $e) {
      return redirect()->action('Backend\Permission\AdminController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
    }
  }


  public function destroy($id)
  {
    $sRow = \App\Models\Backend\Permission\Admin::find($id);
    if( $sRow ){
      $sRow->forceDelete();
    }
    return response()->json(\App\Models\Alert::Msg('success'));
  }

  public function Datatable(){
      $sTable = \App\Models\Backend\Permission\Admin::with(['locale:locale,name'])->search()->where('id','>','2')->orderBy('id', 'asc');
      $sQuery = \DataTables::of($sTable);
      return $sQuery
      ->make(true);
  }
}
