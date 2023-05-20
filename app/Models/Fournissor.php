<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Fournissor extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'founissors';
    protected $fillable =[
        'name_founissor',
        'email_founissor',
        'telephone_founissor',
        'adresse_founissor',
        'logo_founissor',
        'description_founissor'
    ];
}
