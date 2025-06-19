// AJAX CRUD for goals
$(document).on('submit', '.analytics-admin-goal-form form', function(e) {
    e.preventDefault();
    var $form = $(this);
    $.ajax({
        url: $form.attr('action'),
        method: $form.find('input[name=_method]').val() || $form.attr('method'),
        data: $form.serialize(),
        success: function(resp) {
            window.location.href = '/admin/analytics/goals';
        },
        error: function(xhr) {
            alert('Error: ' + xhr.responseText);
        }
    });
});

$(document).on('click', '.btn-danger', function(e) {
    if (!confirm('Are you sure?')) e.preventDefault();
});
