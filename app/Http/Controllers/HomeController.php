<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function noPermission() {
      return view("no-permission");
    }

    public function language(String $locale){
        $locale = in_array($locale,config('app.locales')) ? $locale : config('app.fallback_locale');
        session(['locale' =>  $locale]);
        return back();
    }
}
