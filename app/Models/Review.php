<?php

namespace App\Models;

use App\Models\Book;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;

    protected $fillable = ['review','rating','book_id'];

    


    public function book(){

        return $this->BelongsTo(Book::class,'book_id');

    }

    protected static function booted () {

        Static::updated( 

            fn(Review $review) => cache()->forget('book:' . $review->book_id));

         Static::deleted( 

            fn(Review $review) => cache()->forget('book:' . $review->book_id));

    }
}
