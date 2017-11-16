<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaingsRell extends Model
{
    protected $table = 'campaigns_rell';

    protected $fillable = ['campaing', 'campaing_bp'];

    public $timestamps = false;

    public function campaing()
    {
        return $this->hasMany(Campaings::class, 'id', 'campaing');
    }

    public function settings()
    {
        return $this->hasOne(CampaingSetting::class,'campaings_rell_id', 'id');
    }
}
