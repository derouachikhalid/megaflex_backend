<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function index(){
        $users = User::all();
        if($users){
            return response()->json([
                'status'=> 200,
                'users'=> $users
            ]);
        }

    }
    public function getEngineerNumber(){
        $appIng = User::where('fonction','ingénieur biomédical')->get();
        $bioIng = User::where('fonction',"ingénieur d'application")->get();
        if($appIng && $bioIng ){
            return response()->json([
                'status'=>200,
                'bioIng'=>$bioIng,
                'appIng'=> $appIng
            ]);

        }

    }
    function getEngineer(){
        $users = User::where('role',0)->get();
        if($users){
            return response()->json([
                'status'=> 200,
                'users'=> $users
            ]);
        }

    }
}
