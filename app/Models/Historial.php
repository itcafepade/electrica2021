<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    use HasFactory;

    protected $table = 'historial';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'id_horario',
        'fecha',
        'setpoint',
        'proportional',
        'integral',
        'derivative',
        'temperature',
        'created_at',
        'updated_at',
    ];
}
