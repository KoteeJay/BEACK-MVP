@extends('layouts.app')

@section('title', "Posts by {$user->name}")

@section('content')
<main id="main" class="main mt-4">

    <section class="section dashboard">
        <div class="row">
            <div class=" main-page col-lg-8">
                <div class="row">
                    <div class=" col-md-12">
                        @forelse($posts as $post)
                            <x-posts.post-card :post="$post" />
                            @empty
                            <div class="p-6 mt-7">
                               <div class="p-6 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded text-center mt-7">
                                No posts found for {{ $user->name }}.
                                </div>
                            </div>
                        @endforelse
                        
                    </div>
                </div>
            </div>
            <!-- End Left side columns -->
            <!-- Right side columns -->
            <div class="col-lg-4 mt-5">
                <!-- Available -->
                <x-available />
                <!-- End Available -->
            </div>
            <!-- End Right side columns -->
        </div>
    </section>
</main>

@endsection
