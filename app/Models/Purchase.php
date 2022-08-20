<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;

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
     * Get the stock that owns the Purchase
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }
    
    /**
     * Get the client that owns the Purchase
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
