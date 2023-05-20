<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\Machine;
use App\Models\Intervention;
use Illuminate\Http\Request;

class MachineController extends Controller
{


    function selectMachine($ref){
        
        
        $machine = Machine::where('ref_machine',$ref)->first();
        if($machine){
            return response()->json([
                'status'=>200,
                'machine'=>$machine
            ]);
        }else{
            return response()->json([
            'status'=>404,
            'fournisseur'=>'page not founded'
            ]);
        }
    }
    
    public function getMachineInfo($ref){
        $machine = Machine::where('ref_machine',$ref)->first();
        $interventions = Intervention::where('ref_machine',$ref)->get();
        foreach ($interventions as $intervention) {
            $intervention->user;
            $intervention->pieces;
        }
        
        if($interventions && $machine ){
            $machine->client;
            $machine->fournissor;
            return response()->json([
                'status'=> 200,
                'machine' => $machine,
                'intervetions' => $interventions,


            ]);
        }

    }
    public function getMachineNumber(){
        $upMachines = Machine::where('status',1)->get();
        $downMachines = Machine::where('status',0)->get();
        if($downMachines && $upMachines ){
            return response()->json([
                'status'=>200,
                'downMachines'=> $downMachines,
                'upMachines'=> $upMachines
            ]);

        }

    }

    
    public function deleteMachine($ref){
        
        $machine = Machine::where('ref_machine',$ref)->first();
        
        if($machine){
            $machine->delete();
            return response()->json([
                'status'=>200,
                'message'=>'la machine is supprimée'
            ]);

        }else{
            return response()->json([
                'status'=>404,
                'message'=>"la machine n'est pas trouvée"
            ]);

        }

    }
    public function changeStatus($ref){
        
        $machine = Machine::where('ref_machine',$ref)->first();
        
        if($machine){
            
            if ($machine->status == 0) {
                $machine->status=1;
            }elseif ($machine->status == 1) {
                $machine->status=0;
            }
            $machine->save();
            return response()->json([
                'status'=>200,
                'message'=> $machine->status
            ]);

        }else{
            return response()->json([
                'status'=>404,
                'message'=>"l'état n'est pas modifié"
            ]);

        }

    }
    


    function editMachine(Request $request,$ref){
        $validator = Validator::make($request->all(), [
            'ref'=>'required|max:191',
            'name'=>'required|max:40',
            'discipline'=>'required|max:255',
            'description'=>'required|max:255',
            'raison'=>'required|max:128',
            'fonction'=>'required|max:256',
            'date_e'=>'required|date_format:Y-m-d',
            'client_id'=>'required|exists:clients,id',
            'founisseur_id'=>'required|exists:founissors,id',
            
            'accessoires'=>'required|max:256'
        ]);
        if( $validator->fails())
        {
            return response()->json([
                'status'=>201,
                'valdator_errors'=> $validator->messages(),
            ]);

        }else{
            $machine = Machine::where('ref_machine',$ref)->first();
            if($machine){
                $machine->ref_machine = $request->input('ref');
                $machine->name_machine = $request->input('name');
                $machine->discipline_machine = $request->input('discipline');
                $machine->fonction_machine = $request->input('fonction');
                $machine->raison = $request->input('raison');
                $machine->description = $request->input('description');
                $machine->date_entree = $request->input('date_e');
                $machine->client_id = $request->input('client_id');
                $machine->fournissur_id = $request->input('founisseur_id');
                $machine->accessoires_machine = $request->input('accessoires');
                if($request->hasFile('image')){
                    $file =$request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extension;
                    $file->move('uploads/machines/',$filename);
                    $machine->image_machine = 'uploads/machines/'.$filename;
                }
                $machine->save();
                return response()->json([
                    "status"=> 200,
                    "message"=>"la machine est modifiée"
                ]);
            }else{

            }

        }

    }
    function index(){
        $machine = Machine::all();
        return response()->json([
            "status"=>200,
            "machines"=>$machine
        ]);
    }
    function addMachine(Request $request){

    
        
        $validator = Validator::make($request->all(), [
            'ref'=>'required|max:191|unique:machines,ref_machine',
            'name'=>'required|max:40',
            'discipline'=>'required|max:255',
            'description'=>'required|max:255',
            'raison'=>'required|max:128',
            'date_e'=>'required|date_format:Y-m-d',
            'client_id'=>'required|exists:clients,id',
            'founisseur_id'=>'required|exists:founissors,id',
            'image'=>'image|mimes:jpeg,jpg,png,webp|max:2048',
            'accessoires'=>'required|max:256'
        ]);
        if( $validator->fails())
        {
            return response()->json([
                'status'=>201,
                'valdator_errors'=> $validator->messages(),
            ]);

        }else{

            $machine = new Machine();
            $machine->ref_machine = $request->input('ref');
            $machine->name_machine = $request->input('name');
            $machine->discipline_machine = $request->input('discipline');
            if($request->input('fonction')){
                $machine->fonction_machine = $request->input('fonction');
            }
            else{
                $machine->fonction_machine = "";
            }
            $machine->raison = $request->input('raison');
            $machine->description = $request->input('description');
            $machine->date_entree = $request->input('date_e');
            $machine->client_id = $request->input('client_id');
            $machine->fournissur_id = $request->input('founisseur_id');
            $machine->accessoires_machine = $request->input('accessoires');
            if($request->hasFile('image')){
                $file =$request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'.'.$extension;
                $file->move('uploads/machines/',$filename);
                $machine->image_machine = 'uploads/machines/'.$filename;
            }
            
            $machine->save();
            return response()->json([
                "status"=> 200,
                "message"=>"machine added successfully"
            ]);
        }

    }
}
