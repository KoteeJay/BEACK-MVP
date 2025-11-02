<aside id="sidebar" class="sidebar border-r border-r-indigo-300">

    <ul class="sidebar-nav mt-5" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ route('home.index')}}">
                <i class="bi bi-house-door-fill"></i>
                <span>Home</span>
            </a>
        </li>
        
        <!-- End Home Nav -->
       {{$slot }}
       
        @auth
        @if (auth()->user()->user_type === 'super_admin')
            <li class="nav-item collapsed">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-people"></i>
                    <span>User Management</span>
                </a>
            </li>
        @endif
    @endauth
    </ul>
    <div class="available">
        <div class="card-body">
            
            <h5 class="card-title">Available professionals <span> <br>| Coming soon</span></h5>

            
            <a href="{{ route('contact') }}" class="btn btn-primary mt-2">Contact Us</a>
        </div>
    </div>
</aside>