<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CounsellingBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'counsellor_detail_id',
        'student_detail_id',
        'time_slot_id',
        'weekday_id',
        'transaction_id',
        'date'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function counsellor_details(): BelongsTo
    {
        return $this->belongsTo(CounsellorDetail::class,'counsellor_detail_id');
    }

    public function student_details(): BelongsTo
    {
        return $this->belongsTo(StudentDetail::class,'student_detail_id');
    }

    public function time_slot(): BelongsTo
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function weekday(): BelongsTo
    {
        return $this->belongsTo(Weekday::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
