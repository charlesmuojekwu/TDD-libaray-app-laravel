<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function path()
    {
       return  '/books/'.$this->id;
    }

    public function authorId() : Attribute
    {
        return Attribute::make(
            set: fn($value) => (Author::firstOrCreate([
                'name' => $value
            ]))->id
        );
    }
}
