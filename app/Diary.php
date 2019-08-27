<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    protected $fillable = [
        'title', 'contents', 'id_user'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
