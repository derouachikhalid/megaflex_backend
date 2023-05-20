<?php

namespace App\Http\Controllers;
use App\Models\Intervention;
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getInterventionPieces()
    {
        $intervention =Intervention::where('CODE_INTER','MC4521')->first();
        return $intervention;
    }
    public function index()
    {
        return view('home');
    }
}
