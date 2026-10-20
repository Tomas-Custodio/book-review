<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
     #  Method to acess a list of books.

    // public function index( Request $request) {

    //    $title = $request->input('title');
    //    $filter = $request->input('filter');

    //    $books = BooK::when($title,function( $query ,$title) {

    //         return $query->Title($title); })->get();

    //     $books = Match( $filter ) {

    //         'popular_last_month' => $books->PopularLastMonth,
    //         'popular_last_6month' => $books->PopularLast6Months,

    //         'highest_rated_last_month' => $books->HighestRatedLastMonth,
    //         'highest_rated_last_6month' => $books->HighestRatedLast6Months,

    //     };

    //     $books = $books->get();

    //     return view('Books.list',compact('books'));

    // }


    public function index(Request $request){

    $title = $request->input('title');
    $filter = $request->input('filter');

    $book = Book::query()->when($title, function ($query, $title) {
        return $query->title($title);
        });

    $query = match ($filter) {

        'popular_last_month' => $book->popularLastMonth(),

        'popular_last_6month' =>$book->popularLast6Months(),

        'highest_rated_last_month' =>$book->highestRatedLastMonth(),

        'highest_rated_last_6month' =>$book->highestRatedLast6Months(),

        default => $book
            ->withCount('reviews')
            ->withAvg('reviews', 'rating'),
    };
    
        $cachKey = "book:". $title .":". $filter ;

        $books = 
        
            // cache::remember(
            // $cachKey, 3600,
            // fn() => 
            
            $book->get();
        // );

        $books = $query->get();

    return view('Books.list', compact('books'));
}

    #  Method to acess the form to create a new book.

    public function create(){

        return view('Books.create');
    }

      #  Method to store tha data of new book.
  
    public function store(Request $request) {

        $data = $request->validate([

            'title'   => "required|string",
            'user_id' => 'required|integer']);

        $new_book = Book::create($data);

        return redirect()->back()->with('msg','book created');
    }

     #  Method to acess see books details.



       /*  $book->with('reviews'); */

    public function details(Book $book){
    /* dd($book); */

    $cachKey = "book:". $book->id;

        $books = cache::remember(

            $cachKey, 3600,

            fn() => 
            Book::with(['reviews' => fn($query) => $query->latest()])->WithAvgRating()->findorFail($book->id)
        );

    return view('Books.details', compact('book'));
}

    #  Method to acess the form to edit a book.

    public function edit(book $book) {

        return view('Books.edit',compact('book'));
    }

    # Method to update a edited book.

    public function update(Request $request, book $book) {
        
        $data = $request->validate([

            'title'   => "required|string",
            'user_id' => 'required|integer'    
        ]);

        $book->update($data);
        return redirect()->back()->with('msg','book updated');

    }

    # Method to delete book.
    
    public function destroy(book $book) {

        $book->delete();
        return redirect()->back()->with('msg','book deleted');
    }

}
