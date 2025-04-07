<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    protected $fillable = [
        'user_id',
        'titre',
        'description',
        'type',
        'forme_juridique',
        'plan_affaire_path',
        'resume_path',
        'statut',
        'justification_rejet',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
