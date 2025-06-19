<?php
namespace Analytics\Middleware;

use Closure;
use Illuminate\Http\Request;
use Analytics\Models\Visit;
use Analytics\Models\ErrorLog;
use Illuminate\Support\Facades\Auth;

class TrackVisit
{
    public function handle(Request $request, Closure $next)
    {
        if (config('analytics.enabled')) {
            $consentRequired = config('analytics.gdpr.consent_required', false);
            $hasConsent = !$consentRequired || $request->cookie(config('analytics.gdpr.cookie_name', 'analytics_consent')) === '1';
            if ($hasConsent) {
                // Only track GET requests to public pages
                if ($request->isMethod('get') && !$request->is('admin/*')) {
                    $userAgent = $request->userAgent();
                    $browser = $this->parseBrowser($userAgent);
                    $ip = $this->anonymizeIp($request->ip());
                    try {
                        Visit::create([
                            'user_id' => Auth::id(),
                            'session_id' => session()->getId(),
                            'ip' => $ip,
                            'country' => $request->header('X-Country', null),
                            'region' => $request->header('X-Region', null),
                            'city' => $request->header('X-City', null),
                            'url' => $request->fullUrl(),
                            'referrer' => $request->headers->get('referer'),
                            'is_organic' => $this->isOrganic($request),
                            'user_agent' => $userAgent,
                            'visited_at' => now(),
                            'duration' => null,
                            'bounce' => false,
                            // Optionally store browser info in a JSON column or separate fields
                        ]);
                    } catch (\Exception $e) {
                        ErrorLog::create([
                            'type' => 'track_error',
                            'message' => $e->getMessage(),
                            'ip' => $ip,
                            'user_id' => Auth::id(),
                            'created_at' => now(),
                        ]);
                    }
                }
            }
        }
        return $next($request);
    }
    private function isOrganic(Request $request)
    {
        $ref = $request->headers->get('referer');
        if (!$ref) return false;
        return !str_contains($ref, $request->getHost());
    }
    private function anonymizeIp($ip)
    {
        if (!config('analytics.gdpr.anonymize_ip', false)) return $ip;
        // IPv4 only for simplicity
        $parts = explode('.', $ip);
        if (count($parts) === 4) {
            $parts[3] = '0';
            return implode('.', $parts);
        }
        return $ip;
    }
    private function parseBrowser($userAgent)
    {
        // Simple browser detection (expand as needed)
        if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (strpos($userAgent, 'Safari') !== false) return 'Safari';
        if (strpos($userAgent, 'Edge') !== false) return 'Edge';
        if (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) return 'IE';
        return 'Other';
    }
}
