<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Piece;
use App\Models\Intervention;
use Illuminate\Http\Request;

class PieceController extends Controller
{
    //
    function selectPiece($sn){
        $piece = Piece::where('SN',$sn)->first();
        if($piece){
            return response()->json([
                'status'=>200,
                'piece'=>$piece
            ]);
        }else{
            return "there is no piece";
        }

    }


    public function deletePiece($SN){
        $piece = Piece::where('SN',$SN)->first();
        if($piece){
            $piece->delete();
            return response()->json([
                'status'=>200,
                'message'=>'the $piece is deleted'
            ]);

        }else{
            return response()->json([
                'status'=>404,
                'message'=>'the $piece is not found'
            ]);

        }

    }
    
    function editPiece(Request $request,$sn){
        $validator = Validator::make($request->all(), [
            'SN'=>'required|max:30|unique:pieces,SN',
            'designation'=>'required|max:40',
            'description'=>'required|max:255',
            'ref_machine'=>'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>200,
                'valdator_errors'=> $validator->messages(),
            ]);

        }else{
            $piece = Piece::where('SN',$sn)->first();
            $piece->SN = $request->input('SN');
            $piece->designation = $request->input('designation');
            $piece->description = $request->input('description');
            $piece->ref_machine = $request->input('ref_machine');
            $piece->save();
            return response()->json([
                'status'=>200,
                'message'=>'update successfuly'
            ]);
        }

    }
    function index(){
        $pieces = Piece::all();
        foreach ($pieces as $piece) {
            $piece->machine;
        }
        if($pieces){
            return response()->json([
                'status'=>200,
                'pieces'=>$pieces
            ]);
        }else{
            return "given ppp";
        }
    }
    function addPiece(Request $request){
        $validator = Validator::make($request->all(), [
            'SN'=>'required|max:30|unique:pieces,SN',
            'designation'=>'required|max:40',
            'description'=>'required|max:255',
            'ref_machine'=>'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>200,
                'valdator_errors'=> $validator->messages(),
            ]);

        }else{
            $piece = new Piece();
            $piece->SN = $request->input('SN');
            $piece->designation = $request->input('designation');
            $piece->description = $request->input('description');
            $piece->ref_machine = $request->input('ref_machine');
            $piece->save();
            return response()->json([
                'status'=>200,
                'message' => "the piece is added successfuly"
            ]);

        }
    }
}
