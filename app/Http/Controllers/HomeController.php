<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
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
    public function index() {
        $users = DB::table('users') -> select('id', 'username') -> get();
        return view('request.create', ['users' => $users]);
    }

    /*
    * Get sitemap
    */
    public function getSiteMap() {
        return view('layouts.sitemap');
    }
}
