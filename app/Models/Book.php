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

  public function scopePopular(Builder $query, ?string $from = null, ?string $to = null): Builder {


        return $query->withCount([

            'reviews' => fn(Builder $reviewsQuery) => $this->dateRangeFilter($reviewsQuery ,$from, $to)])->orderBy('reviews_count', 'desc');
}

    public function scopeHighestRated( Builder $query):Builder{

        return $query->withavg('reviews','rating')->orderby('reviews_avg_rating','desc');

    }

    public function scopeMinReviews( Builder $query, int $minReviews): Builder|QueryBuilder{

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
    
}