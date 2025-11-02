@extends('layouts.app')
@section('content')
@livewire('search-box')
<x-sidebar />
<main id="main" class="main" style="margin: 0px;">

    <section class="section dashboard">
        <div class="row">
            <div class=" main-page col-lg-8">
                <div class="row">
                    <div class=" col-md-12">
                        @foreach ($Posts as $Post)     
                            <x-posts.post-card :post="$Post" />
                            <!-- Comment Section -->
                            <div class="comments">
                                <h4>Comments</h4>
                                @foreach ($Post->comments as $comment)
                                    <div class="comment">
                                        <p>{{ $comment->body }}</p>
                                        <small>By {{ $comment->user->name }} on {{ $comment->created_at->diffForHumans() }}</small>
                                    </div>
                                @endforeach
                                @auth
                                    <form action="{{ route('comments.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{ $Post->id }}">
                                        <textarea name="body" rows="3" required></textarea>
                                        <button type="submit">Add Comment</button>
                                    </form>
                                @endauth
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
    </section>
</main>
@endsection