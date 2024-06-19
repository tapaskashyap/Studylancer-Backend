<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Multimedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'media',
        'media_url',
        'file_type'
    ];

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
