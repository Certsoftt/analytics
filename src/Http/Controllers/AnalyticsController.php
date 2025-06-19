<?php
namespace Analytics\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Analytics\Repositories\AnalyticsRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Analytics\Models\Goal;
use Analytics\Models\ErrorLog;
use Analytics\Events\NotificationCreated;

class AnalyticsController extends Controller
{
    protected $analytics;

    public function __construct(AnalyticsRepository $analytics)
    {
        $this->analytics = $analytics;
    }

    public function dashboard(Request $request)
    {
        // Only show if plugin is active
        if (!config('analytics.enabled')) {
            abort(403);
        }
        $data = $this->analytics->getDashboardData($request);
        return view('analytics::widgets.dashboard-analytics', $data);
    }

    public function stats(Request $request)
    {
        return response()->json($this->analytics->getStats($request));
    }

    public function geo(Request $request)
    {
        return response()->json($this->analytics->getGeoData($request));
    }

    public function engagement(Request $request)
    {
        return response()->json($this->analytics->getEngagement($request));
    }

    public function export(Request $request)
    {
        if (!Gate::allows('analytics.export')) {
            abort(403, 'Unauthorized');
        }
        return $this->analytics->export($request);
    }

    public function realtimeUsers(Request $request)
    {
        return response()->json([
            'active_users' => $this->analytics->getRealtimeUsers(),
        ]);
    }

    public function geoMap(Request $request)
    {
        $range = $request->input('range', 'daily');
        return response()->json([
            'geo_data' => $this->analytics->getGeoMapData($range),
        ]);
    }

    public function goals()
    {
        $goals = Goal::all();
        return view('analytics::admin.goals', compact('goals'));
    }

    public function notifications()
    {
        $notifications = ErrorLog::orderByDesc('created_at')->limit(100)->get();
        return view('analytics::admin.notifications', compact('notifications'));
    }

    public function createGoal()
    {
        return view('analytics::admin.goal-form');
    }

    public function storeGoal(Request $request)
    {
        $goal = Goal::create($request->only(['name', 'event', 'target', 'description']));
        return redirect()->route('admin.analytics.goals')->with('success', __('analytics::analytics.goal_added'));
    }

    public function editGoal(Goal $goal)
    {
        return view('analytics::admin.goal-form', compact('goal'));
    }

    public function updateGoal(Request $request, Goal $goal)
    {
        $goal->update($request->only(['name', 'event', 'target', 'description']));
        return redirect()->route('admin.analytics.goals')->with('success', __('analytics::analytics.goal_updated'));
    }

    public function destroyGoal(Goal $goal)
    {
        $goal->delete();
        return redirect()->route('admin.analytics.goals')->with('success', __('analytics::analytics.goal_deleted'));
    }

    public function storeNotificationTest()
    {
        // Create a test notification
        $notification = ErrorLog::create([
            'type' => 'test',
            'message' => 'This is a test real-time notification!',
            'ip' => request()->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
        ]);
        // Dispatch event
        event(new NotificationCreated($notification));
        return response()->json(['status' => 'Notification event dispatched']);
    }

    public function saveNotificationSettings(Request $request)
    {
        if (!Gate::allows('analytics.export')) {
            abort(403, 'Unauthorized');
        }
        $userId = auth()->id();
        $channel = $request->input('notification_channel', 'in-app');
        $this->analytics->saveNotificationSettings($userId, $channel);
        return redirect()->back()->with('success', 'Notification settings saved!');
    }

    public function addGoal(Request $request)
    {
        if (!Gate::allows('analytics.export')) {
            abort(403, 'Unauthorized');
        }
        $goal = $this->analytics->addGoal($request->all());
        return $goal ? redirect()->back()->with('success', 'Goal added!') : redirect()->back()->with('error', 'Failed to add goal.');
    }
    public function updateGoalById(Request $request, $id)
    {
        if (!Gate::allows('analytics.export')) {
            abort(403, 'Unauthorized');
        }
        $goal = $this->analytics->updateGoal($id, $request->all());
        return $goal ? redirect()->back()->with('success', 'Goal updated!') : redirect()->back()->with('error', 'Failed to update goal.');
    }
    public function deleteGoal($id)
    {
        if (!Gate::allows('analytics.export')) {
            abort(403, 'Unauthorized');
        }
        $result = $this->analytics->deleteGoal($id);
        return $result ? redirect()->back()->with('success', 'Goal deleted!') : redirect()->back()->with('error', 'Failed to delete goal.');
    }

    // --- API Endpoints for External Integration ---
    public function apiStats(Request $request)
    {
        if (!Gate::allows('analytics.export')) {
            abort(403, 'Unauthorized');
        }
        return response()->json($this->analytics->getStats($request));
    }
    public function apiGoals(Request $request)
    {
        if (!Gate::allows('analytics.export')) {
            abort(403, 'Unauthorized');
        }
        $goals = Goal::all();
        return response()->json($goals);
    }
    public function apiLogEvent(Request $request)
    {
        // Example: Accept event data from external system
        // Validate and log event (could be extended for security)
        $event = $request->input('event');
        $userId = $request->input('user_id', null);
        $this->analytics->logUserAction($userId, 'external_event', null, ['event' => $event]);
        return response()->json(['status' => 'logged']);
    }
}
