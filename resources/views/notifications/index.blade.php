@extends('layouts.app')
@section('title', 'Notifications')
@section('content')
<div class="container mx-auto" style="margin-top:100px;">
    <h2 class="text-2xl text-white mb-4 mt-5">Notifications</h2>

    <div class="bg-slate-800 rounded-lg p-4 mt-2">
        @forelse($notifications as $notification)
            <div class="border-b border-slate-700 py-3">
                <div class="text-sm text-slate-100">{{ $notification->data['commenter_name'] ?? 'Someone' }} commented</div>
                <div class="text-xs text-slate-400">{{ Illuminate\Support\Str::limit($notification->data['comment_body'] ?? '', 200) }}</div>
                <div class="text-xs text-slate-500">{{ $notification->created_at->diffForHumans() }}</div>
            </div>
            <a href="{{ route('posts.show', optional($notification->data['post_id']) ? App\Models\Post::find($notification->data['post_id'])->slug : '#') }}">View</a>
        @empty
            <div class="text-slate-400">No notifications yet.</div>
        @endforelse

        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection