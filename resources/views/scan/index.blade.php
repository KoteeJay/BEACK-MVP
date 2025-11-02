@extends('layouts.app')
<script>
    document.querySelector("form").addEventListener("submit", () => {
        const loader = document.createElement("div");
        loader.className = "fixed inset-0 bg-black/70 flex items-center justify-center z-50";
        loader.innerHTML = `
            <div class="animate-pulse text-cyan-400 text-lg font-semibold tracking-widest">
                Scanning URL... 🛰️
            </div>
        `;
        document.body.appendChild(loader);
    });
</script>

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-black text-gray-100 flex flex-col justify-center items-center px-4">
    <div class="max-w-lg w-full bg-slate-900/60 backdrop-blur-lg rounded-2xl shadow-lg border border-slate-700 p-8">
        <h1 class="text-3xl font-bold text-cyan-400 text-center mb-6 tracking-wide">
            🔒 CyberScan – URL Threat Analyzer
        </h1>

        @if (session('error'))
            <div class="bg-red-500/10 text-red-400 border border-red-500 rounded-lg px-4 py-2 mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('scan.submit') }}" class="space-y-6">
            @csrf
            <div>
                <label for="url" class="block text-sm mb-2 text-gray-400 uppercase tracking-wider">Website URL</label>
                <input type="url" name="url" id="url"
                    placeholder="https://example.com"
                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-3 text-gray-200 focus:outline-none focus:ring-2 focus:ring-cyan-500 transition">
                @error('url')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full py-3 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                Scan Now
            </button>
        </form>
    </div>

    <p class="mt-8 text-gray-500 text-sm">
        Powered by <span class="text-cyan-400">VirusTotal API</span> | Stay safe online 🛡️
    </p>
</div>
@endsection
