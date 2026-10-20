@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Seznam knih</h1>
        <a href="{{ route('books.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">+ Přidat knihu</a>
    </div>

    {{-- Vyhledávací filtr --}}
    <form action="{{ route('books.index') }}" method="GET" class="mb-6 flex gap-2">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Hledat podle názvu nebo autora..."
            class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">Hledat</button>
        @if(request('search'))
            <a href="{{ route('books.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 flex items-center">Zrušit</a>
        @endif
    </form>

    {{-- Tabulka knih --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b">
            <tr>
                <th class="p-4">Název</th>
                <th class="p-4">Autor</th>
                <th class="p-4">ISBN</th>
                <th class="p-4 text-center">Dostupné výtisky</th>
                <th class="p-4 text-right">Akce</th>
            </tr>
            </thead>
            <tbody>
            @forelse($books as $book)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4 font-semibold">
                        <a href="{{ route('books.show', $book) }}" class="text-indigo-600 hover:underline">
                            {{ $book->title }}
                        </a>
                    </td>
                    <td class="p-4">{{ $book->author }}</td>
                    <td class="p-4 text-sm text-gray-600">{{ $book->isbn }}</td>
                    <td class="p-4 text-center">
                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $book->available_copies > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $book->available_copies }} ks
                        </span>
                    </td>
                    <td class="p-4 text-right space-x-2">
                        <a href="{{ route('books.show', $book) }}" class="text-blue-600 hover:underline">Detail</a>
                        <a href="{{ route('books.edit', $book) }}" class="text-yellow-600 hover:underline">Upravit</a>
                        <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Opravdu smazat?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Smazat</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">Žádné knihy nebyly nalezeny.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $books->links() }}
    </div>
@endsection
