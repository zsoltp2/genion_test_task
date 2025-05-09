<x-app-layout>
    <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-gray-800 text-white p-4 rounded-lg shadow-md relative">
            <h1 class="text-2xl font-semibold mb-4">Potential friends:</h1>

            <div id="scrollbox-registered" class="max-h-96 overflow-y-auto space-y-4 pr-2">
                @foreach($users as $user)
                    @if($user->id !== auth()->id())
                    <div class="bg-gray-700 text-white p-4 rounded-lg shadow-md">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div>
                                <p class="text-lg font-semibold">{{ $user->name }}</p>
                                <p>{{ $user->email }}</p>
                            </div>
                            @if (auth()->user()->sentRequests()->where('friend_id', $user->id)->count() == 0)
                                <form action="{{ route('user.sendRequest', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-indigo-500 hover:bg-sky-500 text-white font-bold py-2 px-4 rounded cursor-pointer">
                                        Send friend request
                                    </button>
                                </form>
                            @else
                                <p class="text-gray-500">Request sent</p>
                            @endif
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>

            <div id="arrow-registered" class="hidden absolute bottom-1 left-1/2 transform -translate-x-1/2 text-white animate-bounce">
                ↓
            </div>
        </div>

        <div class="bg-gray-800 text-white p-4 rounded-lg shadow-md relative">
            <h1 class="text-2xl font-semibold mb-4">Your friends:</h1>

            <div id="scrollbox-approved" class="max-h-96 overflow-y-auto space-y-4 pr-2">
                @foreach($friends as $friend)
                    <div class="bg-gray-600 text-white p-4 rounded-lg shadow-md">
                        <p class="text-lg font-semibold">{{ $friend->name }}</p>
                        <p>{{ $friend->email }}</p>
                    </div>
                @endforeach
            </div>

            <div id="arrow-approved" class="hidden absolute bottom-1 left-1/2 transform -translate-x-1/2 text-white animate-bounce">
                ↓
            </div>
        </div>

        <div class="bg-gray-800 text-white p-4 rounded-lg shadow-md relative">
            <h1 class="text-2xl font-semibold mb-4">Incoming Friend Requests:</h1>

            <div class="max-h-96 overflow-y-auto space-y-4 pr-2 mx-auto">
                @forelse($incomingRequests as $request)
                    <div class="bg-gray-700 text-white p-4 rounded-lg shadow-md">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div>
                                <p class="text-lg font-semibold">{{ $request->user->name }}</p>
                                <p>{{ $request->user->email }}</p>
                            </div>
                            <div class="flex gap-2">
                                <form action="{{ route('user.acceptRequest', $request->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded cursor-pointer">
                                        Accept
                                    </button>
                                </form>
                                <form action="{{ route('user.rejectRequest', $request->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded cursor-pointer">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-400 text-center">No incoming friend requests.</p>
                @endforelse
            </div>

            <div id="arrow-incoming" class="hidden absolute bottom-1 left-1/2 transform -translate-x-1/2 text-white animate-bounce">
                ↓
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function setupScrollIndicator(scrollBoxId, arrowId) {
                const box = document.getElementById(scrollBoxId);
                const arrow = document.getElementById(arrowId);

                if (box.scrollHeight > box.clientHeight) {
                    arrow.classList.remove('hidden');
                }

                box.addEventListener('scroll', () => {
                    arrow.classList.add('hidden');
                });
            }

            setupScrollIndicator('scrollbox-registered', 'arrow-registered');
            setupScrollIndicator('scrollbox-approved', 'arrow-approved');
            setupScrollIndicator('scrollbox-incoming', 'arrow-incoming');
        });
    </script>
</x-app-layout>
