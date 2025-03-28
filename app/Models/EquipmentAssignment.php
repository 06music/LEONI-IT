<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentAssignment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'equipment_id',
        'assigned_by',
        'assigned_at',
        'returned_at',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipment() {
        return $this->belongsTo(Equipment::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
