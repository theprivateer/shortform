<?php

namespace App\Community;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Privateer\Uuid\EloquentUuid;

class Client extends Model
{
    use EloquentUuid;

    protected $table = 'community_clients';

    protected $fillable = ['base_url', 'client_id', 'secret'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
