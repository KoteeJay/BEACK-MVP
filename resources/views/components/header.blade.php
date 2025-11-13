<header class="fixed top-0 left-0 w-full bg-slate-900 text-gray-100 shadow z-50">
    <div class="max-w-7xl mx-auto grid grid-cols-3 items-center px-4 py-3 gap-4">

        <!-- LEFT: Logo -->
        <div class="flex items-center gap-3">
            <a href="{{ route('home.index') }}" class="flex items-center gap-2">
                <img src="{{ asset('assets/img/logo.png') }}" alt="logo" class="h-8 w-8">
                <span class="hidden lg:block text-blue-500 font-bold text-xl">eack</span>
            </a>
        </div>

        <!-- CENTER: Search Bar -->
        <div class="flex justify-center">
            <div class="w-full max-w-md hidden md:block">
                <livewire:search-box />
            </div>
        </div>

        <!-- RIGHT: Notifications, Profile or Login -->
        <div class="flex items-center justify-end gap-2">
            @auth
                <!-- Notification -->
                <div class="relative">
                   @php $unreadCount = auth()->user()->unreadNotifications->count() ?? 0; @endphp

            <button id="notifDropdownTrigger" class="relative p-2 rounded">
                <i class="fa-regular fa-bell text-xl"></i>
                @if($unreadCount > 0)
                    <span id="notif-badge"
                        class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full px-1.5 py-0.5">
                        {{ $unreadCount }}
                    </span>
                @endif
            </button>


                    <div id="notifDropdown"
                         class="hidden absolute right-0 mt-2 w-80 bg-slate-800 rounded shadow-lg overflow-hidden">
                        <div class="px-4 py-2 flex justify-between items-center border-b border-slate-700">
                            <strong>Notifications</strong>
                            <button id="mark-all-read" class="text-xs text-gray-400 hover:underline">Mark all read</button>
                        </div>
                        <div id="notif-list" class="max-h-72 overflow-y-auto">
                            @foreach(auth()->user()->unreadNotifications()->latest()->limit(10)->get() as $notification)
                                <a href="{{ route('posts.show', optional($notification->data['post_id']) ? App\Models\Post::find($notification->data['post_id'])->slug : '#') }}"
                                   class="block px-4 py-2 hover:bg-gray-700">
                                    <div class="text-sm font-medium">{{ $notification->data['commenter_name'] ?? 'Someone' }}</div>
                                    <div class="text-xs text-gray-400 truncate">Commented: {{ Str::limit($notification->data['comment_body'] ?? '', 60) }}</div>
                                    <div class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                                </a>
                            @endforeach
                            @if(auth()->user()->unreadNotifications->count() === 0)
                                <div class="px-4 py-2 text-sm text-gray-400">No new notifications.</div>
                            @endif
                        </div>
                        <div class="border-t border-slate-700 text-center py-2">
                            <a href="{{ route('notifications.index') }}" class="text-sm text-blue-400 hover:underline">View all</a>
                        </div>
                    </div>
                </div>

                <!-- Profile -->
                <div class="relative hidden md:block">
                    <button class="flex items-center gap-2 rounded hover:bg-gray-800 p-2" id="profileDropdownTrigger">
                        <img src="{{ auth()->user()->profile_photo_path ? asset('storage/' . auth()->user()->profile_photo_path) : asset('assets/img/profile-photo.jpg') }}"
                             class="h-8 w-8 rounded-full">
                        <span class="hidden md:block text-white">{{ auth()->user()->name }}</span>
                        <i class="bi bi-chevron-down hidden md:block text-gray-400"></i>
                    </button>

                    <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-slate-800 rounded shadow-lg overflow-hidden">
                        @if(auth()->user()->user_type !== 'user')
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700 text-sm">Dashboard</a>
                        @endif
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                        <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-700">Sign Out</button>
                    </div>
                </div>
            @else
                <a href="{{ route('dashboard')}}" class="hidden md:block bg-blue-600 hover:bg-blue-500 px-4 py-2 rounded text-white">
                    Login
                </a>
            @endauth
            <!-- Hamburger menu for small screens -->
            <button id="mobileMenuBtn" class="md:hidden p-2 rounded hover:bg-slate-800">
               <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </div>

    <!-- MOBILE SLIDING SIDEBAR -->
    <div id="mobileSidebar" class="fixed border border-blue-400 top-0 right-0 h-full w-64 bg-slate-900 text-white shadow-lg transform translate-x-full transition-transform duration-300 z-50 md:hidden">
        <button id="closeSidebar" class="p-2 text-white float-right">
            <i class="fa-solid fa-x"></i>
        </button>
        
       <div class="fixed mt-5 ml-5">
                <div class="my-5">
                    
                </div>

                <div class="available mt-6 px-4">
                    <a class="flex items-center gap-2 px-4 py-2 hover:bg-blue-800 rounded" href="{{ route('home.index') }}">
                        <i class="fa-regular fa-house"></i>
                        <span>Home</span>
                    </a>  
                    <div class="mt-5">
                        <a href="{{ route('scan.index') }}" class="bg-blue-800 text-text font-semibold px-6 py-2 rounded-lg inline-block  active:bg-blue-700 active:border-blue-700 transition duration-200 ease-in-out">
                            Scan link
                            <i class="fa-solid fa-link"></i>
                        </a>
                    </div>
                    
                     {{$slot}}

                    @auth
                        @if (auth()->user()->user_type === 'super_admin')
                            <li class="nav-item">
                                <a class="flex items-center gap-2 px-4 py-2 hover:bg-blue-700 rounded" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-people"></i>
                                    <span>User Management</span>
                                </a>
                            </li>
                        @endif
                        @else
                            <div class="mt-5">
                                <a href="{{ route('dashboard')}}" class=" bg-blue-600 hover:bg-blue-500 px-4 py-2 rounded text-white">
                                Login
                                </a>
                            </div>
                    @endauth
                  
                   <div class="card-body bg-slate-800 p-4 rounded shadow mt-5">
                        <h5 class="text-lg font-semibold text-white">Available professionals <span class="text-sm text-gray-400"><br>| Coming soon</span></h5>
                        <a href="{{ route('contact') }}" class="mt-2 inline-block bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded transition">Contact Us</a>
                    </div>
                </div>
            </div>  
        
    </div>

