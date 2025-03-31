<div class="relative inline-block text-left">
    <!-- Notification Icon -->
    <div>
        <button
            type="button"
            class="flex items-center p-2 text-gray-500 hover:text-gray-600 focus:outline-none"
            id="notification-button"
            aria-haspopup="true"
            aria-expanded="true"
            onclick="toggleDropdown()"
        >
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
            </svg>
            @if(auth()->user()->unreadNotifications->count())
                <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-600"></span>
            @endif
        </button>
    </div>

    <!-- Dropdown Panel -->
    <div id="notification-dropdown" class="absolute right-0 z-10 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden" role="menu" aria-orientation="vertical" aria-labelledby="notification-button">
        <div class="py-1" role="none">
            @foreach (auth()->user()->notifications as $notification)
                {{-- Iterando en todas las notificaciones del usuario del usuario,  --}}
                @if (! $notification->read_at)
                <div class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ ! $notification->read_at ? 'bg-gray-200' : '' }}">
                    <span>{{ $notification->data['message'] }}</span>
                    <small class="text-gray-500">{{ $notification->created_at->diffForHumans() }}</small>
                </div>
                <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="flex items-center justify-end pr-2">
                    @csrf
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <button type="submit" class="text-xs text-gray-500 hover:text-gray-700 focus:outline-none">
                        Marcar como leído
                    </button>
                </form>
                @endif
            @endforeach
        </div>
        <div class="border-t border-gray-200">
            <div class="px-4 py-2 text-sm text-gray-500 text-center">
                {{-- Opcional: crear una página que muestre todas las notificaciones --}}
                <a href="#" class="hover:text-blue-600">Ver todo</a>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('notification-dropdown');
        dropdown.classList.toggle('hidden');
    }

    // Close dropdown if clicked outside
    // todo arreglar codigo:
    window.onclick = function(event) {
        if (!event.target.matches('#notification-button')) {
            const dropdowns = document.getElementsByClassName("dropdown-content");
            for (let i = 0; i < dropdowns.length; i++) {
                const openDropdown = dropdowns[i];
                if (!openDropdown.classList.contains('hidden')) {
                    openDropdown.classList.add('hidden');
                }
            }
        }
    }
</script>