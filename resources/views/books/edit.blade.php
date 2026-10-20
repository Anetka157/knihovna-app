@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-xl font-bold mb-4">Upravit knihu</h1>

        <form action="{{ route('books.update', $book) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1">Název knihy</label>
                <input type="text" name="title" value="{{ old('title', $book->title) }}" class="w-full p-2 border rounded focus:ring-2 focus:ring-indigo-500" required>
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Autor</label>
                <input type="text" name="author" value="{{ old('author', $book->author) }}" class="w-full p-2 border rounded focus:ring-2 focus:ring-indigo-500" required>
                @error('author') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">ISBN</label>
                <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" maxlength="13" class="w-full p-2 border rounded focus:ring-2 focus:ring-indigo-500" required>
                @error('isbn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Počet dostupných výtisků</label>
                <input type="number" name="available_copies" value="{{ old('available_copies', $book->available_copies) }}" min="0" class="w-full p-2 border rounded focus:ring-2 focus:ring-indigo-500" required>
                @error('available_copies') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-yellow-600 text-white py-2 rounded hover:bg-yellow-700">Aktualizovat knihu</button>
        </form>
    </div>
@endsection
