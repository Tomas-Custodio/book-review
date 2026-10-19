<?php

namespace App\Models;

use App\Models\Review;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    #protected $fillble = [];

    public function reviews(){

        return $this->hasMany(Review::class,'book_id');
    }

}
