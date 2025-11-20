<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'expiration_date',
        'status'
    ];


    public function increaseQuantity(int $amount = 1)
    {
        $this->quantity += $amount;
        $this->save();
    }

    public function decreaseQuantity(int $amount = 1)
    {
        $this->quantity -= $amount;
        if ($this->quantity < 0) {
            $this->quantity = 0;
        }
        $this->save();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


}


