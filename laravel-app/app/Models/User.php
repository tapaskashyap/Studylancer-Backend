<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'country_id',
        'avatar',
        'password',
        'details_id',
        'details_type',
        'review_count',
        'review_rating'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'phone_verified_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function hasVerifiedPhone()
    {
        return ! is_null($this->phone_verified_at);
    }

    public function hasApprovedProfile()
    {
        return ! is_null($this->approved_at);
    }

    public function hasProfileComplete()
    {
        return ($this->profile_status_id == 6)?True:False;
    }

    public function callback_request(): HasOne
    {
        return $this->hasOne(CallbackRequest::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function details(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'details_type', 'details_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(ProfileStatus::class,'profile_status_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function multimedia(): HasMany
    {
        return $this->hasMany(Multimedia::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

}
