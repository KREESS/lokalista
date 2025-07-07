<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveChat extends Model
{
    protected $fillable = ['user_id', 'message', 'is_from_admin'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
