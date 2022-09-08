<?php

namespace App\Services\DataForSeo\Requests;

use App\Services\DataForSeo\Params;

abstract class AbstractRequest
{
    protected Params $params;

    abstract public function fetch(): self;

    abstract public function result(): array;

    /**
     * @param \App\Services\DataForSeo\Params $params
     *
     * @return void
     */
    public function setParams(Params $params): void
    {
        $this->params = $params;
    }
}
