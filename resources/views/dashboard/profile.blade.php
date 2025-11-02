@section('title', 'Profile')
@extends('layouts.app')
@section('content')
<x-sidebar>
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('home.index')}}">
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
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=" {{ url('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('default-profile.png') }}" 
                        alt="{{ $user->name }}" 
                        style="width: 100px; height: 100px; border-radius: 50%;">
                                           <h2>{{ $user->name }}  </h2>
                        <h3>{{ $user->specialization }}</h3>
                        <div class="social-links mt-2">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                
                
            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                            </li>
    
                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">About</h5>
                                <p class="small fst-italic">{{ $user->about }}</p>

                                <h5 class="card-title">Profile Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->name }}  </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Company</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->company }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Specialization</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->specialization }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Country</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->country }}</div>
                                </div>

                                
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Phone</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->phone }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ auth()->user()->email }}  </div>
                                </div>

                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                <!-- Profile Edit Form -->
                                <form action="{{ route('profile.update') }}" method="POST" id="upload-form" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row mb-3">
                                        
                                        
                                        
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                        <div class="col-md-8 col-lg-9">
                                            <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('default-profile.png') }}" 
                                            alt="{{ $user->name }}" 
                                            style="width: 50px; height: 50px;" id="profileImagePreviewEdit">                                            
                                            <img id="imagePreview" style="display: none; max-width: 300px; margin-top: 10px; border-radius: 8px">
                                                <div class="pt-2">
                                                    <input type="file" id="upload-file" name="photo" class="upload-input mx-5" accept="image/*" onchange="previewImage(event)">
                                                    
                                                    <label for="upload-file" class="btn btn-primary text-white">
                                                        <i class="bi bi-upload"></i> Choose File
                                                    </label>
                                                    
                                                    @error('photo')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                           
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="name" type="text" class="form-control" id="fullName" value="{{ $user->name }}">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="email" type="email" class="form-control" id="email" value="{{ $user->email }}">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                                        <div class="col-md-8 col-lg-9">
                                            <textarea name="about" class="form-control" id="about">{{ $user->about }}</textarea>
                                            @error('about')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="company" class="col-md-4 col-lg-3 col-form-label">Company</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="company" type="text" class="form-control" id="company" value="{{ $user->company }}">
                                            @error('company')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="specialization" class="col-md-4 col-lg-3 col-form-label">Specialization</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="specialization" type="text" class="form-control" id="specialization" value="{{ $user->specialization }}">
                                            @error('specialization')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="phone" type="text" class="form-control" id="phone" value="{{ $user->phone }}">
                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="country" type="text" class="form-control" id="country" value="{{ $user->country }}">
                                            @error('country')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->
                     
                                <!-- End Profile Edit Form -->

                            </div>

                        </div>
                        <!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main>



@endsection

@push('scripts')
<script>
  

    function previewImage(event) {
        const imageInput = event.target;
        const preview = document.getElementById('imagePreview');

        if (imageInput.files && imageInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                document.getElementById('profileImagePreviewEdit').style.display = 'none';
      
            };

            reader.readAsDataURL(imageInput.files[0]);
        }
        document.getElementById('upload-form').addEventListener('submit', function (e) {
            const image = document.getElementById('upload-file').files[0];
            const maxSize = 2040 * 1024; // 2040 KB in bytes

            if (image && image.size > maxSize) {
                e.preventDefault();
                alert('The image size must not exceed 2 MB.');
            }
        });
    }
</script>
@endpush