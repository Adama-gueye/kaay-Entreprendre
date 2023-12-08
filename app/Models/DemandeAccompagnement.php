<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DemandeAccompagnement extends Model
{
    use HasFactory;

    protected $fillable =  [
        'titre',
        'description',
        'objectif',
        'etat',
        'user_id',
    ];

    public function users() : BelongsToMany
    {
        return $this -> belongsToMany(User::class);
    } 
}
