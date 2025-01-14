<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::paginate(5); // Пагінація
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author_id' => 'integer',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        Book::create($request->all());
        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author_id' => 'integer',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        $book->update($request->all());
        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

//    public function destroy(Book $book)
//    {
//        $book->delete();
//        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
//    }
    public function destroy($id)
    {
        $book = Book::find($id);

        if ($book) {
            $book->delete();
            return response()->json(['success' => true, 'bookId' => $id]);
        }

        return response()->json(['success' => false], 400);
    }


}
