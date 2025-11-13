@section('title', 'Profile')
@extends('layouts.app')

@section('content')

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

<main class="flex-1 p-8 md:p-12 lg:p-16 dark:bg-gray-900 min-h-screen transition duration-300 overflow-y-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Profile</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Manage your profile information and preferences</p>
    </div>

    <section class="grid md:grid-cols-3 gap-2">
        <!-- Profile Sidebar -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md text-center transition duration-300">
            <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('default-profile.png') }}"
                alt="{{ $user->name }}"
                class="w-28 h-28 rounded-full object-cover mx-auto border-4 border-indigo-500 shadow-md">

            <h2 class="mt-4 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</h2>
            <p class="text-indigo-400 text-sm">{{ $user->specialization ?? 'No specialization yet' }}</p>

            <div class="flex justify-center space-x-4 mt-4 text-gray-500 dark:text-gray-400">
                <a href="#"><i class="fa-brands fa-twitter hover:text-blue-400"></i></a>
                <a href="#"><i class="fa-brands fa-facebook hover:text-blue-600"></i></a>
                <a href="#"><i class="fa-brands fa-instagram hover:text-pink-500"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin hover:text-blue-700"></i></a>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="md:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md transition duration-300">
            <div class="flex border-b border-gray-200 dark:border-gray-300 mb-4">
                <button id="tab-overview" class="tab-btn border-b-2 border-indigo-500 text-indigo-500 px-4 py-2 font-medium">
                    Overview
                </button>
                <button id="tab-edit" class="tab-btn border-b-2 border-transparent text-gray-500 dark:text-gray-400 px-4 py-2 font-medium hover:text-indigo-400">
                    Edit Profile
                </button>
            </div>

            <!-- Overview -->
            <div id="overview" class="tab-content">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3">About</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">{{ $user->about ?? 'No bio added yet.' }}</p>

                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3">Profile Details</h3>
                <div class="space-y-3 text-gray-700 dark:text-gray-300">
                    <p><span class="font-semibold">Full Name:</span> {{ $user->name }}</p>
                    <p><span class="font-semibold">Company:</span> {{ $user->company }}</p>
                    <p><span class="font-semibold">Specialization:</span> {{ $user->specialization }}</p>
                    <p><span class="font-semibold">Country:</span> {{ $user->country }}</p>
                    <p><span class="font-semibold">Phone:</span> {{ $user->phone }}</p>
                    <p><span class="font-semibold">Email:</span> {{ $user->email }}</p>
                </div>
            </div>

            <!-- Edit Profile -->
            <div id="edit" class="tab-content hidden">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="upload-form" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Profile Image</label>
                        <div class="mt-2 flex items-center space-x-4">
                            <img id="profileImagePreviewEdit"
                                src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('default-profile.png') }}"
                                alt="Profile"
                                class="w-14 h-14 rounded-full object-cover">
                            <input type="file" id="upload-file" name="photo" accept="image/*" onchange="previewImage(event)"
                                class="text-sm text-gray-500 dark:text-gray-400">
                        </div>
                        <img id="imagePreview" class="hidden mt-3 rounded-lg w-32 h-32 object-cover border border-gray-300 dark:border-gray-600">
                        @error('photo')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-profile-input label="Full Name" name="name" value="{{ $user->name }}" />
                        <x-profile-input label="Email" name="email" type="email" value="{{ $user->email }}" />
                        <x-profile-input label="Company" name="company" value="{{ $user->company }}" />
                        <x-profile-input label="Specialization" name="specialization" value="{{ $user->specialization }}" />
                        <x-profile-input label="Phone" name="phone" value="{{ $user->phone }}" />
                        <x-profile-input label="Country" name="country" value="{{ $user->country }}" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">About</label>
                        <textarea name="about" rows="3"
                            class="w-full mt-1 p-2 border border-gray-300 dark:border-gray-600 rounded-md bg-transparent text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500">{{ $user->about }}</textarea>
                    </div>

                    <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md transition">
                        Save Changes
                    </button>
                </form>
            </div>
        </div>
    </section>
</main>
</div>
@endsection

@push('scripts')
<script>
    // ✅ Tab Switching
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(btn => btn.classList.remove('border-indigo-500', 'text-indigo-500'));
            contents.forEach(c => c.classList.add('hidden'));
            tab.classList.add('border-indigo-500', 'text-indigo-500');
            document.getElementById(tab.id === 'tab-overview' ? 'overview' : 'edit').classList.remove('hidden');
        });
    });

    // ✅ Image Preview
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        const oldImg = document.getElementById('profileImagePreviewEdit');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                oldImg.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // ✅ File Size Validation
    document.getElementById('upload-form').addEventListener('submit', e => {
        const file = document.getElementById('upload-file').files[0];
        if (file && file.size > 2 * 1024 * 1024) {
            e.preventDefault();
            alert('The image size must not exceed 2 MB.');
        }
    });
</script>
@endpush
