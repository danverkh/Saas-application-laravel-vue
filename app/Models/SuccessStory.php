<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSuccessStory
 */
class SuccessStory extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'client_id';

    public const UPDATED_AT = null;

    protected $fillable = [
        'client_id',
        'client_industry',
        'client_country',
        'client_city',
        'monthly_fee',
        'keywords',
    ];

    protected $casts = [
        'keywords' => 'array',
    ];
}
