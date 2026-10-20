<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Reader;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{
    // Přehled všech výpůjček
    public function index()
    {
        $loans = Loan::with(['book', 'reader'])
            ->latest('borrowed_at')
            ->paginate(15);

        return view('loans.index', compact('loans'));
    }

    // Zobrazení výpůjček po termínu
    public function overdue()
    {
        $loans = Loan::overdue()->with(['book', 'reader'])->get();

        return view('loans.overdue', compact('loans'));
    }

    // Formulář pro vytvoření nové výpůjčky
    public function create()
    {
        $books = Book::where('available_copies', '>', 0)->get();
        $readers = Reader::all();

        return view('loans.create', compact('books', 'readers'));
    }

    // Založení výpůjčky s validacemi
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'reader_id' => 'required|exists:readers,id',
            'borrowed_at' => 'required|date',
            'due_at' => 'required|date|after:borrowed_at',
        ]);

        $book = Book::findOrFail($request->book_id);

        // 1. Kontrola dostupnosti výtisku
        if ($book->available_copies < 1) {
            throw ValidationException::withMessages([
                'book_id' => 'Kniha nemá žádný dostupný výtisk k vypůjčení.',
            ]);
        }

        // 2. Kontrola: Stejnou knihu nelze jednomu čtenáři podruhé půjčit, dokud ji nevrátil
        $activeLoan = Loan::where('book_id', $book->id)
            ->where('reader_id', $request->reader_id)
            ->whereNull('returned_at')
            ->exists();

        if ($activeLoan) {
            throw ValidationException::withMessages([
                'reader_id' => 'Tento čtenář má již tuto knihu vypůjčenou a dosud ji nevrátil.',
            ]);
        }

        // Vytvoření výpůjčky a ponížení počtu dostupných výtisků
        Loan::create($validated);
        $book->decrement('available_copies');

        return redirect()->route('books.show', $book)->with('success', 'Výpůjčka byla úspěšně vytvořena.');
    }

    // Vrácení knihy
    public function returnBook(Loan $loan)
    {
        if ($loan->returned_at !== null) {
            return redirect()->back()->with('error', 'Tato výpůjčka již byla vracena.');
        }

        $loan->update(['returned_at' => now()]);
        $loan->book()->increment('available_copies');

        return redirect()->back()->with('success', 'Kniha byla úspěšně vrácena.');
    }
}
