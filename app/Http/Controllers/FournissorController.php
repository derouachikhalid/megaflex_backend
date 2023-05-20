<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Fournissor;

use Illuminate\Http\Request;

class FournissorController extends Controller
{
    function index(){
        $fournissor = Fournissor::all();
        return response()->json([
            "status"=>200,
            "fournisseurs"=>$fournissor
        ]);
    }

    function editFournissor($id){
        $fournisseur = Fournissor::find($id);
        if($fournisseur){
            return response()->json([
                'status'=>200,
                'fournisseur'=>$fournisseur
            ]);
        }else{
            return response()->json([
            'status'=>404,
            'fournisseur'=>'page not founded'
            ]);
        }

    }
    public function deleteFournissor($id){
        $founissor = Fournissor::find($id);
        if($founissor){
            $founissor->delete();
            return response()->json([
                'status'=>200,
                'message'=>'the fournissor is deleted'
            ]);

        }else{
            return response()->json([
                'status'=>404,
                'message'=>'the fournissor is not found'
            ]);

        }

    }
    function editAFournissor(Request $request, $id){
        
        
        $validator = Validator::make($request->all(), [
            'email'=>'required|max:191|email',
            'name'=>'required|max:40',
            'telephone'=>'required|numeric|min:10',
            'adresse'=>'required|max:256',
            'description'=>'max:512',
            //'image'=>'image|mimes:jpeg,jpg,png|max:2048',
        ]);
        if( $validator->fails())
        {
            return response()->json([
                'status'=>201,
                'valdator_errors'=> $validator->messages(),
            ]);

        }else{
            $founissor = Fournissor::find($id);
            if($founissor){
                $founissor->name_founissor = $request->input('name');
                $founissor->email_founissor = $request->input('email');
                $founissor->telephone_founissor = $request->input('telephone');
                $founissor->adresse_founissor = $request->input('adresse');
                $founissor->description_founissor = $request->input('description');
                 /*if($request->hasFile('image')){
                     $file =$request->file('image');
                     $extension = $file->getClientOriginalExtension();
                     $filename = time().'.'.$extension;
                     $file->move('uploads/fournissors/',$filename);
                     $founissor->logo_founissor = 'uploads/fournissors/'.$filename;
                 }*/
                $founissor->save();
                return response()->json([
                    "status"=> 200,
                    "message"=>"Le fournisseur est enregistré"
                ]);
            }else{
                return response()->json([
                    "status"=> 203,
                    "message"=>"Auccun fournisseur trouvé"
                ]);
            }
        }
        
        

    }
    function addFournissor(Request $request){
        
        $validator = Validator::make($request->all(), [
            'email'=>'required|max:191|email',
            'name'=>'required|max:40',
            'telephone'=>'required|numeric|min:10',
            'adresse'=>'required|max:256',
            'description'=>'max:512',
            'image'=>'image|mimes:jpeg,jpg,png|max:2048',
        ]);
        if( $validator->fails())
        {
            return response()->json([
                'status'=>201,
                'valdator_errors'=> $validator->messages(),
            ]);

        }else{
        $founissor = new Fournissor();
        $founissor->name_founissor = $request->input('name');
        $founissor->email_founissor = $request->input('email');
        $founissor->telephone_founissor = $request->input('telephone');
        $founissor->adresse_founissor = $request->input('adresse');
        $founissor->description_founissor = $request->input('description');
        if($request->hasFile('image')){
            $file =$request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('uploads/fournissors/',$filename);
            $founissor->logo_founissor = 'uploads/fournissors/'.$filename;
        }
        $founissor->save();
        return response()->json([
            "status"=> 200,
            "message"=>"Le fournisseur est enregistré"
        ]);
    }

    

    }
}
