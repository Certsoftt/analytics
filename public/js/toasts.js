// Toast notification logic
function showToast(message, type = 'info') {
    var toast = document.createElement('div');
    toast.className = 'analytics-toast analytics-toast-' + type;
    toast.innerText = message;
    document.body.appendChild(toast);
    setTimeout(function() {
        toast.classList.add('show');
    }, 10);
    setTimeout(function() {
        toast.classList.remove('show');
        setTimeout(function() { toast.remove(); }, 300);
    }, 4000);
}
