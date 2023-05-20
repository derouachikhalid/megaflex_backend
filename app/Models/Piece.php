<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Intervention;

class Piece extends Model
{
    
    use HasFactory;
    protected $table = 'pieces';
    protected $primaryKey='SN';
    public $incrementing= false;
    protected $keyType='string';
    
    protected $fillable =[
        'SN',
        'designation',
        'description',
        'ref_machine',
    ];
    public function interventions(){
        return $this ->belongsToMany(Intervention::class,'inter_piece','SN','CODE_INTER','SN','CODE_INTER');
    }
    public function machine()
    {
        return $this->hasOne(Machine::class, 'ref_machine', 'ref_machine');
    }

}
