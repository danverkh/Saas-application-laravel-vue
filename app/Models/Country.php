<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperCountry
 */
class Country extends Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'country_has_language');
    }

    /**
     * @return array
     */
    public static function dropdownOptions(): array
    {
        return self::orderBy('name')
                   ->get(['name', 'id'])
                   ->map(fn($item) => ['label' => $item->name, 'value' => $item->id])
                   ->toArray();
    }
}
