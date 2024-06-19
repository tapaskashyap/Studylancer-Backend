<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EnglishProficiencyTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function student_scores(): HasMany
    {
        return $this->hasMany(StudentScore::class);
    }
}
