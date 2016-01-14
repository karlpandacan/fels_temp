<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'image', 'description'];

    public function lessons()
    {
        $this->hasMany(Lesson::class);
    }

    public function words()
    {
        $this->hasMany(Word::class);
    }
}
