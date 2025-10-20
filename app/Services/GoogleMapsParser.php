<?php
// app/Services/GoogleMapsParser.php
namespace App\Services;

use Illuminate\Support\Facades\Log;

class GoogleMapsParser
{
    /** Ekstrak lat,lng dari URL Google Maps (mendukung link pendek dan panjang) */
    public static function extractLatLng(string $url): ?array
    {
        // Jika link pendek (maps.app.goo.gl), expand terlebih dahulu
        if (self::isShortUrl($url)) {
            $expandedUrl = self::expandShortUrl($url);
            if ($expandedUrl) {
                $url = $expandedUrl;
            }
        }

        // /@lat,lng,zoom
        if (preg_match('/@(-?\d+(?:\.\d+)?),\s*(-?\d+(?:\.\d+)?)(?:,(\d+(?:\.\d+)?)[az])?/i', $url, $m)) {
            return ['lat' => (float)$m[1], 'lng' => (float)$m[2]];
        }
        // ?q=lat,lng
        if (preg_match('/[?&]q=(-?\d+(?:\.\d+)?),\s*(-?\d+(?:\.\d+)?)/', $url, $m)) {
            return ['lat' => (float)$m[1], 'lng' => (float)$m[2]];
        }
        // ll=lat,lng
        if (preg_match('/[?&]ll=(-?\d+(?:\.\d+)?),\s*(-?\d+(?:\.\d+)?)/', $url, $m)) {
            return ['lat' => (float)$m[1], 'lng' => (float)$m[2]];
        }
        return null;
    }

    /** Cek apakah URL adalah link pendek Google Maps */
    public static function isShortUrl(string $url): bool
    {
        return preg_match('/maps\.app\.goo\.gl|goo\.gl\/maps/i', $url);
    }

    /** Expand URL pendek menjadi URL panjang */
    public static function expandShortUrl(string $shortUrl): ?string
    {
        try {
            // Set context options untuk follow redirects
            $context = stream_context_create([
                'http' => [
                    'method' => 'HEAD',
                    'follow_location' => true,
                    'max_redirects' => 10,
                    'timeout' => 30,
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
                ]
            ]);

            // Get headers untuk follow redirect
            $headers = get_headers($shortUrl, 1, $context);
            
            if ($headers && isset($headers[0])) {
                // Cari URL final setelah redirect
                foreach ($headers as $key => $value) {
                    if (strtolower($key) === 'location') {
                        $finalUrl = is_array($value) ? end($value) : $value;
                        return $finalUrl;
                    }
                }
            }

            // Fallback: gunakan cURL jika tersedia
            if (function_exists('curl_init')) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $shortUrl);
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_NOBODY, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
                
                curl_exec($ch);
                $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
                curl_close($ch);
                
                return $finalUrl ?: null;
            }

        } catch (\Exception $e) {
            // Log error jika diperlukan
            Log::warning('Failed to expand short URL: ' . $e->getMessage(), ['url' => $shortUrl]);
        }

        return null;
    }

    /** Bangun URL embed aman (tanpa API key) dari lat,lng */
    public static function embedUrlFromLatLng(float $lat, float $lng, int $zoom=16, string $hl='id'): string
    {
        return "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3000!2d{$lng}!3d{$lat}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zM40sNsKwMDAnMDAuMCJTIDEwN8KwMzEnMDAuMCJF!5e0!3m2!1s{$hl}!2sid!4v1234567890!5m2!1s{$hl}!2sid";
    }

    /** Bangun URL embed aman (tanpa API key) dari query teks */
    public static function embedUrlFromQuery(string $query, int $zoom=16, string $hl='id'): string
    {
        return "https://www.google.com/maps?q=" . urlencode($query) . "&z={$zoom}&hl={$hl}&output=embed";
    }
}
?>