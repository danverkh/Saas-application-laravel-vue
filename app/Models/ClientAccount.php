<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperClientAccount
 */
class ClientAccount extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'client_id', 'first_name', 'last_name', 'gender', 'email', 'language', 'contact_style', 'password',
        'creation_date', 'deletion_date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return float
     */
    public function costPrediction(): float
    {
        $orderIds = $this->client->orders()->select('id')->pluck('id');

        $rows = DB::table('autoranker_keywords')
                  ->leftJoin('domain_keyword_ranks', 'autoranker_keywords.id', '=', 'domain_keyword_ranks.keyword_id')
                  ->whereNull('termination_date')
                  ->whereIn('order_id', $orderIds)
                  ->whereDate('created_at', '>=', now()->subDays(30))
                  ->select('keyword_id', 'rank', 'cpc', 'search_volume')
                  ->get();

        return $rows->groupBy('keyword_id')
            ->reduce(static function ($carry, $group) {
                $clicksPerDay = $group->map(static function ($row) {
                    // same logic in resources/js/pages/dashboard/campaigns/KeywordStats.vue
                    if ($row->rank === 1) {
                        $multiplier = 0.95;
                    } elseif ($row->rank === 2) {
                        $multiplier = 0.9;
                    } elseif ($row->rank === 3) {
                        $multiplier = 0.8;
                    } else {
                        $amount = ($row->rank > 10) ? 0.3 : 0.06;
                        $multiplier = max(1 - ($row->rank * $amount), 0.01);
                    }
                    return round($row->search_volume * $multiplier);
                });

                if ($group->count() < 30) {
                    $average = $clicksPerDay->average();

                    for ($i = 1; $i <= (30 - $group->count()); $i++) {
                        $clicksPerDay->push($average);
                    }
                }
                $cpc = $group->first(static fn ($i) => $i->cpc !== null)?->cpc;

                if ($cpc === null) {
                    return $carry;
                }
                return round(($clicksPerDay->sum() * $cpc) + $carry, 2);
            }, 0);
    }

    /**
     * Returns account quality score
     *
     * @return float
     */
    public function qualityScore(): float
    {
        $orderIds = $this->client->orders()->select('id')->pluck('id');

        $averageRank = DB::table('autoranker_keywords')
                         ->leftJoin('domain_keyword_ranks', 'autoranker_keywords.id', '=', 'domain_keyword_ranks.keyword_id')
                         ->whereNull('termination_date')
                         ->whereIn('order_id', $orderIds)
                         ->whereBetween('created_at', [now()->subDays(3), now()])
                         ->average('rank');

        if ($averageRank <= 3) {
            return 10;
        }

        return (float)max(10 - $averageRank / 3, 5);
    }
}
