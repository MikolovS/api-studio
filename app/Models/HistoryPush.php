<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryPush extends Model
{
    protected $table = 'history_push';

    protected $fillable = ['campaign_id', 'site_id', 'push_time', 'type'];

    public $timestamps = false;

    public function site()
    {
        return $this->hasOne(Site::class, 'id', 'site_id');
    }

    public function campaigns()
    {
        return $this->hasOne(Campaings::class, 'id', 'campaign_id');
    }
}
