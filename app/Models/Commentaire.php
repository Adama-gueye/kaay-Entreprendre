<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commentaire extends Model
{
    use HasFactory;

    public function reponse() : BelongsTo
    {
        return $this -> belongsTo(Reponse::class);
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
