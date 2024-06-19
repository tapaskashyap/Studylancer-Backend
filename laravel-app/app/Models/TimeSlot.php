<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\TimeCast;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'slot_name',
        'start',
        'end',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'
    ];

    protected $casts = [
        'start' => TimeCast::class,
        'end' => TimeCast::class,
    ];

    public function callback(): HasOne
    {
        return $this->HasOne(CallbackRequest::class);
    }
}
