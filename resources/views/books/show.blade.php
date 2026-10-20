@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <a href="{{ route('books.index') }}" class="text-indigo-600 hover:underline">&larr; Zpět na seznam knih</a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h1 class="text-3xl font-bold mb-2">{{ $book->title }}</h1>
        <p class="text-gray-600 mb-4">Autor: <span class="font-semibold text-gray-800">{{ $book->author }}</span></p>

        <div class="flex gap-6 text-sm">
            <div><strong>ISBN:</strong> {{ $book->isbn }}</div>
            <div><strong>Dostupné výtisky:</strong> {{ $book->available_copies }} ks</div>
        </div>
    </div>

    <h2 class="text-xl font-bold mb-4">Historie a seznam výpůjček этой knihy</h2>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b">
            <tr>
                <th class="p-4">Čtenář</th>
                <th class="p-4">Email</th>
                <th class="p-4">Půjčeno</th>
                <th class="p-4">Termín vrácení</th>
                <th class="p-4">Stav</th>
                <th class="p-4 text-right">Akce</th>
            </tr>
            </thead>
            <tbody>
            @forelse($book->loans as $loan)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4 font-semibold">{{ $loan->reader->name }}</td>
                    <td class="p-4 text-sm text-gray-600">{{ $loan->reader->email }}</td>
                    <td class="p-4 text-sm">{{ $loan->borrowed_at->format('d.m.Y H:i') }}</td>
                    <td class="p-4 text-sm">{{ $loan->due_at->format('d.m.Y H:i') }}</td>
                    <td class="p-4">
                        @if($loan->returned_at)
                            <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-700">Vraceno {{ $loan->returned_at->format('d.m.Y') }}</span>
                        @elseif($loan->due_at->isPast())
                            <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800 font-bold">Po termínu!</span>
                        @else
                            <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800">Aktivní</span>
                        @endif
                    </td>
                    <td class="p-4 text-right">
                        @if(!$loan->returned_at)
                            <form action="{{ route('loans.return', $loan) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700">Vrátit knihu</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">Tato kniha nemá žádné výpůjčky.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
