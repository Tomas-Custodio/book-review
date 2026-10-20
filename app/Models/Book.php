<?php

namespace App\Models;

use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $fillable = ['title', 'user_id'];

    public function reviews(){

        return $this->hasMany(Review::class,'book_id');
    }

    public function user(){

        return $this->BelongsTo(User::class,'user_id');
    }

    public function scopeTitle( Builder $query , string $title):Builder
    {
        return  $query->where('title', "LIKE","%$title%");

    }

    public function scopeWithAvgRating(Builder $query): Builder
{
    return $query->withAvg('reviews', 'rating');
}

    public function scopeReviewWithCount( Builder $query, ?string $from = null, ?string $to = null):Builder {

        return $query->withount(['reviews'], fn( Builder $query) => $this->datarangeFilter($query, $from, $to));

     }

  public function scopePopular(Builder $query, ?string $from = null, ?string $to = null): Builder {


        return $query->withCount([

            'reviews' => fn(Builder $reviewsQuery) => $this->dateRangeFilter($reviewsQuery ,$from, $to)])->orderBy('reviews_count', 'desc');
}

    public function scopeHighestRated( Builder $query):Builder{

        return $query->withavg('reviews','rating')->orderby('reviews_avg_rating','desc');

    }

    public function scopeMinReviews( Builder $query, int $minReviews):Builder {

            return $query->having('reviews_count', ">=" ,$minReviews);
    }

    private function dateRangeFilter(  Builder $query , $from = null , $to = null ){

            if ($from && $to) {

                $query->whereBetween('created_at', [$from, $to]);

            } elseif ($from) {

                $query->where('created_at', '>=', $from);

            } elseif ($to) {

                $query->where('created_at', '<=', $to);

            }      
    }

        public function scopePopularLastMonth(Builder $query): Builder {
    
            return $query->popular(now()->subMonth(), now())->highestRated(now()->subMonth(), now())->minReviews(2);
        }

        public function scopePopularLast6Months(Builder $query): Builder {

            return $query->popular(now()->subMonths(6), now())->highestRated(now()->subMonths(6), now())->minReviews(5);
        }

        public function scopeHighestRatedLastMonth(Builder $query): Builder {
            return $query->highestRated(now()->subMonth(), now())->popular(now()->subMonth(), now())->minReviews(2);
        }

        public function scopeHighestRatedLast6Months(Builder $query): Builder{
            
            return $query->highestRated(now()->subMonths(6), now())->popular(now()->subMonths(6), now())->minReviews(5);
        }




    
    protected static function booted () {

        Static::updated( 

            fn(Book $book) => cache()->forget('book:' . $book->id));

         Static::deleted( 

            fn(Book $book) => cache()->forget('book:' . $book->id));


    }

    
    
}