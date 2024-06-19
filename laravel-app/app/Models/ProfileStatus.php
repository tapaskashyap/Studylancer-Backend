<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProfileStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
