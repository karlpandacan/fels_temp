<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearnedWord extends Model
{
    protected $fillable = ['word_id', 'user_id'];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function word()
    {
        $this->belongsTo(Word::class);
    }
}
