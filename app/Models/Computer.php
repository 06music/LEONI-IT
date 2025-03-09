<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory;
    protected $fillable = [
        'computer_name',
        'operating_system',
        'model',
        'mac_address',
        'ip_address',
        'disk_size',
        'ram',
        'serial_number',
        'site_id',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
