<?php

namespace App\Community;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'community_tokens';

    protected $fillable = ['access_token', 'refresh_token'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
