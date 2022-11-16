<?php

namespace App\Models;

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
}
