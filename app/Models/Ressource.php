<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ressource extends Model
{
    use HasFactory;

    public function ressouce() : BelongsTo
    {
        return $this -> belongsTo(Guide::class);
    }

    
}
