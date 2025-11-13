@props(['url'])

<button 
    type="button"
    onclick="copyToClipboard('{{ $url }}')" 
    class="w-full bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
    <i class="bi bi-share-fill"></i>
    <span>Share</span>
</button>

<div id="copyToast" 
     class="fixed top-5 right-5 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg text-sm opacity-0 translate-x-5 transition-all duration-300 z-[9999]">
     Link copied to clipboard!
</div>

@push('scripts')
<script>
    function copyToClipboard(url) {
        navigator.clipboard.writeText(url).then(() => {
            const toast = document.getElementById('copyToast');
            if (!toast) return;

            // Make toast visible
            toast.classList.remove('opacity-0', 'translate-x-5');
            toast.classList.add('opacity-100', 'translate-x-0');

            // Hide after 2 seconds
            setTimeout(() => {
                toast.classList.remove('opacity-100', 'translate-x-0');
                toast.classList.add('opacity-0', 'translate-x-5');
            }, 2000);
        }).catch(err => {
            console.error('Clipboard copy failed:', err);
        });
    }
</script>
@endpush
