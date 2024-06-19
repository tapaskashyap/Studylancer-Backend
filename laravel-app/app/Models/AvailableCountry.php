<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvailableCountry extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'image',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function student_details(): HasOne
    {
        return $this->HasOne(StudentDetails::class);
    }

    public function counsellor_details(): HasOne
    {
        return $this->HasOne(CounsellorDetails::class);
    }
}
