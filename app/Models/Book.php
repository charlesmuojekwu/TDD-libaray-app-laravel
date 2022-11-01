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


    public function checkout($user)
    {
        $this->reservations()->create([
            'user_id' => $user->id,
            'checked_out_at' => now()
        ]);
    }


    public function checkin($user)
    {
        $reservation = $this->reservations()->where('user_id', $user->id)
            ->whereNotNull('checkout_out_at')
            ->whereNull('checked_in_at')
            ->first();

        if(is_null($reservation))
        {
            throw new \Exception();
        }

        $reservation->update([
            'checked_in_at' => now(),
        ]);
    }


    public function authorId() : Attribute
    {
        return Attribute::make(
            set: fn($value) => (Author::firstOrCreate([
                'name' => $value
            ]))->id
        );
    }


    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
