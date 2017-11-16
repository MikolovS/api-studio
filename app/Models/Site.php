<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $table = 'site';

    protected $fillable = ['name', 'name', 'clicks', 'leads', 'campaing_id', 'is_tracked', 'cr'];

    public $timestamps = false;

}
