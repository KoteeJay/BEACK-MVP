@section('title', 'Dashboard')
@extends('layouts.app')
@section('content')
<x-sidebar>

    
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('dashboard.create')}}">
            <i class="bi bi-grid"></i>
            <span>Post</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('dashboard.profile')}}">
            <i class="bi bi-grid"></i>
            <span>Profile</span>
        </a>
    </li>

    

    <!-- End Blank Page Nav -->
   
</x-sidebar>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>

        </nav>
    </div>
    <!-- Toast Container -->
    <div id="toast-message" class="toast" style="display: none;">
        <span id="toast-text"></span>
    </div>
    <!-- End Page Title -->
    <div class="max-w-5xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-6">User Management</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border border-gray-200 text-sm">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2 border">Name</th>
                    <th class="p-2 border">Email</th>
                    <th class="p-2 border">Posts</th>
                    <th class="p-2 border text-center">Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2">{{ $user->name }}</td>
                        <td class="p-2">{{ $user->email }}</td>
                        <td class="p-2 capitalize">
                            <a href="{{ route('users.posts', $user->id) }}" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
                            View Posts
                            </a>
                        </td>
                        <td class="p-2 text-center">
                            <form action="{{ route('admin.updateRole', $user) }}" method="POST" class="inline-flex items-center gap-2">
                                @csrf
                                @method('PUT')
                                <select name="user_type" class="border rounded p-1 text-sm">
                                    <option value="user" @selected($user->user_type == 'user')>User</option>
                                    <option value="prof" @selected($user->user_type == 'prof')>Professional</option>
                                </select>
                                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</main>
<!-- End #main -->
@if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var toast = document.getElementById("toast-message");
            var toastText = document.getElementById("toast-text");

            toastText.innerText = "{{ session('success') }}"; // Set message
            toast.style.display = "block"; // Show toast

            // Hide toast after 4 seconds
            setTimeout(function () {
                toast.style.display = "none";
            }, 8000);
        });
    </script>
@endif
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this post?');
    }
    
</script>

@endsection