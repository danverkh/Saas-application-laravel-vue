<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperKeyword
 */
class Keyword extends Model
{
    use HasFactory;

    protected $table = 'autoranker_keywords';

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'keyword',
        'domain',
        'path_to_ranking_subpage',
        'country',
        'monthly_fee',
        'setup_fee',
        'search_volume',
        'creation_date',
        'start_date',
        'termination_date',
        'termination_confirmed',
        'termination_executed',
        'termination_reason_id',
        'termination_recorded_date',
        'setup_fee_invoiced',
        'order_fulfillment_request_date',
        'order_fulfillment_employee_id',
        'autoranker_experiment_id',
        'recurring_month_invoiced',
        'top_ten_notification_sent',
        'top_five_notification_sent',
        'last_rank_reported',
        'last_website_ranking',
        'last_website_ranking_update_date',
        'ranking_subpage_content',
        'ranking_subpage_content_last_fetched',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
