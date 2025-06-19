<div class="analytics-dashboard-widget">
    <h3>{{ __('analytics::analytics.dashboard_title') }}</h3>
    <div id="analytics-charts">
        <!-- Chart.js or ApexCharts will render here -->
    </div>
    <div class="analytics-stats">
        <div>{{ __('analytics::analytics.visits') }}: <span id="visits-count">{{ $visits ?? 0 }}</span></div>
        <div>{{ __('analytics::analytics.blogs') }}: <span id="blogs-count">{{ $blogs ?? 0 }}</span></div>
        <div>{{ __('analytics::analytics.clicks') }}: <span id="clicks-count">{{ $clicks ?? 0 }}</span></div>
        <div>{{ __('analytics::analytics.top_blog') }}: <span id="top-blog">{{ $top_blog ?? '-' }}</span></div>
        <div>{{ __('analytics::analytics.bounce_rate') }}: <span id="bounce-rate">{{ $bounce_rate ?? 0 }}%</span></div>
        <div>{{ __('analytics::analytics.avg_duration') }}: <span id="avg-duration">{{ $avg_duration ?? 0 }}s</span></div>
        <div>{{ __('analytics::analytics.organic') }}: <span id="organic">{{ $organic ?? 0 }}</span></div>
    </div>
    <div id="analytics-geo">
        <!-- Geo data visualization -->
    </div>
    <div id="analytics-engagement">
        <!-- Engagement insights visualization -->
    </div>
    <div class="analytics-export">
        <button id="export-csv">{{ __('analytics::analytics.export_csv') }}</button>
        <button id="export-excel">{{ __('analytics::analytics.export_excel') }}</button>
    </div>
</div>
<script src="/plugins/analytics/public/js/analytics.js"></script>
<link rel="stylesheet" href="/plugins/analytics/public/css/analytics.css">
