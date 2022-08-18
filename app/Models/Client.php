<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
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

    /**
     * Get all of the purchases for the Client
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class)->with('stock');
    }
}
