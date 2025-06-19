<?php
namespace Analytics\Models;

use Illuminate\Database\Eloquent\Model;

class BlogClick extends Model
{
    protected $table = 'analytics_blog_clicks';
    protected $fillable = [
        'blog_id', 'user_id', 'session_id', 'ip', 'clicked_at',
    ];
    public $timestamps = false;
}
