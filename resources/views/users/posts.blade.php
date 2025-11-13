@extends('layouts.app')

@section('title', "Posts by {$user->name}")

@section('content')

<div class="flex min-h-screen space-y-10">

    <!-- Sidebar -->
    <!-- Sidebar -->
        <aside id="sidebar" class ="sidebar lg:w-1/4 border-r border-indigo-300 bg-slate-900 text-gray-100">
            <div class="fixed mt-5">
                <div class="my-5 ml-5">
                   <br> <br> <br>
                </div>

                <div class="available mt-6 px-4">
                    <a class="flex items-center gap-2 px-4 py-2 hover:bg-blue-00 rounded" href="{{ route('home.index') }}">
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
                        <a href="{{ route('contact') }}" class="mt-2 inline-block bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded transition">Contact Us</a>
                    </div>
                </div>
                
            </div>
            
        </aside>
        <!-- End Sidebar -->
   

    <!-- Main Content -->
    <main class="w-full sm:w-11/12 md:w-4/5 lg:w-2/3 xl:w-1/2 bg-slate-900 sm:p-6 mx-auto rounded-lg">
        <!-- Page content goes here -->
        @forelse($posts as $post)
            <x-posts.post-card :post="$post" />
            @empty
            <div class="p-6 mt-7">
                <div class="p-6 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded text-center mt-7">
                No posts found for {{ $user->name }}.
                </div>
            </div>
        @endforelse            
            
    </main>

@endsection
