<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class equipment_reasons extends Model
{
    use HasFactory;
    protected $fillable = ['reason_type', 'description'];

}
