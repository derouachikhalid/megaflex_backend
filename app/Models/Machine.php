<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Machine extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'machines';
    protected $primaryKey='ref_machine';
    public $incrementing= false;
    protected $keyType='string';
    
    protected $fillable =[
        'ref_machine',
        'name_machine',
        'discipline_machine',
        'fonction_machine',
        'date_entree',
        'date_sortie',
        'accessoires_machine',
        'image_machine',
        'status',
        'client_id',
        'fournissur_id'
    ];
    public function client()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }
    public function fournissor()
    {
        return $this->hasOne(Fournissor::class, 'id', 'fournissur_id');
    }
}
