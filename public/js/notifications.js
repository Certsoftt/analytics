// AJAX for notifications (mark as read/delete, modal view)
$(document).on('click', '.notification-view', function(e) {
    e.preventDefault();
    var $row = $(this).closest('tr');
    var message = $row.find('.notification-message').text();
    $('#notificationModal .modal-body').text(message);
    $('#notificationModal').modal('show');
});

$(document).on('click', '.notification-delete', function(e) {
    e.preventDefault();
    if (!confirm('Are you sure you want to delete this notification?')) return;
    var $row = $(this).closest('tr');
    var id = $row.data('id');
    $.ajax({
        url: '/admin/analytics/notifications/' + id,
        method: 'DELETE',
        data: { _token: $('meta[name="csrf-token"]').attr('content') },
        success: function() {
            $row.remove();
        },
        error: function(xhr) {
            alert('Error: ' + xhr.responseText);
        }
    });
});
