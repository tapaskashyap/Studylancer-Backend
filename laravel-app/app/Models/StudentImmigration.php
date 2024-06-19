<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentImmigration extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_detail_id',
        'country_id',
        'visa_type',
        'visa_outcome',
        'year',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function student_detail(): BelongsTo
    {
        return $this->belongsTo(StudentDetail::class);
    }
}
