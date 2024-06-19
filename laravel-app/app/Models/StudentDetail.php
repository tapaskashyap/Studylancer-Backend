<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'available_country_id',
        'state',
        'city',
        'dob',
        'marital_status',
        'notes_for_counsellor'
    ];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'details');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(AvailableCountry::class,'available_country_id');
    }

    public function student_scores(): HasMany
    {
        return $this->hasMany(StudentScore::class);
    }

    public function student_immigrations(): HasMany
    {
        return $this->hasMany(StudentImmigration::class);   
    }

    public function counselling_bookings(): HasMany
    {
        return $this->hasMany(CounsellingBooking::class);
    }
}
