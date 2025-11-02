@section('title', 'Dashboard')
@extends('layouts.app')
@section('content')
<x-sidebar>

    
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('dashboard.create')}}">
            <i class="bi bi-journal"></i>
            <span>Post</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('dashboard.profile')}}">
            <i class="bi bi-person-badge"></i>
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
    <section class="section dashboard">
        <div class="w-100">
            <div class=" main-page col-lg-8">
                <div class="mt-5">
                    @if($posts->isEmpty())
                    <p>No posts yet. Start creating one!</p>
<br><br>
                    <a href="{{ route('dashboard.create') }}" class="btn btn-primary">Create Post</a>
                    @endif
                    @foreach ($posts as $post)     
                        <x-posts.post-card :post="$post">
                            <div class="dropdown" style="margin-left: 70px">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Edit
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('posts.edit', $post->id) }}">Edit post</a></li>
                                    <li> <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirmDelete()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">Delete Post</button>
                                    </form>
                                </li>
                                </ul>
                            </div>
                        </x-posts.post-card>
                    @endforeach

                </div>
            </div>
        </div>

    </section>

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