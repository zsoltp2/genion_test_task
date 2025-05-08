<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Genion Social Club</title>


    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="h-14 bg-linear-to-t from-sky-500 to-indigo-500 text-[#1b1b18] flex p-6 min-h-screen justify-center items-center">
<div class="w-full max-w-xs">
    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="/">
        @csrf
        <h1 class="text-2xl text-center font-bold">Genion Social Club</h1>
        <div class="w-full h-0.5 bg-gray-500 mt-3 mb-5"></div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                E-mail
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                id="email"
                type="email"
                name="email"
                placeholder="john.example@test.com"
                value="{{ old('email') }}">

            <!-- Display error message for email -->
            @error('email')
            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Field -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                Password
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror"
                id="password"
                type="password"
                name="password"
                placeholder="**********">

            <!-- Display error message for password -->
            @error('password')
            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-center">
            <button class="bg-indigo-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer hover:bg-sky-500" type="submit">
                Log in
            </button>
        </div>

        <!-- Link to Registration -->
        <p class="text-center text-gray-500 text-xs pt-5">
            No account? <a href="/auth/register" class="underline">Register here!</a>
        </p>
    </form>
</div>

</body>
</html>
