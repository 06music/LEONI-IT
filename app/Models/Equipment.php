<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'model',
        'serial_number',
        'status', // available, assigned, in_repair, retired
        'site_id'
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function assignments()
    {
        return $this->hasMany(EquipmentAssignment::class);
    }
}
