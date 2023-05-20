<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    function register(Request $request){
        $validator = Validator::make($request->all(), [
            'nom'=>'required|max:191',
            'email'=>'required|max:191|email|unique:users,email',
            'password'=>'required|min:8',
            'abreviation'=>'required|max:3',
            'fonction'=>'required',
            'role'=>'required',
            'genre'=>'required',

        ]);
        
       
        if( $validator->fails())
        {
            return response()->json([
                'status'=>201,
                'valdator_errors'=> $validator->messages(),
            ]);

        }else{
            $user = User::create([
                'name'=>$request->nom,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'role'=>$request->role,
                'fonction'=>$request->fonction,
                'abreviation'=>$request->abreviation,
                'genre'=>$request->genre
            ]);
            
            $token = $user->createToken($user->email.'_Token')->plainTextToken;
            return response()->json([
                'status'=>200,
                'username'=>$user->name,
                'token'=>$token,
                'message'=>"L'utilisateur est ajoutée",

            ]);

        }
    }
        function login(Request $request){
            $validator = Validator::make($request->all(), [
                'email'=>'required|max:191|email',
                'password'=>'required|min:8',
            ]);
            if( $validator->fails())
            {
                return response()->json([
                    'status'=>201,
                    'valdator_errors'=> $validator->messages(),
                ]);

            }else{
                 $user = User::where('email', $request->email)->first();
 
                 if (! $user || ! Hash::check($request->password, $user->password)) {
                     return response()->json([
                         'status'=>401,
                         'message'=> 'error credentials',
                        ]);
                }else{
                    if($user->role == 1)//if it is admin
                    {
                        $token = $user->createToken($user->email.'_AdminToken',['server:admin'])->plainTextToken;

                    }else{
                        $token = $user->createToken($user->email.'_Token',[''])->plainTextToken;

                    }



                     
                     return response()->json([
                         'status'=>200,
                         'username'=> $user->name,
                         'token'=> $token,
                         'message'=>'Logged in Seccessfully'
                     ]);
                }

            }

            

        }
        function getUser(){
            $user = auth()->user();
            return response()->json([
                'status'=>200,
                'user'=>$user
            ]);
        }
        function logout(){
            auth()->user()->tokens()->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Logout is done'
            ]);

            
            
        }

    
}
