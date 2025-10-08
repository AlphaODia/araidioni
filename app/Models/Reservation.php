<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'hebergement_id',
        'user_id',
        'arrivee',
        'depart',
        'nom',
        'email',
        'telephone',
        'nombre_nuits',
        'prix_total',
        'statut'
    ];

    protected $casts = [
        'arrivee' => 'date',
        'depart' => 'date',
    ];
}