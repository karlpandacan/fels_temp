<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['user_id', 'category_id'];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function category()
    {
        $this->belongsTo(Category::class);
    }

    public function lessonWords()
    {
        $this->hasMany(LessonWord::class);
    }

    public function activity()
    {
        $this->hasOne(Activity::class);
    }
}
