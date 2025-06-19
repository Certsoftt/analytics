<?php
namespace Analytics\Repositories;

use Analytics\Models\Visit;
use Analytics\Models\BlogClick;
use Analytics\Models\GeoData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

class AnalyticsRepository
{
    public function getDashboardData(Request $request)
    {
        try {
            // Example: Fetch real analytics data
            $visits = Visit::count();
            $blogs = BlogClick::count();
            $clicks = BlogClick::sum('clicks');
            $geo = GeoData::select('country', \DB::raw('count(*) as count'))->groupBy('country')->get();
            $top_blog = BlogClick::orderByDesc('clicks')->first();
            $bounce_rate = Visit::where('bounced', true)->count() / max(1, $visits) * 100;
            $avg_duration = Visit::avg('duration');
            $organic = Visit::where('referrer', 'organic')->count();
            $referrals = Visit::select('referrer', \DB::raw('count(*) as count'))->groupBy('referrer')->get();
            $engagement = BlogClick::select('blog_id', \DB::raw('sum(clicks) as total_clicks'))->groupBy('blog_id')->get();
            return [
                'visits' => $visits,
                'blogs' => $blogs,
                'clicks' => $clicks,
                'geo' => $geo,
                'top_blog' => $top_blog,
                'bounce_rate' => $bounce_rate,
                'avg_duration' => $avg_duration,
                'organic' => $organic,
                'referrals' => $referrals,
                'engagement' => $engagement,
            ];
        } catch (\Exception $e) {
            \Log::error('Dashboard data fetch failed: ' . $e->getMessage());
            return [
                'visits' => 0,
                'blogs' => 0,
                'clicks' => 0,
                'geo' => [],
                'top_blog' => null,
                'bounce_rate' => 0,
                'avg_duration' => 0,
                'organic' => 0,
                'referrals' => [],
                'engagement' => [],
            ];
        }
    }
    public function getStats(Request $request) {
        // Example: Return stats by date range
        try {
            $from = $request->input('from', now()->subMonth());
            $to = $request->input('to', now());
            $visits = Visit::whereBetween('visited_at', [$from, $to])->count();
            $clicks = BlogClick::whereBetween('created_at', [$from, $to])->sum('clicks');
            return ['visits' => $visits, 'clicks' => $clicks];
        } catch (\Exception $e) {
            \Log::error('Stats fetch failed: ' . $e->getMessage());
            return ['visits' => 0, 'clicks' => 0];
        }
    }
    public function getGeoData(Request $request) {
        try {
            return GeoData::select('country', \DB::raw('count(*) as count'))->groupBy('country')->get();
        } catch (\Exception $e) {
            \Log::error('Geo data fetch failed: ' . $e->getMessage());
            return [];
        }
    }
    public function getEngagement(Request $request) {
        try {
            return BlogClick::select('blog_id', \DB::raw('sum(clicks) as total_clicks'))->groupBy('blog_id')->get();
        } catch (\Exception $e) {
            \Log::error('Engagement fetch failed: ' . $e->getMessage());
            return [];
        }
    }
    public function export(Request $request)
    {
        try {
            // Implement export logic (CSV, Excel, etc.)
            $userId = auth()->id();
            $this->logUserAction($userId, 'export', null, ['filters' => $request->all()]);
            // Placeholder: return dummy CSV
            return response()->streamDownload(function() {
                echo "id,visit_date,country\n1,2025-06-19,US\n";
            }, 'analytics-export.csv');
        } catch (\Exception $e) {
            \Log::error('Analytics export failed: ' . $e->getMessage());
            return response('Export failed', 500);
        }
    }
    public function logUserAction($userId, $action, $entityId = null, $details = null)
    {
        // Implement audit logging (e.g., to error_logs or a dedicated audit table)
        \Log::info('Analytics audit', [
            'user_id' => $userId,
            'action' => $action,
            'entity_id' => $entityId,
            'details' => $details,
            'timestamp' => now(),
        ]);
    }

    public function getRealtimeUsers()
    {
        // Count unique session_ids active in the last 5 minutes
        $activeSince = Carbon::now()->subMinutes(5);
        return Visit::where('visited_at', '>=', $activeSince)
            ->distinct('session_id')
            ->count('session_id');
    }

    public function getGeoMapData($range = 'daily')
    {
        // Aggregate visits by country for the given range
        $query = Visit::query();
        if ($range === 'daily') {
            $query->whereDate('visited_at', Carbon::today());
        } elseif ($range === 'weekly') {
            $query->where('visited_at', '>=', Carbon::now()->subWeek());
        } elseif ($range === 'monthly') {
            $query->where('visited_at', '>=', Carbon::now()->subMonth());
        }
        return $query->select('country', \DB::raw('count(*) as count'))
            ->groupBy('country')
            ->orderByDesc('count')
            ->get();
    }

    public function saveNotificationSettings($userId, $channel)
    {
        // Save notification channel (in-app, email, none) for user
        // Example: \DB::table('user_settings')->updateOrInsert(['user_id' => $userId, 'key' => 'analytics_notifications'], ['value' => $channel]);
        $this->logUserAction($userId, 'update_notification_settings', null, ['channel' => $channel]);
        return true;
    }
    public function addGoal($data)
    {
        try {
            $goal = \Analytics\Models\Goal::create($data);
            $this->logUserAction(auth()->id(), 'add_goal', $goal->id, $data);
            return $goal;
        } catch (\Exception $e) {
            \Log::error('Add goal failed: ' . $e->getMessage());
            return null;
        }
    }
    public function updateGoal($id, $data)
    {
        try {
            $goal = \Analytics\Models\Goal::findOrFail($id);
            $goal->update($data);
            $this->logUserAction(auth()->id(), 'update_goal', $goal->id, $data);
            return $goal;
        } catch (\Exception $e) {
            \Log::error('Update goal failed: ' . $e->getMessage());
            return null;
        }
    }
    public function deleteGoal($id)
    {
        try {
            $goal = \Analytics\Models\Goal::findOrFail($id);
            $goal->delete();
            $this->logUserAction(auth()->id(), 'delete_goal', $id);
            return true;
        } catch (\Exception $e) {
            \Log::error('Delete goal failed: ' . $e->getMessage());
            return false;
        }
    }
}
