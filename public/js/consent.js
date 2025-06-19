// GDPR consent banner logic
window.addEventListener('DOMContentLoaded', function() {
    if (!document.cookie.includes('analytics_consent')) {
        var banner = document.createElement('div');
        banner.id = 'analytics-consent-banner';
        banner.innerHTML = '<div style="background:#222;color:#fff;padding:16px;position:fixed;bottom:0;width:100%;z-index:9999;text-align:center;">'+
            'We use cookies for analytics. <a href="/privacy-policy" style="color:#4af;">Learn more</a>. '+
            '<button id="accept-analytics" style="margin-left:16px;">Accept</button>'+
            '<button id="decline-analytics" style="margin-left:8px;">Decline</button>'+
            '</div>';
        document.body.appendChild(banner);
        document.getElementById('accept-analytics').onclick = function() {
            document.cookie = 'analytics_consent=1;path=/;max-age=31536000';
            banner.remove();
        };
        document.getElementById('decline-analytics').onclick = function() {
            document.cookie = 'analytics_consent=0;path=/;max-age=31536000';
            banner.remove();
        };
    }
});
