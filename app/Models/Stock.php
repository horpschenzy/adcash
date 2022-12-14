<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getCreatedAtAttribute($date)
    {
        $date = Carbon::parse($date)->toDateTimeString();
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d/m/Y');
    }
    
    public function getUpdatedAtAttribute($date)
    {
        $date = Carbon::parse($date)->toDateTimeString();
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d/m/Y');
    }
}
