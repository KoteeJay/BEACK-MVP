@extends('layouts.app')
@section('content')
@livewire('search-box')
<x-sidebar />
<main id="main" class="main">

    <section class="section dashboard">
        <div class="row">
            <div class=" main-page col-lg-8">
             
                <div class="container mt-5">
                                    
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                
                    <form action="{{ route('contact.send') }}" method="POST" class="max-w-lg mx-auto w-full bg-slate-900/60 backdrop-blur-lg rounded-2xl shadow-lg border border-slate-700 p-6 space-y-5">
                        @csrf
                        <div>
                            <h3 class="text-center text-white">Contact Us</h3>
                        </div>
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-200 mb-1">Name</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                required 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                placeholder="Enter your name"
                            />
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-200 mb-1">Email</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                required 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                placeholder="you@example.com"
                            />
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-200 mb-1">Message</label>
                            <textarea 
                                id="message" 
                                name="message" 
                                rows="5" 
                                required 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 resize-none"
                                placeholder="Write your message here..."
                            ></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button 
                                type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-lg shadow-sm transition duration-200"
                            >
                                Send Message
                            </button>
                        </div>
                    </form>

                </div>
            </div>
            <!-- End Left side columns -->
            <!-- Right side columns -->
            <div class="col-lg-4">
                <!-- Available -->
                
                <!-- End Available -->
            </div>
            <!-- End Right side columns -->
        </div>
    </section>
</main>
@endsection