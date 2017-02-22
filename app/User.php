<?php

namespace App;

use App\Community\Client;
use App\Community\Token;
use App\Images\Image;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Privateer\Uuid\EloquentUuid;

class User extends Authenticatable
{
    use Notifiable, EloquentUuid, HasApiTokens;

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

    public function avatar()
    {
        return $this->belongsTo(Image::class);
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function token()
    {
        return $this->hasOne(Token::class);
    }
}
