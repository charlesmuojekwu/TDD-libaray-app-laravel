<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(Request $request)
    {

        $data = $this->validateRequest();

        // Book::create([
        //     'title' => $request->title,
        //     'author' => $request->author
        // ]);

        $book = Book::create([
            'title' => $data['title'],
            'author' => $data['author']
        ]);

        return redirect($book->path());
    }


    public function update(Book $book)
    {
        $data = $this->validateRequest();
        $book->update($data);

        return redirect($book->path());
    }


    public function destroy(Book $book)
    {
        $book->delete();

        return redirect('/books');
    }


    protected function validateRequest()
    {
        return  request()->validate([
            'title' => 'required',
            'author' => 'required'
        ]);
    }
}
