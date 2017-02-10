<?php

namespace App;

use App\Images\Image;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Privateer\Uuid\EloquentUuid;

class User extends Authenticatable
{
    use Notifiable, EloquentUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class)->latest();
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
