<nav class="bg-gray-800 text-white px-4 py-3">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div class="flex space-x-4">
            @if(auth()->user()?->is_admin)
                <a href="/dashboard" class="{{ request()->is('dashboard') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">
                    Dashboard
                </a>
            @endif
                <a href="/index" class="{{ request()->is('index') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">
                    Home
                </a>
            <a href="/friends" class="{{ request()->is('friends') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">
                Friends
            </a>
        </div>


        <div class="flex items-center space-x-4 relative z-2">
            <button type="button" class="relative p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 cursor-pointer" id="notificationButton">
                <span class="sr-only">View notifications</span>
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
                @if(auth()->user() && auth()->user()->unreadNotifications->count())
                    <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </button>
            <div id="notificationDropdown" class="absolute right-0 hidden bg-gray-800 text-white shadow-lg rounded-lg w-60 mt-35">
                <div class="max-h-60 overflow-y-auto">
                    @if(auth()->user() && auth()->user()->unreadNotifications->count())
                        @foreach(auth()->user()->unreadNotifications as $notification)
                            <form action="{{ route('notification.read', $notification->id) }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="w-full group">
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-200 group-hover:bg-gray-700 hover:rounded cursor-pointer">
                                        {{ $notification->data['message'] ?? 'No message' }}
                                    </button>
                                </div>

                            </form>
                        @endforeach
                    @else
                        <div class="px-4 py-2 text-sm text-gray-500">No new notifications</div>
                    @endif

                </div>
                <div class="border-t border-gray-700">
                    <a href="{{ route('notifications.markAsRead') }}" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-700 hover:rounded">Mark all as read</a>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-indigo-500 hover:bg-sky-500 text-white font-bold py-2 px-4 rounded-full cursor-pointer">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notificationButton = document.getElementById('notificationButton');
        const notificationDropdown = document.getElementById('notificationDropdown');

        notificationButton.addEventListener('click', function () {
            notificationDropdown.classList.toggle('hidden');
        });

        // Optional: Close the dropdown when clicking outside
        document.addEventListener('click', function (event) {
            if (!notificationButton.contains(event.target) && !notificationDropdown.contains(event.target)) {
                notificationDropdown.classList.add('hidden');
            }
        });
    });
</script>

