<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderKeyword extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'keyword',
        'search_volume',
        'cpc',
        'competition',
        'current_rank',
        'maximum_cost',
        'projected_clicks',
        'projected_traffic',
        'url',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
