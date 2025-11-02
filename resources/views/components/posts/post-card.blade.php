@props(['post'])

<div class="main-card my-5 position-relative bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-gray-100 rounded-lg shadow-md border border-blue-800 px-4">

    {{-- Skeleton Loader --}}
    <div class="skeleton-card" id="skeleton-loader-{{ $post->id }}">
        <div class="d-flex align-items-center">
            <div class="skeleton skeleton-avatar"></div>
            <div class="ms-3 w-100">
                <div class="skeleton skeleton-line short"></div>
                <div class="skeleton skeleton-line" style="width: 40%;"></div>
            </div>
        </div>
        <div class="mt-3">
            <div class="skeleton skeleton-line"></div>
            <div class="skeleton skeleton-line short"></div>
            <div class="skeleton skeleton-line" style="width: 80%;"></div>
        </div>
        <div class="skeleton skeleton-img bg-slate-600"></div>
    </div>

    {{-- Actual Post Card --}}
    <div class="post-card-content" id="real-card-{{ $post->id }}" style="display: none;">
        <div class="d-flex profile justify-content-start align-items-center">
            <img
                src="{{ $post->user->profile_photo_path
                    ? asset('storage/' . $post->user->profile_photo_path)
                    : asset('assets/img/profile-photo.jpg') }}"
                alt="Profile Photo"
            />
            <div class="mx-2 d-flex justify-content-between align-items-center w-100">
                <div>
                    <h5 style="white-space: nowrap">
                        <a href="{{ route('users.posts', $post->user->id) }}">{{ $post->user->name }}</a>
                    </h5>
                </div>
                <div class="position-relative">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li>
                                <a href="#" class="btn w-100" data-bs-toggle="modal" data-bs-target="#shareModal">
                                    Share <i class="bi bi-share mr-2"></i>
                                </a>
                            </li>
                            @auth
                                @if (auth()->id() === $post->user->id)
                                    <li><a class="dropdown-item" href="{{ route('posts.edit', $post->slug) }}">Edit</a></li>
                                    <li>
                                        <form action="{{ route('posts.destroy', $post->slug) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>    
                                        </form>    
                                    </li>
                                @endif
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="blog-post mt-3" id="post-{{ $post->id }}" 
            style="overflow: hidden; word-wrap: break-word; overflow-wrap: break-word; white-space: normal;">
            
            <p class="mb-0" style="font-size: 12px; color: gray;">
                {{ $post->created_at->diffForHumans() }}
            </p>

            {{-- Short Preview Text --}}
            <span class="short-text" style="display: inline;">
                {{ Str::limit($post->body, 200) }}
            </span>

            {{-- Full Text --}}
            <span class="full-text" style="display: none;">
                {{ $post->body }}
            </span>

            {{-- Read More Button (Only show if text > 200 chars) --}}
            @if (strlen($post->body) > 200)
                <span class="read-more-btn" 
                    style="color: #61b2ff; cursor: pointer; font-weight: 500;" 
                    data-post-id="{{ $post->id }}"
                    onclick="toggleReadMore(this)">
                    Continue reading
                </span>
            @endif
        </div>


        <div class="post-image mt-3">
            <img src="{{ asset('storage/' . $post->image) }}" class="image" alt="Post Image">
        </div>

        <div class="d-flex justify-content-between my-3">
            <livewire:like-button :post="$post" />
            <div class="mx-3" style="font-size: 20px">
                <a href="{{ route('posts.show', $post->slug) }}">
                    <i class="bi bi-chat"></i> {{ $post->comments->count() }}
                </a>
            </div>
        </div>
    </div>
</div>



