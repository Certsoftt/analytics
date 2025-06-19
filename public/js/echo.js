// Laravel Echo + Pusher/Socket.io integration for real-time analytics
import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'your-pusher-key', // Replace with your Pusher key or use env
    cluster: 'mt1',
    forceTLS: true
});

// Listen for new notifications
window.Echo.channel('analytics-notifications')
    .listen('Analytics.Events.NotificationCreated', (e) => {
        showToast('New notification: ' + e.notification.message, 'info');
        // Optionally update notifications table
    });

// Listen for real-time user count updates
window.Echo.channel('analytics-realtime-users')
    .listen('Analytics.Events.RealtimeUserCountUpdated', (e) => {
        document.getElementById('realtime-user-count').innerText = e.count;
    });
