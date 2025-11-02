@extends('layouts.app')
@section('content')
@livewire('search-box')
<x-sidebar />

<main id="main" class="main">

    <h5>Search Results for "{{ $query }}"</h5>

    @if ($posts->isEmpty())
        <p>No posts found.</p>
    @else
        <table class="table table-striped table-hover">
            
            <tbody>
                @foreach ($posts as $post)
                <tr>
                    <td>
                        <img src="{{ asset($post->image) }}" alt="Post Image" class="img-thumbnail" style="width: 50px; height: 50px;">
                    </td>
                    <td>
                        <a href="{{ route('search.show', $post->id) }}">
                            {{ Str::limit($post->body, 50) }}
                        </a>
                    </td>
                   
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $posts->links() }}
        </div>
    @endif

</main>
@endsection