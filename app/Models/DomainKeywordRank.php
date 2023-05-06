<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperDomainKeywordRank
 */
class DomainKeywordRank extends Model
{
    protected $fillable = [
        'rank',
        'keyword_id',
        'created_at',
    ];

    const UPDATED_AT = null;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function keyword(): BelongsTo
    {
        return $this->belongsTo(Keyword::class);
    }
}
