<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Intervention;
use Illuminate\Http\Request;

class InterController extends Controller
{
    //

    function editIntervention(Request $request, $code){
        
        
        
        $validator = Validator::make($request->all(), [
            'CODE_INTER'=>'required|max:191',
            'actions'=>'required|max:512',
            'date'=>'required|date_format:Y-m-d',
            'duree'=>'required',
            'type'=>'required',
            'user_id'=>'required|exists:users,id',
            'ref_machine'=>'required|exists:machines,ref_machine',
            'raison'=>'required|max:255',
        ]);

        if( $validator->fails())
        {
            return response()->json([
                'status'=>201,
                'valdator_errors'=> $validator->messages(),
            ]);

        }
        else{
            
            
            
            $intervention = Intervention::where('CODE_INTER',$code)->first();
                if($intervention){
                $intervention->CODE_INTER = $request->input('CODE_INTER');
                $intervention->actions = $request->input('actions');
                $intervention->raison = $request->input('raison');
                $intervention->duree = $request->input('duree');
                $intervention->date = $request->input('date');
                $intervention->user_id = $request->input('user_id');
                $intervention->ref_machine = $request->input('ref_machine');
                $intervention->type = $request->input('type');
                
                $intervention->save();
                $intervention->pieces()->sync($request->pieces);
                return "success";
                }else{
                    return "failed";
                }
                
            }
        
        

    }


    function addIntervention(Request $request){

        $validator = Validator::make($request->all(), [
            'code'=>'required|max:191',
            'actions'=>'required|max:512',
            'date'=>'required|date_format:Y-m-d',
            'duree'=>'required',
            'type'=>'required',
            'ingenieur'=>'required|exists:users,id',
            'machine'=>'required|exists:machines,ref_machine',
            'raison'=>'required|max:255',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>201,
                'valdator_errors'=> $validator->messages(),
            ]);

        }else{
            
        $intervention = new Intervention();
        
        $intervention->CODE_INTER = $request->input('code');
        $intervention->actions = $request->input('actions');
        $intervention->raison = $request->input('raison');
        $intervention->duree = $request->input('duree');
        $intervention->date = $request->input('date');
        $intervention->user_id = $request->input('ingenieur');
        $intervention->ref_machine = $request->input('machine');
        $intervention->type = $request->input('type');
        $intervention->save();
        $intervention->pieces()->attach($request->pieces);
        return response()->json([
            'status'=>200,
            'message'=> 'Success',
        ]);

        }

    }
    function index(){
        $interventions = Intervention::all();
        foreach($interventions as $intervention){
            $intervention->user;
            $intervention->machine;
            
        }
        return response()->json([
            "status"=>200,
            "interventions"=>$interventions
        ]);
        
    }


    public function deleteInter($ref){
        
        $intervention = Intervention::where('CODE_INTER',$ref)->first();
        
        if($intervention){
            $user = auth()->user();
            if($user->role == 1){
                
                $intervention->delete();
                return response()->json([
                'status'=>200,
                'message'=>'the intervention is deleted'
                ]);

            }else{
                

                if($intervention->user->name == $user->name){
                    $intervention->delete();
                    return response()->json([
                        'status'=>200,
                        'message'=>'the intervention is deleted'
                    ]);
                  
                }else{
                    return response()->json([
                        'status'=>403,
                        'message'=>'you are not the engineer who create this intervention'
                    ]);
                }
                
                
            }
            
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'the intervention is not found'
            ]);

        }

    }



    function viewInter($code){
        $intervention = Intervention::where('CODE_INTER',$code)->first();
        $intervention->user;
        $intervention->machine;
        $intervention->pieces;
        return response()->json([
            "status"=>200,
            "intervention"=>$intervention
        ]);

    }
    
}
