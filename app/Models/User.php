<?php

namespace App\Models;

use DevDojo\LaravelReactions\Traits\Reacts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, HasPermissions,Reacts;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'type',
        'fcm_id',
        'firebase_id',
        'profile',
        'address',
        'notification',
        'country_code'
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


    public function getProfileAttribute($image) {
        if (!empty($image) && !filter_var($image, FILTER_VALIDATE_URL)) {
            return url(Storage::url($image));
        }
        return $image;
    }

    /* Define relationships */
    public function blockedUsers()
    {
        return $this->belongsToMany(User::class, 'blocked_users', 'user_id', 'blocked_user_id');
    }

    public function settings()
    {
        return $this->hasMany(UserSetting::class);
    }

    /* user subscriber of news channels*/
    public function subscriptions()
    {
        return $this->belongsToMany(Channel::class, 'channel_subscribers', 'user_id', 'channel_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

}
