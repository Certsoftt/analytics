<?php
namespace Analytics\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    protected $table = 'analytics_error_logs';
    protected $fillable = [
        'type', 'message', 'ip', 'user_id', 'created_at',
    ];
    public $timestamps = false;
}
