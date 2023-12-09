<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commentaire extends Model
{
    use HasFactory;

    public function reponses() : HasMany 
    {
        return $this -> hasMany(Reponse::class);
    }

    public function partageExperience() : BelongsTo
    {
        return $this -> belongsTo(PartageExperience::class);
    }

    public function user() : BelongsTo
    {
        return $this -> belongsTo(User::class);
    }

}
