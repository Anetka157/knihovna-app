<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Seznam knih s filtrem podle názvu nebo autora
    public function index(Request $request)
    {
        $query = Book::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $books = $query->paginate(10);

        return view('books.index', compact('books'));
    }

    // Formulář pro novou knihu
    public function create()
    {
        return view('books.create');
    }

    // Uložení nové knihy
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|size:13|unique:books,isbn',
            'available_copies' => 'required|integer|min:0',
        ]);

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Kniha byla úspěšně přidána.');
    }

    // Detail knihy se seznamem výpůjček
    public function show(Book $book)
    {
        $book->load(['loans.reader']);

        return view('books.show', compact('book'));
    }

    // Formulář pro úpravu knihy
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    // Aktualizace knihy
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|size:13|unique:books,isbn,' . $book->id,
            'available_copies' => 'required|integer|min:0',
        ]);

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Kniha byla aktualizována.');
    }

    // Smazání knihy
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Kniha byla smazána.');
    }
}
