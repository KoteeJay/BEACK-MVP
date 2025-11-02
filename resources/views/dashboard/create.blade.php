@section('title', 'New post')
@extends('layouts.app')
@section('content')
<x-sidebar />
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Add Post</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Post</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class=" main-page col-lg">
                <div class="row">
                    <div class="col-md-9">
                        @if (session('status'))
                        <div class="alert alert-success"> {{session('status')}} </div>
                            
                        @endif
                            <div class="w-full mx-auto bg-white dark:bg-gray-900 rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200 dark:border-gray-700 transition-all mt-5">
                                <form action="{{ route('dashboard.store') }}" method="POST" id="upload-form" enctype="multipart/form-data" class="space-y-4">
                                    @csrf

                                    <!-- Heading -->
                                    <div class="flex items-center space-x-3">
                                       
                                        <h2 class="text-blue-700 text-center dark:text-gray-100 font-semibold text-lg">Create a Post</h2>
                                    </div>

                                    <!-- Textarea -->
                                    <div>
                                        <textarea 
                                            name="body" 
                                            id="post-content" 
                                            maxlength="2000"
                                            placeholder="What's on your mind today?" 
                                            class="w-full bg-gray-50 dark:bg-gray-200 text-gray-200 dark:text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:outline-none rounded-xl p-4 resize-none transition"
                                            rows="4"
                                            oninput="updateCharCount()"
                                        ></textarea>

                                        <div class="flex justify-between items-center mt-1 text-sm">
                                            <p id="char-count" class="text-gray-400">0 / 2000</p>
                                            <p id="text-error" class="text-red-500 hidden"></p>
                                        </div>

                                        @error('body')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Image Upload -->
                                    <div class="relative flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <label 
                                                for="upload-file" 
                                                class="cursor-pointer flex items-center space-x-2 text-blue-600 hover:text-blue-800 transition"
                                            >
                                                <i class="bi bi-image text-xl"></i>
                                                <span class="text-sm font-medium">Add Image</span>
                                            </label>
                                            <input 
                                                type="file" 
                                                id="upload-file" 
                                                name="image" 
                                                accept="image/*" 
                                                class="hidden" 
                                                onchange="previewImage(event)"
                                            >
                                        </div>

                                        <button 
                                            type="submit" 
                                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-xl shadow-sm transition"
                                        >
                                            Post
                                        </button>
                                    </div>

                                    <!-- Image Preview -->
                                    <div class="mt-3 relative w-full max-h-64">
                                        <!-- Remove Image Button -->
                                        <button 
                                            type="button" 
                                            id="removeImageBtn"
                                            class="hidden absolute top-2 right-2 bg-black/60 hover:bg-black/80 text-white rounded-full p-1.5 transition"
                                            onclick="removeImage()"
                                        >
                                            <i class="bi bi-x-lg text-xs"></i>
                                        </button>

                                        <img 
                                            id="imagePreview" 
                                            class="hidden w-full max-h-72 object-cover rounded-xl shadow-sm transition-opacity duration-500 opacity-0"
                                            alt="Image Preview"
                                        >

                                        <p id="image-error" class="text-red-500 text-sm hidden mt-1"></p>

                                        @error('image')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </form>
                            </div>



                    </div>

                </div>
            </div>
            <!-- End Left side columns -->

        </div>
    </section>

   
</main>
<!-- End #main -->
@endsection

<script>
    function updateCharCount() {
        const textarea = document.getElementById('post-content');
        const charCount = document.getElementById('char-count');
        const currentLength = textarea.value.length;
        charCount.textContent = `${currentLength} / 2000`;
        charCount.style.color = currentLength >= 1950 ? 'red' : '#9CA3AF';
    }

    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');
        const removeBtn = document.getElementById('removeImageBtn');

        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                // Remove hidden and make visible using Tailwind opacity classes
                preview.classList.remove('hidden', 'opacity-0');
                preview.classList.add('block', 'opacity-100');
                removeBtn.classList.remove('hidden');
                // ensure the browser applies the class changes so transitions run
                setTimeout(() => {
                    preview.style.opacity = '1';
                }, 10);
            };
            reader.readAsDataURL(file);
        }
    }

    function removeImage() {
        const preview = document.getElementById('imagePreview');
        const removeBtn = document.getElementById('removeImageBtn');
        const input = document.getElementById('upload-file');

        preview.src = '';
        // Hide preview and reset opacity classes
        preview.classList.add('hidden');
        preview.classList.remove('opacity-100');
        preview.classList.add('opacity-0');
        removeBtn.classList.add('hidden');
        input.value = '';
    }

    document.getElementById('upload-form').addEventListener('submit', e => {
        const text = document.getElementById('post-content').value.trim();
        const image = document.getElementById('upload-file').files[0];
        const textError = document.getElementById('text-error');
        const imageError = document.getElementById('image-error');
        let hasError = false;

        if (!text) {
            textError.textContent = 'Please enter some text.';
            textError.classList.remove('hidden');
            hasError = true;
        } else textError.classList.add('hidden');

        if (!image) {
            imageError.textContent = 'Please upload an image.';
            imageError.classList.remove('hidden');
            hasError = true;
        } else imageError.classList.add('hidden');

        if (image && image.size > 2 * 1024 * 1024) {
            imageError.textContent = 'Image must not exceed 2 MB.';
            imageError.classList.remove('hidden');
            hasError = true;
        }

        if (hasError) e.preventDefault();
    });
</script>



{{-- <script>
    function updateCharCount() {
        var textarea = document.getElementById("post-content");
        var charCount = document.getElementById("char-count");
        
        var maxLength = 800; // Max characters
        var currentLength = textarea.value.length;
        
        // Update the character count display
        charCount.textContent = currentLength + " / " + maxLength + " characters";
        
        // Change color when close to the limit
        if (currentLength >= maxLength - 50) {
            charCount.style.color = "red"; // Warning color
        } else {
            charCount.style.color = "black"; // Default color
        }
    }
    </script> --}}
    