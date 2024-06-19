<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CounsellorReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'counsellor_detail_id',
        'user_id',
        'review',
        'rating',
    ];

    public function counsellor_details(): BelongsTo
    {
        return $this->belongsTo(CounsellorDetail::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
