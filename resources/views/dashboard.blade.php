<x-app-layout>
    <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-gray-800 text-white p-4 rounded-lg shadow-md relative">
            <h1 class="text-2xl font-semibold mb-4">Waiting for approval:</h1>

            <div id="scrollbox-registered" class="max-h-96 overflow-y-auto space-y-4 pr-2">
                @foreach($registered_users as $user)
                    <div class="bg-gray-700 text-white p-4 rounded-lg shadow-md">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div>
                                <p class="text-lg font-semibold">{{ $user->name }}</p>
                                <p>{{ $user->email }}</p>
                            </div>
                            <form action="{{ route('user.approve', $user) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-indigo-500 hover:bg-sky-500 text-white font-bold py-2 px-4 rounded cursor-pointer">
                                    Approve request
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="arrow-registered" class="hidden absolute bottom-1 left-1/2 transform -translate-x-1/2 text-white animate-bounce">
                ↓
            </div>
        </div>
        <div class="bg-gray-800 text-white p-4 rounded-lg shadow-md relative">
            <h1 class="text-2xl font-semibold mb-4">Approved users:</h1>

            <div id="scrollbox-approved" class="max-h-96 overflow-y-auto space-y-4 pr-2">
                @foreach($approved_users as $user_approved)
                    <div class="bg-gray-600 text-white p-4 rounded-lg shadow-md">
                        <p class="text-lg font-semibold">{{$user_approved->name}}</p>
                        <p>{{$user_approved->email}}</p>
                    </div>
                @endforeach
            </div>

            <div id="arrow-approved" class="hidden absolute bottom-1 left-1/2 transform -translate-x-1/2 text-white animate-bounce">
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
        });
    </script>
</x-app-layout>
