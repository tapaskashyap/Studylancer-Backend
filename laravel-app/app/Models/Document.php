<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'document',
        'user_id',
        'document_type_id',
        'file_type'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function document_type(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function student_scores(): HasMany
    {
        return $this->hasMany(StudentScore::class);   
    }
}
