<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperClient
 */
class Client extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'name', 'legal_person', 'owner', 'bank_details_id', 'vatin', 'street', 'zip', 'city', 'country', 'extra_info',
        'accounting_email', 'industry', 'source', 'payment_due_days', 'payment_method', 'stripe_customer_id', 'stripe_payment_method_id',
        'termination_notice_period_in_days', 'creation_date', 'employee_id', 'deletion_date', 'send_info_emails', 'last_info_email_sent_date',
        'retention_email_1_sent', 'retention_email_2_sent', 'retention_email_3_sent', 'retention_email_4_sent', 'not_canceled_mrr',
        'autoranker_bonus_email_1_sent', 'accountmanager_introduction_sent',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(ClientAccount::class);
    }
}
