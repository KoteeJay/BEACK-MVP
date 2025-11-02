@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-gray-900 to-black text-gray-100 flex flex-col justify-center items-center px-4">
    <div class="max-w-3xl w-full bg-slate-900/60 backdrop-blur-lg rounded-2xl shadow-xl border border-slate-700 p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-cyan-400">🧠 Threat Analysis Report</h2>
            <a href="{{ route('scan.index') }}" class="text-sm text-gray-400 hover:text-cyan-400 transition">← New Scan</a>
        </div>

        @if(isset($result['data']['attributes']['stats']))
            @php
                $stats = $result['data']['attributes']['stats'];
            @endphp

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                <div class="bg-slate-800/70 border border-slate-700 rounded-lg p-4 text-center shadow hover:shadow-cyan-500/20 transition">
                    <p class="text-gray-400 text-sm uppercase">Harmless</p>
                    <p class="text-2xl font-bold text-green-400">{{ $stats['harmless'] ?? 0 }}</p>
                </div>

                <div class="bg-slate-800/70 border border-slate-700 rounded-lg p-4 text-center shadow hover:shadow-cyan-500/20 transition">
                    <p class="text-gray-400 text-sm uppercase">Malicious</p>
                    <p class="text-2xl font-bold text-red-400">{{ $stats['malicious'] ?? 0 }}</p>
                </div>

                <div class="bg-slate-800/70 border border-slate-700 rounded-lg p-4 text-center shadow hover:shadow-cyan-500/20 transition">
                    <p class="text-gray-400 text-sm uppercase">Suspicious</p>
                    <p class="text-2xl font-bold text-yellow-400">{{ $stats['suspicious'] ?? 0 }}</p>
                </div>

                <div class="bg-slate-800/70 border border-slate-700 rounded-lg p-4 text-center shadow hover:shadow-cyan-500/20 transition">
                    <p class="text-gray-400 text-sm uppercase">Undetected</p>
                    <p class="text-2xl font-bold text-gray-300">{{ $stats['undetected'] ?? 0 }}</p>
                </div>
            </div>

            <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6 text-sm leading-relaxed text-gray-300 shadow-inner">
                <p class="mb-2"><span class="font-semibold text-cyan-400">Scan ID:</span> {{ $result['data']['id'] ?? 'N/A' }}</p>
                <p><span class="font-semibold text-cyan-400">Status:</span> {{ $result['data']['attributes']['status'] ?? 'Unknown' }}</p>
            </div>
        @else
            <div class="text-center bg-slate-800/50 border border-slate-700 p-8 rounded-lg">
                <p class="text-gray-400 text-lg">
                    ⚠️ No analysis results found for this URL.
                </p>
            </div>
        @endif
    </div>

    <footer class="mt-8 text-gray-500 text-sm">
        Secured by <span class="text-cyan-400">VIRUS TOTAL</span> 🔐
    </footer>
</div>
@endsection
