<x-app-layout>
    <div class="w-full max-w-xs">
        <h1>Index page</h1>
        <form method="POST" action="/index">
            @csrf
            <button type="submit" class="cursor-pointer">Logout</button>
        </form>
    </div>
</x-app-layout>