<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel" style="color:rgb(20, 20, 20);">Share This Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Share Options -->
                <div class="share-options">
                    <!-- Copy Link -->
                    <div class="mb-3">
                        
                        <div class="input-group">
                            <input type="text" class="form-control" id="shareUrl" 
                                   value="{{ url()->current() }}" readonly>
                            <button class="btn btn-outline-primary" onclick="copyToClipboard(this)">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                        </div>
                    </div>
                    
                    <!-- Social Media Buttons -->
                    <div class="flex space-x-4 mt-4">
                        <a href="https://facebook.com" target="_blank" class="transition" aria-label="Share on Facebook" style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:9999px; background:#1877F2;">
                            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/facebook.svg" alt="Facebook" class="w-5 h-5" style="filter: invert(1) brightness(2);" />
                        </a>

                        <a href="https://twitter.com" target="_blank" class="transition" aria-label="Share on Twitter" style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:9999px; background:#1DA1F2;">
                            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/twitter.svg" alt="Twitter" class="w-5 h-5" style="filter: invert(1) brightness(2);" />
                        </a>

                        <a href="https://instagram.com" target="_blank" class="transition" aria-label="Share on Instagram" style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:9999px; background:linear-gradient(45deg,#feda75,#d62976);">
                            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/instagram.svg" alt="Instagram" class="w-5 h-5" style="filter: invert(1) brightness(2);" />
                        </a>

                        <a href="https://linkedin.com" target="_blank" class="transition" aria-label="Share on LinkedIn" style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:9999px; background:#0A66C2;">
                            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/linkedin.svg" alt="LinkedIn" class="w-5 h-5" style="filter: invert(1) brightness(2);" />
                        </a>

                        <a href="https://wa.me/?text={{ urlencode(url()->current()) }}" target="_blank" class="transition" aria-label="Share on WhatsApp" style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:9999px; background:#25D366;">
                            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/whatsapp.svg" alt="WhatsApp" class="w-5 h-5" style="filter: invert(1) brightness(2);" />
                        </a>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Copy toast -->
<div id="copy-toast" aria-live="polite" aria-atomic="true" style="position:fixed; right:20px; bottom:20px; padding:10px 14px; background:rgba(0,0,0,0.85); color:#fff; border-radius:8px; display:none; z-index:2000; opacity:0; transition:opacity .2s ease-in-out; box-shadow:0 6px 18px rgba(0,0,0,0.2);">
    <span id="copy-toast-message"></span>
</div>

@push('scripts')
<script>
function showCopyToast(message = 'Copied') {
    const toast = document.getElementById('copy-toast');
    const toastMessage = document.getElementById('copy-toast-message');
    if (!toast || !toastMessage) return;
    toastMessage.textContent = message;
    toast.style.display = 'block';
    // allow transition
    requestAnimationFrame(() => {
        toast.style.opacity = '1';
    });
    // Hide after 2s
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => { toast.style.display = 'none'; }, 220);
    }, 2000);
}

function copyToClipboard(button) {
    const shareUrl = document.getElementById('shareUrl');
    if (!shareUrl) return;
    try {
        shareUrl.select();
        shareUrl.setSelectionRange(0, 99999); // For mobile devices

        // Use modern API if available
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(shareUrl.value).then(function() {
                // Update button UI
                if (button) {
                    const originalHtml = button.innerHTML;
                    button.innerHTML = '<i class="fas fa-check"></i> Copied!';
                    button.classList.remove('btn-outline-primary');
                    button.classList.add('btn-success');
                    setTimeout(() => {
                        button.innerHTML = originalHtml;
                        button.classList.remove('btn-success');
                        button.classList.add('btn-outline-primary');
                    }, 2000);
                }
                showCopyToast('Link copied to clipboard');
            }).catch(function(err) {
                // fallback
                document.execCommand('copy');
                showCopyToast('Link copied to clipboard');
            });
        } else {
            // Older browsers
            document.execCommand('copy');
            if (button) {
                const originalHtml = button.innerHTML;
                button.innerHTML = '<i class="fas fa-check"></i> Copied!';
                button.classList.remove('btn-outline-primary');
                button.classList.add('btn-success');
                setTimeout(() => {
                    button.innerHTML = originalHtml;
                    button.classList.remove('btn-success');
                    button.classList.add('btn-outline-primary');
                }, 2000);
            }
            showCopyToast('Link copied to clipboard');
        }
    } catch (err) {
        console.error('Copy failed', err);
        showCopyToast('Unable to copy');
    }
}

// Optional: Auto-open modal if URL has share parameter
if (new URLSearchParams(window.location.search).has('share')) {
    document.addEventListener('DOMContentLoaded', function() {
        const shareModal = new bootstrap.Modal(document.getElementById('shareModal'));
        shareModal.show();
    });
}
</script>
@endpush
   

<script>
    // Function to toggle read more/less
    function toggleReadMore(button) {
        const postId = button.getAttribute('data-post-id');
        const postElement = document.getElementById(`post-${postId}`);
        const shortText = postElement.querySelector('.short-text');
        const fullText = postElement.querySelector('.full-text');

        if (shortText.style.display === 'none') {
            // Currently showing full text, switch to short
            shortText.style.display = 'inline';
            fullText.style.display = 'none';
            button.textContent = 'Continue reading';
        } else {
            // Currently showing short text, switch to full
            shortText.style.display = 'none';
            fullText.style.display = 'inline';
            button.textContent = 'Show less';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Get all post IDs from the data attributes
        const skeletonLoaders = document.querySelectorAll('[id^="skeleton-loader-"]');
        
        setTimeout(() => {
            skeletonLoaders.forEach(loader => {
                const postId = loader.id.replace('skeleton-loader-', '');
                loader.style.display = 'none';
                document.getElementById(`real-card-${postId}`).style.display = 'block';
            });
        }, 200);
    });
    document.addEventListener('click', function (e) {
    if (e.target.matches('.like-btn') || e.target.matches('.unlike-btn')) {
        e.preventDefault();

        const form = e.target.closest('form');
        const url = form.action;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => response.text())
        .then(() => {
            location.reload(); // Reload the page to update the like count
        })
        .catch(error => console.error('Error:', error));
    }
    });
    function showLoginPrompt() {
        if (confirm('You need to log in to like this post. Do you want to log in now?')) {
            window.location.href = '{{ route('login') }}?redirect_to=' + encodeURIComponent(window.location.href);
        }
    }

    
</script>
