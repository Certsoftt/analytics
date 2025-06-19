<?php
// Helper to inject analytics widget into dashboard if plugin is active
if (function_exists('add_dashboard_widget')) {
    add_dashboard_widget(function () {
        if (config('analytics.enabled')) {
            echo view('analytics::widgets.dashboard-analytics')->render();
        }
    });
}
