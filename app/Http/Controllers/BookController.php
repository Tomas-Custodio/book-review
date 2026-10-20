<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
     #  Method to acess a list of books.

    public function index( Request $request) {

       $title = $request->input('title');
       $books = BooK::when($title,function( $query ,$title) {

            return $query->Title($title); 

        })->get();

        return view('Books.list',compact('books'));

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

    public function details(book $book) {

        $book->delete();
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
