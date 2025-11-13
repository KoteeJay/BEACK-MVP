@extends('layouts.app')
@section('content')
@livewire('search-box')

<div class="flex min-h-screen space-y-10">

   <!-- Sidebar -->
    <aside id="sidebar"class="sidebar lg:w-1/4 border-r border-indigo-300 bg-slate-900 text-gray-100 space-y-6">
            <h1> <br> <br> <br></h1>
            <ul class="space-y-10 pl-5 fixed">
                <li class="nav-item hidden md:block">
                    <a class="flex items-center gap-2 px-4 py-2 hover:bg-indigo-700 rounded" href="#">
                        <i class="fa fa-table-cells-large"></i>
                        <span>Overview</span>
                    </a>
                </li>
                <li class="nav-item hidden md:block">
                    <a class="flex items-center gap-2 px-4 py-2 hover:bg-indigo-700 rounded" href="{{ route('dashboard.create') }}">
                        <i class="fa fa-pen-to-square"></i>
                        <span>Create new post</span>
                    </a>
                </li>
                <li class="nav-item hidden md:block">
                    <a class="flex items-center gap-2 px-4 py-2 hover:bg-indigo-700 rounded" href="{{ route('dashboard.profile') }}">
                        <i class="fa fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>

                @auth
                    @if (auth()->user()->user_type === 'super_admin')
                        <li class="nav-item">
                            <a class="flex items-center gap-2 px-4 py-2 hover:bg-indigo-700 rounded" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-people"></i>
                                <span>User Management</span>
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>
    </aside>
    <!-- End Sidebar -->

    <!-- Main Content -->
    <main class="w-full sm:w-11/12 md:w-4/5 lg:w-2/3 xl:w-1/2 bg-slate-900 p-4 sm:p-6 mx-auto rounded-lg">

    <div class="pagetitle">
        <h1 class="text-gray-200 mt-5">Create a new post</h1>
        
    </div>

    <!-- Create Post Section -->
    <section class="section dashboard mt-6">
        <div class="flex justify-center w-full">
            <div class="w-full max-w-2xl">

                @if (session('status'))
                    <div class="mb-4 p-3 rounded-lg bg-green-600 text-white text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="bg-slate-800 rounded-2xl shadow-md p-6 border border-slate-700 transition">
                    <h2 class="text-xl font-semibold text-blue-400 mb-4 text-center">Create a Post</h2>

                    <form action="{{ route('dashboard.store') }}" method="POST" id="upload-form" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        <!-- Textarea -->
                        <div>
                            <textarea 
                                name="body" 
                                id="post-content" 
                                maxlength="2000"
                                placeholder="What's on your mind today?" 
                                class="w-full bg-slate-900 text-gray-100 placeholder-gray-400 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none rounded-xl p-4 resize-none transition"
                                rows="5"
                                oninput="updateCharCount()"
                            ></textarea>

                            <div class="flex justify-between items-center mt-2 text-sm">
                                <p id="char-count" class="text-gray-400">0 / 2000</p>
                                <p id="text-error" class="text-red-500 hidden"></p>
                            </div>

                            @error('body')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="flex items-center justify-between">
                            <label for="upload-file" class="cursor-pointer flex items-center gap-2 text-blue-500 hover:text-blue-400 transition">
                                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                <span class="font-medium text-sm">Add Image</span>
                                <input type="file" id="upload-file" name="image" accept="image/*" class="hidden" onchange="previewImage(event)">
                            </label>

                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-xl shadow transition">
                                Post
                            </button>
                        </div>

                        <!-- Image Preview -->
                        <div class="relative mt-3 w-full max-h-64">
                            <button type="button" id="removeImageBtn" class="hidden absolute top-2 right-2 bg-black/60 hover:bg-black/80 text-white rounded-full p-1.5 transition" onclick="removeImage()">
                                <i class="bi bi-x-lg text-xs"></i>
                            </button>

                            <img id="imagePreview" class="hidden w-full max-h-72 object-cover rounded-xl shadow-sm transition-opacity duration-500 opacity-0" alt="Image Preview">

                            <p id="image-error" class="text-red-500 text-sm hidden mt-1"></p>
                            @error('image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </section>
 <!-- Floating Action Button (Mobile Only) -->
        <div class="fixed bottom-6 right-6 z-50 md:hidden">
            <!-- Main FAB -->
            <button id="fab-btn" 
                class="bg-blue-600 hover:bg-blue-500 text-white w-14 h-14 rounded-full shadow-lg flex items-center justify-center text-2xl transition transform hover:scale-105">
                <i class="fa fa-plus"></i>
            </button>

            <!-- Hidden Action Buttons -->
            <div id="fab-actions" class="flex flex-col items-end space-y-3 mt-3 hidden">
                <!-- Create Post -->
                <a href="{{ route('dashboard') }}" 
                class="bg-blue-600 hover:bg-blue-500 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-md transition transform hover:scale-110">
                    <i class="fa fa-table-cells-large"></i>
                </a>
                <!-- Create Post -->
                <a href="{{ route('dashboard.create') }}" 
                class="bg-blue-600 hover:bg-blue-500 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-md transition transform hover:scale-110">
                    <i class="fa fa-pen-to-square text-lg"></i>
                </a>

                <!-- Profile -->
                <a href="{{ route('dashboard.profile') }}" 
                class="bg-blue-700 hover:bg-blue-600 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-md transition transform hover:scale-110">
                    <i class="fa fa-user text-lg"></i>
                </a>
            </div>
        </div>

    </main>

    <div class="flex-1"></div>
</div>


@push('scripts')
<script>
    // ✅ Update character and word count
    function updateCharCount() {
        const textarea = document.getElementById('post-content');
        const charCount = document.getElementById('char-count');

        const text = textarea.value.trim();
        const wordCount = text === '' ? 0 : text.split(/\s+/).length;

        charCount.textContent = `${wordCount} words / 2000`;

        // Color warning if nearing max
        charCount.style.color = text.length >= 1950 ? 'red' : '#9CA3AF';
    }

    // ✅ Preview uploaded image
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');
        const removeBtn = document.getElementById('removeImageBtn');

        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('hidden', 'opacity-0');
                preview.classList.add('block', 'opacity-100');
                removeBtn.classList.remove('hidden');

                // Trigger transition
                setTimeout(() => {
                    preview.style.opacity = '1';
                }, 10);
            };
            reader.readAsDataURL(file);
        }
    }

    // ✅ Remove selected image
    function removeImage() {
        const preview = document.getElementById('imagePreview');
        const removeBtn = document.getElementById('removeImageBtn');
        const input = document.getElementById('upload-file');

        preview.src = '';
        preview.classList.add('hidden');
        preview.classList.remove('opacity-100');
        preview.classList.add('opacity-0');
        removeBtn.classList.add('hidden');
        input.value = '';
    }

    // ✅ Form validation on submit
    document.getElementById('upload-form').addEventListener('submit', e => {
        const text = document.getElementById('post-content').value.trim();
        const image = document.getElementById('upload-file').files[0];
        const textError = document.getElementById('text-error');
        const imageError = document.getElementById('image-error');
        let hasError = false;

        // Text validation
        if (!text) {
            textError.textContent = 'Please enter some text.';
            textError.classList.remove('hidden');
            hasError = true;
        } else {
            textError.classList.add('hidden');
        }

        // Image validation (optional, remove if image not required)
        if (image) {
            if (image.size > 2 * 1024 * 1024) {
                imageError.textContent = 'Image must not exceed 2 MB.';
                imageError.classList.remove('hidden');
                hasError = true;
            } else {
                imageError.classList.add('hidden');
            }
        } else {
            imageError.classList.add('hidden');
        }

        if (hasError) e.preventDefault();
    });
    // Floating Action Button Toggle
    document.getElementById('fab-btn').addEventListener('click', () => {
        const actions = document.getElementById('fab-actions');
        actions.classList.toggle('hidden');
        actions.classList.toggle('animate-fadeIn');
    });
    </script>

    <style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
        animation: fadeIn 0.2s ease-out;
    }
    </style>
</script>

@endpush

@endsection
