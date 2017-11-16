<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaingSetting extends Model
{
    protected $table = 'campaings_settings';

    protected $fillable = ['value', 'campaings_rell_id'];

    public $timestamps = false;

    public function campaingRell()
    {
        return $this->hasMany(CampaingsRell::class, 'id', 'campaings_rell_id');
    }
}
