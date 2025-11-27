<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * GET all books
     */
    public function indexUI()
    {
        $books = Book::all();
        return view('home', compact('books'));
    }

    public function createUI()
    {
        return view('books.create');
    }



    /**
     * GET single book by id
     */
    public function show($id)
    {
        return Book::findOrFail($id);
    }

    /**
     * CREATE book
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'author'    => 'required|string|max:255',
            'isbn'      => 'nullable|string|max:20',
            'owner_id'  => 'required|exists:users,id'
        ]);

        Book::create($validated);

        return redirect()->route('books.list')->with('success', 'Book created successfully!');
    }

    

    /**
     * UPDATE book
     */

    public function editUI($id)
    {
        $book = Book::findOrFail($id);
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title'     => 'sometimes|string|max:255',
            'author'    => 'sometimes|string|max:255',
            'isbn'      => 'sometimes|nullable|string|max:20',
            'owner_id'  => 'sometimes|exists:users,id',
        ]);

        $book->update($validated);

        return redirect()->route('books.list')->with('success', 'Book updated successfully!');
    }

    /**
     * DELETE book
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully'
        ]);
    }
}
