@extends('layouts.admin')
@section('content')
<div class="analytics-admin-goal-form">
    <h3>{{ isset($goal) ? __('analytics::analytics.edit_goal') : __('analytics::analytics.add_goal') }}</h3>
    <form method="POST" action="{{ isset($goal) ? route('admin.analytics.goals.update', $goal->id) : route('admin.analytics.goals.store') }}" id="goal-form">
        @csrf
        @if(isset($goal))
            @method('PUT')
        @endif
        <div class="form-group">
            <label>{{ __('analytics::analytics.goal_name') }}</label>
            <input type="text" name="name" class="form-control" value="{{ $goal->name ?? '' }}" required>
        </div>
        <div class="form-group">
            <label>{{ __('analytics::analytics.goal_event') }}</label>
            <input type="text" name="event" class="form-control" value="{{ $goal->event ?? '' }}" required>
        </div>
        <div class="form-group">
            <label>{{ __('analytics::analytics.goal_target') }}</label>
            <input type="number" name="target" class="form-control" value="{{ $goal->target ?? '' }}">
        </div>
        <div class="form-group">
            <label>{{ __('analytics::analytics.goal_description') }}</label>
            <textarea name="description" class="form-control">{{ $goal->description ?? '' }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('analytics::analytics.save') }}</button>
    </form>
</div>
<script src="/plugins/analytics/public/js/goals.js"></script>
<!-- Modal for goal form (optional, can be triggered via JS) -->
<div class="modal fade" id="goalModal" tabindex="-1" role="dialog" aria-labelledby="goalModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="goalModalLabel">{{ __('analytics::analytics.add_goal') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Goal form will be loaded here via AJAX -->
      </div>
    </div>
  </div>
</div>
@endsection
