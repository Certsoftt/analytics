@extends('layouts.admin')
@section('content')
<div class="analytics-admin-notifications">
    <h3>{{ __('analytics::analytics.notifications_title') }}</h3>
    <table class="table" id="notifications-table">
        <thead>
            <tr>
                <th>{{ __('analytics::analytics.notification_type') }}</th>
                <th>{{ __('analytics::analytics.notification_message') }}</th>
                <th>{{ __('analytics::analytics.created_at') }}</th>
                <th>{{ __('analytics::analytics.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notifications as $notification)
            <tr data-id="{{ $notification->id }}">
                <td>{{ $notification->type }}</td>
                <td class="notification-message">{{ $notification->message }}</td>
                <td>{{ $notification->created_at }}</td>
                <td>
                    <a href="#" class="btn btn-sm btn-info notification-view">{{ __('analytics::analytics.view') }}</a>
                    <a href="#" class="btn btn-sm btn-danger notification-delete">{{ __('analytics::analytics.delete') }}</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script src="/plugins/analytics/public/js/notifications.js"></script>
<script src="/plugins/analytics/public/js/toasts.js"></script>
<script src="/plugins/analytics/public/js/echo.js"></script>
<!-- Modal for notification view -->
<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notificationModalLabel">{{ __('analytics::analytics.notification_message') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Notification message will be loaded here via JS -->
      </div>
    </div>
  </div>
</div>
@endsection
