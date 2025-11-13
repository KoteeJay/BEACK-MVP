 <!-- Sidebar -->
        <aside id="sidebar" {{ $attributes->merge(['class' =>'sidebar lg:w-1/4 border-r border-indigo-300 bg-slate-900 text-gray-100']) }}>
            <div class="fixed mt-5 ml-5">
                <div class="my-5">
                    
                </div>

                <div class="available mt-6 px-4">
                    <a class="flex items-center gap-2 px-4 py-2 hover:bg-blue-800 rounded" href="{{ route('home.index') }}">
                        <i class="fa-regular fa-house"></i>
                        <span>Home</span>
                    </a>  
                    <div class="hidden md:block mt-5">
                        <a href="{{ route('scan.index') }}" class="bg-blue-800 text-text font-semibold px-6 py-2 rounded-lg inline-block  active:bg-blue-700 active:border-blue-700 transition duration-200 ease-in-out">
                            Scan link
                            <i class="fa-solid fa-link"></i>

                        </a>
                    </div>
                    <div class="card-body bg-slate-800 p-4 rounded shadow mt-5">
                        <h5 class="text-lg font-semibold text-white">Available professionals <span class="text-sm text-gray-400"><br>| Coming soon</span></h5>
                        <a href="{{ route('contact') }}" class="mt-2 inline-block bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded transition">Contact Us</a>
                    </div>
                     {{$slot}}

                    @auth
                        @if (auth()->user()->user_type === 'super_admin')
                            <li class="nav-item">
                                <a class="flex items-center gap-2 px-4 py-2 hover:bg-blue-700 rounded" href="{{ route('admin.dashboard') }}">
                                    <i class="fa-solid fa-users"></i>
                                    <span>User Management</span>
                                </a>
                            </li>
                        @endif
                    @endauth
                </div>
            </div>   
        </aside>
        <!-- End Sidebar -->