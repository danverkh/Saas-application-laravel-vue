<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperFaq
 */
class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'order',
        'question',
        'answer',
    ];
}
