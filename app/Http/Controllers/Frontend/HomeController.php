<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontendController;

class HomeController extends FrontendController
{

    public function index(Request $request)
    {
      echo 'Land : ' . \Config::get('land');
      echo '<br/>';
      echo 'Locale : ' . \Config::get('locale');
      dd(\Auth::user());
    }
}
