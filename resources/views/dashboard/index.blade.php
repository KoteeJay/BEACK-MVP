@extends('layouts.app')
@section('content')
<x-sidebar />
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class=" main-page col-lg-">
              <h1>This is the dashboard</h1>
            </div>
            <!-- End Left side columns -->

        </div>
        {{-- <a href="{{ route('home.create') }} " class="btn btn-primary">Create new post</a> --}}
    </section>



</main>
<!-- End #main -->
@endsection