<?php

namespace App\Models;

use twentyfouronline\Interfaces\Models\Keyable;

class AccessPoint extends DeviceRelatedModel implements Keyable
{
    protected $primaryKey = 'accesspoint_id';
    public $timestamps = false;
    protected $fillable = [
        'device_id',
        'name',
        'radio_number',
        'type',
        'mac_addr',
        'channel',
        'txpow',
        'radioutil',
        'numasoclients',
        'nummonclients',
        'numactbssid',
        'nummonbssid',
        'interference',
    ];

    public function getCompositeKey()
    {
        return "{$this->name}_{$this->radio_number}";
    }
}




