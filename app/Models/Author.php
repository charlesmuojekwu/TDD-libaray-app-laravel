<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Author extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['dob'];

    public function setDobAttribute($dob)
    {
       return $this->attributes['dob'] = Carbon::parse($dob);
    }





}
