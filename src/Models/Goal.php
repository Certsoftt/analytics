<?php
namespace Analytics\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $table = 'analytics_goals';
    protected $fillable = [
        'name', 'description', 'event', 'target', 'achieved', 'created_at',
    ];
    public $timestamps = false;
}