</header>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Notification dropdown toggle
    const notifBtn = document.getElementById('notifDropdownTrigger');
    const notifDropdown = document.getElementById('notifDropdown');
    notifBtn?.addEventListener('click', () => notifDropdown.classList.toggle('hidden'));

    // Profile dropdown toggle
    const profileBtn = document.getElementById('profileDropdownTrigger');
    const profileDropdown = document.getElementById('profileDropdown');
    profileBtn?.addEventListener('click', () => profileDropdown.classList.toggle('hidden'));

    // Mark all notifications as read
    const markAll = document.getElementById('mark-all-read');
    const notifBadge = document.getElementById('notif-badge');
    const notifList = document.getElementById('notif-list');
    markAll?.addEventListener('click', function(e){
        e.preventDefault();
        fetch('{{ route('notifications.markAllRead') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        }).then(res => {
            if(res.ok){
                notifBadge?.remove();
                notifList.innerHTML = '<div class="px-4 py-2 text-sm text-gray-400">No new notifications.</div>';
            }
        }).catch(console.error);
    });

    // Mobile sidebar toggle
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const closeSidebar = document.getElementById('closeSidebar');

    mobileBtn?.addEventListener('click', () => {
        mobileSidebar.classList.remove('translate-x-full');
        mobileSidebar.classList.add('translate-x-0');
    });

    closeSidebar?.addEventListener('click', () => {
        mobileSidebar.classList.add('translate-x-full');
        mobileSidebar.classList.remove('translate-x-0');
    });
});
</script>
@endpush