<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('home.index') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('assets/img/logo.png') }}"  alt="logo"> 
            <span class="d-none d-lg-block" style="color: #0099ff; margin: -8px; padding-top: 5px;">eack</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- End Logo -->

    <livewire:search-box />
    <!-- End Search Bar -->

    <nav class="header-nav ms-auto">
        
    @auth
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li>
            <!-- End Search Icon-->

            <!-- Notification Bell -->
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-icon position-relative me-3" href="#" id="notifDropdownTrigger" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell" style="font-size: 1.5rem; color: white;"></i>
                    @php $unreadCount = auth()->user()->unreadNotifications->count() ?? 0; @endphp
                    @if($unreadCount > 0)
                        <span id="notif-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.7rem;">{{ $unreadCount }}</span>
                    @endif
                </a>

                <ul id="notifDropdown" class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="width: 320px;">
                    <li class="dropdown-header px-3 py-2 d-flex justify-content-between align-items-center">
                        <strong>Notifications</strong>
                        <a href="#" id="mark-all-read" class="text-sm text-muted">Mark all read</a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <div id="notif-list" style="max-height: 300px; overflow:auto;">
                        @foreach(auth()->user()->unreadNotifications()->latest()->limit(10)->get() as $notification)
                            <li>
                                <a href="{{ route('posts.show', optional($notification->data['post_id']) ? App\Models\Post::find($notification->data['post_id'])->slug : '#') }}" class="dropdown-item d-flex align-items-start">
                                    <div class="me-2">
                                        <i class="bi bi-chat-left-text"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium">{{ $notification->data['commenter_name'] ?? 'Someone' }}</div>
                                        <div class="text-xs text-muted">Commented: {{ Str::limit($notification->data['comment_body'] ?? '', 60) }}</div>
                                        <div class="text-xs text-muted">{{ $notification->created_at->diffForHumans() }}</div>
                                    </div>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                        @endforeach
                        @if(auth()->user()->unreadNotifications->count() === 0)
                            <li class="px-3 py-2 text-sm text-muted">No new notifications.</li>
                        @endif
                    </div>
                    <li><hr class="dropdown-divider"></li>
                    <li class="px-3 py-2 text-center"><a href="{{ route('notifications.index') }}">View all</a></li>
                </ul>

                <!-- End Notification Dropdown -->

            </li> 
            
                <!-- Profile -->
                <a class="nav-link nav-profile d-flex align-items-center pe-0" style="margin-right: 20px;" href="#" data-bs-toggle="dropdown">
                    <img src="{{ auth()->user()->profile_photo_path ? asset('storage/' . auth()->user()->profile_photo_path) : asset('assets/img/profile-photo.jpg') }}" class="rounded-circle">


                    <span class="d-none d-md-block dropdown-toggle ps-2 text-white">    {{ auth()->user()->name }}
                    </span>
                </a>
                <!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                   
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    @auth
                        @if(auth()->user()->user_type !== 'user')
                            <li>
                                <a href="{{ route('dashboard') }}" class="dropdown-item d-flex align-items-center">
                                    <i class="bi bi-person"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                        @endif
                    @endauth
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none"> @csrf</form>
                        <a class="dropdown-item d-flex align-items-center" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul>
                <!-- End Profile Dropdown Items -->
            @else
                    <a href="{{ route('dashboard')}}" class="btn btn-primary mx-4">Login</a>

            @endauth
                
                    <!-- End Profile Nav -->

        </ul>
    </nav>
    <!-- End Icons Navigation -->

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const trigger = document.getElementById('notifDropdownTrigger');
    const badge = document.getElementById('notif-badge');
    const markAll = document.getElementById('mark-all-read');
    const notifList = document.getElementById('notif-list');

    if (trigger) {
        trigger.addEventListener('shown.bs.dropdown', function () {
            // When dropdown opens, optionally we could mark individual notifications read on click.
            // For now, do nothing until user explicitly clicks "Mark all read" or visits items.
        });
    }

    if (markAll) {
        markAll.addEventListener('click', function (e) {
            e.preventDefault();
            fetch('{{ route('notifications.markAllRead') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            }).then(res => {
                if (res.ok) {
                    // Clear badge and update UI
                    if (badge) badge.remove();
                    notifList.innerHTML = '<div class="px-3 py-2 text-sm text-muted">No new notifications.</div>';
                }
            }).catch(console.error);
        });
    }
});
</script>
@endpush

</header>