<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemandeAccompagnement extends Model
{
    use HasFactory;

    protected $fillable =  [
        'titre',
        'description',
        'objectif',
        'statut',
        'user_id',
    
    ];

    public function user() : BelongsTo
    {
        return $this -> belongsTo(User::class);
    } 
}
