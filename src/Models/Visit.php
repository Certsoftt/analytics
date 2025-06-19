<?php
namespace Analytics\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table = 'analytics_visits';
    protected $fillable = [
        'user_id', 'session_id', 'ip', 'country', 'region', 'city', 'url', 'referrer', 'is_organic', 'user_agent', 'visited_at', 'duration', 'bounce',
    ];
    public $timestamps = false;
}
