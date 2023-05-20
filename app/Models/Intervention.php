<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;
use App\Models\Piece;
use App\Models\Machine;
use App\Models\User;

class Intervention extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'interventions';
    protected $primaryKey='CODE_INTER';
    public $incrementing= false;
    protected $keyType='string';
    
    protected $fillable =[
        'CODE_INTER',
        'actions',
        'raison',
        'duree',
        'date',
        'user_id',
        'ref_machine',
        'type',
        'conclusion'
        
    ];


    public function pieces(){
        return $this -> belongsToMany(Piece::class,'inter_piece','CODE_INTER','SN','CODE_INTER','SN');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function machine()
    {
        return $this->hasOne(Machine::class, 'ref_machine', 'ref_machine');
    }
}
