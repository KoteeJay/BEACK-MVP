@extends('layouts.app')
@section('content')
@livewire('search-box')
<x-sidebar />
<main id="main" class="main bg-gradient-to-br from-slate-900 via-slate-800 to-black text-gray-100">

    <section class="section dashboard">
                <div class="row">
                    <div class=" main-page col-lg-8">
                        <div class="row">
                            <div class=" col-md-12">
                                {{-- Posts container for infinite scroll --}}
                                <div id="posts-container">
                                    @foreach ($Posts as $Post)     
                                        <x-posts.post-card :post="$Post" />
                                    @endforeach
                                </div>

                                {{-- Sentinel used by IntersectionObserver to trigger loading next page --}}
                                <div id="infinite-scroll-sentinel" 
                                     class="flex items-center justify-center py-6"
                                     data-base-url="{{ route('posts.loadMore') }}"
                                     data-next-page="{{ $Posts->currentPage() < $Posts->lastPage() ? $Posts->currentPage()+1 : '' }}"
                                     data-last-page="{{ $Posts->lastPage() }}">
                                    @if($Posts->hasMorePages())
                                        <div id="infinite-loading" class="flex items-center gap-2 text-sm text-slate-200">
                                            <svg class="w-5 h-5 animate-spin text-slate-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                            </svg>
                                            Loading more posts...
                                        </div>
                                    @else
                                        <div class="text-sm text-slate-400">No more posts.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
            <!-- End Left side columns -->
            <!-- Right side columns -->
            <div class="col-lg-4">
                <!-- Available -->
                <x-available />
                <!-- End Available -->
            </div>
            <!-- End Right side columns -->
        </div>
    </section>
</main>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sentinel = document.getElementById('infinite-scroll-sentinel');
    if (!sentinel) return;

    const postsContainer = document.getElementById('posts-container');
    const loadingEl = document.getElementById('infinite-loading');

    let loading = false;

    function getNextPage() {
        return sentinel.getAttribute('data-next-page');
    }

    function setNextPage(page) {
        sentinel.setAttribute('data-next-page', page ? page : '');
    }

    function getBaseUrl() {
        return sentinel.getAttribute('data-base-url');
    }

    // Initialize skeleton loaders in a given root (document or element)
    function initializePostCards(root) {
        const rootNode = root || document;
        const loaders = rootNode.querySelectorAll('.skeleton-card');
        loaders.forEach(loader => {
            // Avoid re-processing loaders
            if (loader.dataset.processed) return;
            loader.dataset.processed = '1';

            const postId = (loader.id || '').replace('skeleton-loader-', '');
            // Give a short delay to simulate loading and avoid flash-of-unstyled
            setTimeout(() => {
                try {
                    loader.style.display = 'none';
                    const real = document.getElementById(`real-card-${postId}`);
                    if (real) real.style.display = 'block';
                } catch (e) {
                    console.error('Error initializing post card:', e);
                }
            }, 500);
        });
    }

    // Initialize any existing post cards on load
    initializePostCards(postsContainer || document);

    async function loadMore() {
    const nextPage = getNextPage();
    if (!nextPage || loading) return;
    loading = true;
    if (loadingEl) loadingEl.style.display = 'flex';

    try {
        const url = `${getBaseUrl()}?page=${nextPage}`;
        const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        if (!res.ok) throw new Error('Network response was not ok');
        const data = await res.json();

        // Append returned HTML
        const wrapper = document.createElement('div');
        wrapper.innerHTML = data.html;
        Array.from(wrapper.children).forEach(child => {
            postsContainer.appendChild(child);
        });

        // ✅ Initialize skeleton loaders inside the posts container (not the wrapper)
        initializePostCards(postsContainer);

        // Update next page
        if (data.next_page) {
            setNextPage(data.next_page);
        } else {
            setNextPage('');
            sentinel.innerHTML = '<div class="text-sm text-slate-400">No more posts.</div>';
            observer.disconnect();
        }
    } catch (err) {
        console.error('Error loading more posts:', err);
    } finally {
        loading = false;
        if (loadingEl) loadingEl.style.display = '';
    }
}

    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // When sentinel comes into view, load more posts
                loadMore();
            }
        });
    }, {
        root: null,
        rootMargin: '0px 0px 300px 0px', // start loading when 300px from sentinel
        threshold: 0
    });

    observer.observe(sentinel);
});
</script>
@endpush

@endsection