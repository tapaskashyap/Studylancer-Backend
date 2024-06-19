<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'tel_code',
        'flag',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function available_country(): HasOne
    {
        return $this->hasOne(AvailableCountry::class);
    }
}
