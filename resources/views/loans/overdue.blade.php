@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6 text-red-600">Výpůjčky po termínu</h1>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-red-50 border-b">
            <tr>
                <th class="p-4">Kniha</th>
                <th class="p-4">Čtenář</th>
                <th class="p-4">Kontakt</th>
                <th class="p-4">Datum vypůjčení</th>
                <th class="p-4">Termín vrácení</th>
                <th class="p-4 text-right">Akce</th>
            </tr>
            </thead>
            <tbody>
            @forelse($loans as $loan)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4 font-semibold">{{ $loan->book->title }}</td>
                    <td class="p-4">{{ $loan->reader->name }}</td>
                    <td class="p-4 text-sm text-gray-600">{{ $loan->reader->email }}</td>
                    <td class="p-4 text-sm">{{ $loan->borrowed_at->format('d.m.Y') }}</td>
                    <td class="p-4 text-sm text-red-600 font-bold">{{ $loan->due_at->format('d.m.Y') }}</td>
                    <td class="p-4 text-right">
                        <form action="{{ route('loans.return', $loan) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700">
                                Vrátit knihu
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">Žádné výpůjčky po termínu! 🎉</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
