<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Livrable extends Model
{
    use HasFactory;
    protected $fillable = [
        'livrable',
        'ressource_id',
        'user_id',
    ];

    public function user() : BelongsTo
    {
        return $this -> belongsTo(User::class);
    }
}
