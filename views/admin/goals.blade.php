@extends('layouts.admin')
@section('content')
<div class="analytics-admin-goals">
    <h3>{{ __('analytics::analytics.goals_title') }}</h3>
    <div class="row mb-2">
        <div class="col-md-4">
            <input type="text" id="goal-search" class="form-control" placeholder="Search goals...">
        </div>
        <div class="col-md-3">
            <select id="goal-status-filter" class="form-control">
                <option value="">All Statuses</option>
                <option value="achieved">Achieved</option>
                <option value="not_achieved">Not Achieved</option>
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-danger" id="bulk-delete-btn">Delete Selected</button>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('analytics::analytics.goal_name') }}</th>
                <th>{{ __('analytics::analytics.goal_event') }}</th>
                <th>{{ __('analytics::analytics.goal_target') }}</th>
                <th>{{ __('analytics::analytics.goal_achieved') }}</th>
                <th>{{ __('analytics::analytics.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($goals as $goal)
            <tr>
                <td><input type="checkbox" class="goal-checkbox" value="{{ $goal->id }}"> {{ $goal->name }}</td>
                <td>{{ $goal->event }}</td>
                <td>{{ $goal->target }}</td>
                <td>{{ $goal->achieved ? '✔' : '✗' }}</td>
                <td>
                    <a href="#" class="btn btn-sm btn-primary">{{ __('analytics::analytics.edit') }}</a>
                    <a href="#" class="btn btn-sm btn-danger">{{ __('analytics::analytics.delete') }}</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="#" class="btn btn-success">{{ __('analytics::analytics.add_goal') }}</a>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('goal-search').addEventListener('input', function() {
        // TODO: Implement AJAX search/filter
    });
    document.getElementById('goal-status-filter').addEventListener('change', function() {
        // TODO: Implement AJAX status filter
    });
    document.getElementById('bulk-delete-btn').addEventListener('click', function() {
        // TODO: Implement bulk delete
    });
});
</script>
@endsection
