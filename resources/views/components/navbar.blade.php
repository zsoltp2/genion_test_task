<nav class="bg-gray-800 text-white px-4 py-3">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div class="flex space-x-4">
            <a href="#" class="bg-gray-900 px-3 py-2 rounded-md text-sm font-medium">Social</a>
            <a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Friends</a>
        </div>

        <div class="flex items-center space-x-4">
            <button type="button" class="relative p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 cursor-pointer">
                <span class="sr-only">View notifications</span>
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
            </button>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-indigo-500 hover:bg-sky-500 text-white font-bold py-2 px-4 rounded-full cursor-pointer">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>
