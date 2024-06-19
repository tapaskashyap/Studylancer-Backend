<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CallbackRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'time_slot_id',
        'date',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
        'date' => 'date',
    ];

    public function time_slot(): BelongsTo
    {
        return $this->BelongsTo(TimeSlot::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
