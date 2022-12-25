<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Interfaces\ValidationRules;
use Illuminate\Database\Eloquent;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements ValidationRules
{
    use HasApiTokens;
    use Eloquent\Factories\HasFactory;
    use Notifiable;

    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function documents(): Eloquent\Relations\HasMany
    {
        return $this->hasMany(
            Document::class,
            'user_id',
            'user_id'
        );
    }

    public function isGuest(): bool
    {
        return $this->user_id === null;
    }

    static public function getFormValidationRules(?array $additionalRules = []): array
    {
       return [
               'name' => 'required|string',
               'email' => "required|email:rfc,dns|unique:App\Models\User"
           ] + $additionalRules;
    }
}
