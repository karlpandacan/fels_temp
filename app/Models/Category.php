<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'image', 'description'];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function words()
    {
        return $this->hasMany(Word::class, 'word_id');
    }

    public function assignValues($values)
    {
        if($values->input('category_id') !== null) {
            $this->id = $values->input('category_id'); // Execute line if category will be updated
        }

        $this->name = $values->input('category_name');
        $this->description = $values->input('category_desc');

        if(!empty($values->file('category_image'))) {
            $imageName = uniqid() . '.' . $values->file('category_image')->guessClientExtension();
            $values->file('category_image')->move(base_path() . '/public/images/categories/', $imageName);
            $this->image = $imageName;
        }

        $this->save();
    }
}
