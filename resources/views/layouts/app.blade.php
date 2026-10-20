<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knihovní Systém</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
<nav class="bg-indigo-600 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <a href="{{ route('books.index') }}" class="text-xl font-bold">📚 Knihovna</a>
        <div class="space-x-4">
            <a href="{{ route('books.index') }}" class="hover:underline">Seznam knih</a>
            <a href="{{ route('loans.index') }}" class="hover:underline">Přehled výpůjček</a>
            <a href="{{ route('loans.create') }}" class="hover:underline">+ Nová výpůjčka</a>
            <a href="{{ route('loans.overdue') }}" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm font-semibold">
                Výpůjčky po termínu
            </a>
        </div>
    </div>
</nav>

<main class="max-w-7xl mx-auto px-4 py-6">
    {{-- Flash zprávy --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</main>
</body>
</html>
