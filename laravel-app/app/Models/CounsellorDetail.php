<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CounsellorDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'available_country_id',
        'working_since',
        'students_helped',
        'about_me',
        'review_count',
        'review_rating',
        'counselling_fee',
    ];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'details');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(AvailableCountry::class,'available_country_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(CounsellorReview::class);
    }

    public function counsellor_timeslots(): BelongsToMany
    {
        return $this->belongsToMany(TimeSlot::class, 'counsellor_detail_timeslot');
    }

    public function counsellor_weekdays(): BelongsToMany
    {
        return $this->belongsToMany(Weekday::class, 'counsellor_detail_weekday');
    }

    public function counselling_bookings(): HasMany
    {
        return $this->hasMany(CounsellingBooking::class);
    }
}
