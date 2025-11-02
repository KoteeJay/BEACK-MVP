<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class VirusScanController extends Controller
{
    public function index()
    {
        return view('scan.index');
    }

    public function scanUrl(Request $request)
    {
        $request->validate(['url' => 'required|url']);

        $virusTotal = app('App\Services\VirusTotalService');

        // Step 1: Submit URL for scanning
        $scanResponse = $virusTotal->scanUrl($request->url);

        if (isset($scanResponse['error'])) {
            return back()->with('error', $scanResponse['error']['message']);
        }

        // Step 2: Extract analysis ID
        $analysisId = $scanResponse['data']['id'] ?? null;

        if (!$analysisId) {
            return back()->with('error', 'Unable to retrieve analysis ID.');
        }

        // Step 3: Wait a bit and fetch results
        sleep(5); // give VirusTotal a few seconds to process

        $result = $virusTotal->getAnalysisResult($analysisId);

        return view('scan.result', ['result' => $result]);
    }
}
