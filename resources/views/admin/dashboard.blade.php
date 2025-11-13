@section('title', 'Dashboard')
@extends('layouts.app')
@section('content')

<div class="flex">


<!-- Sidebar -->
        <aside id="sidebar"class="sidebar lg:w-1/4 border-r border-blue-300 bg-slate-900 text-gray-100 space-y-6">
            <h1> <br> <br> <br></h1>
            <ul class="space-y-10 pl-5 fixed">
                <li class="nav-item hidden md:block">
                    <a class="flex items-center gap-2 px-4 py-2 hover:bg-blue-700 rounded" href="{{ route('dashboard') }}">
                        <i class="fa fa-table-cells-large"></i>
                        <span>Overview</span>
                    </a>
                </li>
                <li class="nav-item hidden md:block">
                    <a class="flex items-center gap-2 px-4 py-2 hover:bg-blue-700 rounded" href="{{ route('dashboard.create') }}">
                        <i class="fa fa-pen-to-square"></i>
                        <span>Create new post</span>
                    </a>
                </li>
                <li class="nav-item hidden md:block">
                    <a class="flex items-center gap-2 px-4 py-2 hover:bg-blue-700 rounded" href="{{ route('dashboard.profile') }}">
                        <i class="fa fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>

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
            </ul>
</aside>
        <!-- End Sidebar -->
<main id="main" class="main bg-gray-50 dark:bg-gray-900 min-h-screen py-10 px-4 sm:px-6 lg:px-8 transition-colors duration-300">

    <!-- Page Title -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mt-10">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-2">User Management</h1>
            <nav class="text-sm text-gray-500 dark:text-gray-400">
                <ol class="list-reset flex items-center space-x-2">
                    <li>
                        <a href="{{ route('dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Dashboard</a>
                    </li>
                    <li>/</li>
                    <li class="text-gray-600 dark:text-gray-300">User Management</li>
                </ol>
            </nav>
        </div>

        <div class="mt-4 sm:mt-0">
            <a href="#"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-md transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Add User
            </a>
        </div>
    </div>

    <!-- Toast Message -->
    <div id="toast-message" class="hidden fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg text-sm z-50">
        <span id="toast-text"></span>
    </div>

    <!-- Card Container -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-all">
        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-700 text-green-800 dark:text-green-100 p-3 rounded-t-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="p-4">Name</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Posts</th>
                        <th class="p-4 text-center">Role</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="p-4 font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</td>
                            <td class="p-4 text-gray-600 dark:text-gray-300">{{ $user->email }}</td>
                            <td class="p-4">
                                <a href="{{ route('users.posts', $user->id) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-xs font-semibold shadow-sm transition">
                                    View Posts
                                </a>
                            </td>
                            <td class="p-4 text-center">
                                <form action="{{ route('admin.updateRole', $user) }}" method="POST" class="inline-flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="user_type"
                                            class="border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 rounded-md text-sm p-1 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="user" @selected($user->user_type == 'user')>User</option>
                                        <option value="prof" @selected($user->user_type == 'prof')>Professional</option>
                                    </select>
                                    <button type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-medium transition">
                                        Update
                                    </button>
                                </form>
                            </td>
                            <td class="p-4 text-right">
                                <div class="relative inline-block text-left">
                                    <button type="button"
                                            class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none"
                                            onclick="toggleDropdown({{ $user->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 dark:text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm0 5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm0 5a1.5 1.5 0 110 3 1.5 1.5 0 010-3z"/>
                                        </svg>
                                    </button>

                                    <div id="dropdown-{{ $user->id }}" class="hidden absolute right-0 mt-2 w-36 bg-white dark:bg-gray-800 rounded-lg shadow-lg z-50">
                                        <a href="" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">View Profile</a>
                                        <a href="" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">Edit</a>
                                        <form action="" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:text-red-400 dark:hover:bg-gray-700">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500 dark:text-gray-400">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</main>
</div>
<script>
    function toggleDropdown(id) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(drop => {
            if (drop.id !== `dropdown-${id}`) drop.classList.add('hidden');
        });
        document.getElementById(`dropdown-${id}`).classList.toggle('hidden');
    }

    window.addEventListener('click', (e) => {
        if (!e.target.closest('[id^="dropdown-"]') && !e.target.closest('button[onclick^="toggleDropdown"]')) {
            document.querySelectorAll('[id^="dropdown-"]').forEach(drop => drop.classList.add('hidden'));
        }
    });
</script>

@endsection