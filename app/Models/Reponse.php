<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reponse extends Model
{
    use HasFactory;


    public function commentaires() : HasMany
    {
        return $this -> hasMany(Commentaire::class);
    }

    
}
