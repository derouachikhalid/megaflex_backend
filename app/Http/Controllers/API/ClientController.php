<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //
    function index(){
        $clients = Client::all();
        return response()->json([
            "status"=>200,
            "clients"=>$clients
        ]);
    }
    function selectClient($id){
        $client = Client::find($id);
        if($client){
            return response()->json([
                'status'=>200,
                'client'=>$client
            ]);
        }else{
            return "there is no client";
        }

    }
    public function deleteClient($id){
        $client = Client::Find($id);
        if($client){
            $client->delete();
            return response()->json([
                'status'=>200,
                'message'=>'the client is deleted'
            ]);

        }else{
            return response()->json([
                'status'=>404,
                'message'=>'the client is not found'
            ]);

        }

    }
    function editClient(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'email'=>'required|max:191|email',
            'name'=>'required|max:40',
            'telephone'=>'required|numeric|min:10',
            'ville'=>'required|max:256',
            'description'=>'max:512',
            
        ]);
        if( $validator->fails())
        {
            return response()->json([
                'status'=>201,
                'valdator_errors'=> $validator->messages(),
            ]);

        }else{
    }
    $client = Client::find($id);
        $client->name_client = $request->input('name');
        $client->email_client = $request->input('email');
        $client->telephone_client = $request->input('telephone');
        $client->ville_client = $request->input('ville');
        $client->description_client = $request->input('description');
        if($request->hasFile('image')){
            $file =$request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('uploads/clients/',$filename);
            $client->logo_client = 'uploads/clients/'.$filename;
        }
        $client->save();
        return response()->json([
            "status"=> 200,
            "message"=>"fournissor updated successfully"
        ]);
    }
    function addClient(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=>'required|max:191|email',
            'name'=>'required|max:40',
            'telephone'=>'required|numeric|min:10',
            'ville'=>'required|max:256',
            'description'=>'max:512',
            
        ]);
        if( $validator->fails())
        {
            return response()->json([
                'status'=>201,
                'valdator_errors'=> $validator->messages(),
            ]);

        }else{
        $client = new Client();
        $client->name_client = $request->input('name');
        $client->email_client = $request->input('email');
        $client->telephone_client = $request->input('telephone');
        $client->ville_client = $request->input('ville');
        $client->description_client = $request->input('description');
        if($request->hasFile('image')){
            $file =$request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('uploads/clients/',$filename);
            $client->logo_client = 'uploads/clients/'.$filename;
        }
        $client->save();
        return response()->json([
            "status"=> 200,
            "message"=>"le client est enregistré"
        ]);
    }
    }
}
