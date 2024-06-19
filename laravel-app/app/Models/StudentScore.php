<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_detail_id',
        'english_proficiency_test_id',
        'listening',
        'reading',
        'writing',
        'speaking',
        'total',
        'document_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function student_details(): BelongsTo
    {
        return $this->belongsTo(StudentDetail::class);
    }

    public function english_proficiency_test(): BelongsTo
    {
        return $this->belongsTo(EnglishProficiencyTest::class);
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

}
