<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperOrder
 */
class Order extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'client_id',
        'employee_id',
        'contact_first_name',
        'contact_last_name',
        'contact_gender',
        'contact_email',
        'contact_language',
        'contact_style',
        'first_upsell_email_sent',
        'second_upsell_email_sent',
        'creation_date',
        'client_account_created',
        'order_confirmation_sent',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function keywords(): HasMany
    {
        return $this->hasMany(Keyword::class)->orderBy('keyword');
    }
}
