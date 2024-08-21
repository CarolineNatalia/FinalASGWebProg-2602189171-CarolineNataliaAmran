<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'gender',
        'job',
        'username',
        'picture',
        'coins',
        'registration_cost',
        'visibility',
        'paid_registration',
        'picture_before_invisible'
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class, 'user_fields');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id');
    }

    public function friendRequests()
    {
        return $this->belongsToMany(User::class, 'friend_requests', 'user_id', 'friend_id');
    }
    public function avatars()
    {
        // from UserAvatar
        return $this->hasMany(UserAvatar::class);
    }
}
