<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Attribute;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\OneTimePasswords\Models\Concerns\HasOneTimePasswords;

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasOneTimePasswords, InteractsWithMedia, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'social',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'social' => 'array',
        ];
    }

    /**
     * Mutator untuk 'phone'.
     *
     * Secara otomatis mengisi 'phone_formatted'
     * setiap kali 'phone' diatur.
     */
    protected function phone(): Attribute
    {
        return Attribute::make(
            // 'set' akan dipanggil setiap kali Anda melakukan:
            // $contact->phone = '08123...'
            // Contact::create(['phone' => '08123...'])
            set: fn ($value) => [
                'phone_original' => $value, // Simpan nilai asli
                'phone' => formatPhoneNumber($value), // Simpan nilai yang diformat
            ],
        );
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Determine if the user has verified their Whatsapp.
     *
     * @return bool
     */
    public function hasVerifiedPhone()
    {
        return ! is_null($this->phone_verified_at);
    }

    /**
     * Mark the given user's Whatsapp as verified.
     *
     * @return bool
     */
    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function isVerified()
    {
        return $this->hasVerifiedPhone() || $this->hasVerifiedEmail();
    }

    /**
     * Get all of the submissions for the User
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->phone_original = $user->phone;
            $user->phone = formatPhoneNumber($user->phone);
        });
    }
}
