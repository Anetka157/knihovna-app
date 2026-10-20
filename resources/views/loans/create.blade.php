@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-xl font-bold mb-4">Vytvořit novou výpůjčku</h1>

        <form action="{{ route('loans.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Vyberte knihu</label>
                <select name="book_id" class="w-full p-2 border rounded focus:ring-2 focus:ring-indigo-500" required>
                    <option value="">-- Vyberte knihu --</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                            {{ $book->title }} (Dostupné: {{ $book->available_copies }} ks)
                        </option>
                    @endforeach
                </select>
                @error('book_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Vyberte čtenáře</label>
                <select name="reader_id" class="w-full p-2 border rounded focus:ring-2 focus:ring-indigo-500" required>
                    <option value="">-- Vyberte čtenáře --</option>
                    @foreach($readers as $reader)
                        <option value="{{ $reader->id }}" {{ old('reader_id') == $reader->id ? 'selected' : '' }}>
                            {{ $reader->name }} ({{ $reader->email }})
                        </option>
                    @endforeach
                </select>
                @error('reader_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Datum výpůjčky</label>
                <input type="datetime-local" name="borrowed_at" value="{{ old('borrowed_at', now()->format('Y-m-d\TH:i')) }}" class="w-full p-2 border rounded focus:ring-2 focus:ring-indigo-500" required>
                @error('borrowed_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Termín vrácení (due_at)</label>
                <input type="datetime-local" name="due_at" value="{{ old('due_at', now()->addDays(14)->format('Y-m-d\TH:i')) }}" class="w-full p-2 border rounded focus:ring-2 focus:ring-indigo-500" required>
                @error('due_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Vytvořit výpůjčku</button>
        </form>
    </div>
@endsection
