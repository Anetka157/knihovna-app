@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Přehled všech výpůjček</h1>
        <a href="{{ route('loans.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">+ Nová výpůjčka</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b">
            <tr>
                <th class="p-4">Kniha</th>
                <th class="p-4">Čtenář</th>
                <th class="p-4">Datum vypůjčení</th>
                <th class="p-4">Termín vrácení</th>
                <th class="p-4">Stav</th>
                <th class="p-4 text-right">Akce</th>
            </tr>
            </thead>
            <tbody>
            @forelse($loans as $loan)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4 font-semibold">
                        <a href="{{ route('books.show', $loan->book) }}" class="text-indigo-600 hover:underline">
                            {{ $loan->book->title }}
                        </a>
                    </td>
                    <td class="p-4">
                        <div class="font-medium">{{ $loan->reader->name }}</div>
                        <div class="text-xs text-gray-500">{{ $loan->reader->email }}</div>
                    </td>
                    <td class="p-4 text-sm">{{ $loan->borrowed_at->format('d.m.Y H:i') }}</td>
                    <td class="p-4 text-sm">{{ $loan->due_at->format('d.m.Y H:i') }}</td>
                    <td class="p-4">
                        @if($loan->returned_at)
                            <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-700">Vráceno ({{ $loan->returned_at->format('d.m.Y') }})</span>
                        @elseif($loan->due_at->isPast())
                            <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800 font-bold">Po termínu</span>
                        @else
                            <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800 font-semibold">Aktivní</span>
                        @endif
                    </td>
                    <td class="p-4 text-right">
                        @if(!$loan->returned_at)
                            <form action="{{ route('loans.return', $loan) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700">
                                    Vrátit
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-gray-400">Vyřízeno</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">Zatím nebyly vytvořeny žádné výpůjčky.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $loans->links() }}
    </div>
@endsection
