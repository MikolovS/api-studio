<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaings extends Model
{
    protected $table = 'campaigns';

    protected $fillable = ['name','binom_id','name','clicks','leads','traffic','group_traffic', 'is_bp'];

    public $timestamps = false;

    public function campaingRell()
    {
        return $this->hasMany(CampaingsRell::class, 'campaing', 'id');
    }
}
