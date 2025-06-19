<?php
namespace Analytics\Models;

use Illuminate\Database\Eloquent\Model;

class GeoData extends Model
{
    protected $table = 'analytics_geo_data';
    protected $fillable = [
        'visit_id', 'country', 'region', 'city',
    ];
    public $timestamps = false;
}
