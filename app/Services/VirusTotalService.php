<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VirusTotalService
{
    protected $apiKey;
    protected $baseUrl = 'https://www.virustotal.com/api/v3/';

    public function __construct()
    {
        $this->apiKey = env('VIRUSTOTAL_API_KEY');
    }

    public function scanUrl($url)
    {
        $response = Http::withHeaders([
            'x-apikey' => $this->apiKey,
        ])->asForm() // important: send as form data
          ->post($this->baseUrl . 'urls', [
              'url' => $url, // <-- VirusTotal expects this
          ]);

        if ($response->failed()) {
            return ['error' => $response->json()];
        }

        return $response->json();
    }
    public function getAnalysisResult($analysisId)
        {
            $response = Http::withHeaders([
                'x-apikey' => $this->apiKey,
            ])->get($this->baseUrl . 'analyses/' . $analysisId);

            if ($response->failed()) {
                return ['error' => $response->json()];
            }

            return $response->json();
        }
}
