<?php

namespace App\Services;

use App\Models\Keyword;

class KeywordService
{
    /**
     * @param \App\Models\Keyword $keyword
     *
     * @return bool
     */
    public function cancel(Keyword $keyword): bool
    {
        $success = $keyword->update([
            'termination_date' => now(),
        ]);

        return $success;
    }
}
