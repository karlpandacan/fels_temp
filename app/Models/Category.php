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
        $data = [
            'name' => $values->input('category_name'),
            'description' => $values->input('category_desc')
        ];

        if(!empty($values->file('category_image'))) {
            $data = $this->saveImage($data, $values);
        }

        if($values->input('category_id') == null) {
            $this->firstOrCreate($data);
        } else {
            $this->update($data);
        }
    }

    private function saveImage($data, $values)
    {
        $imageName = $this->image;
        if(empty($this->image)) {
            $imageName = $this->generateName($values); // Create new name;
        }

        $values->file('category_image')->move(base_path() . '/public/images/categories/', $imageName);
        $data['image'] = $imageName;

        return $data;
    }

    private function generateName($values)
    {
        return uniqid() . '.' . $values->file('category_image')->getClientOriginalExtension();
    }
}
