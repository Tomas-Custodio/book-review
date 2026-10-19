<?php

namespace App\Models;

use App\Models\Book;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;

    #protected $fillble = [];


    public function book(){

        return $this->BelongsTo(Book::class,'book_id');

    }
}
