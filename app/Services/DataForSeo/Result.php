<?php

namespace App\Services\DataForSeo;

class Result
{
    /**
     * @var array
     */
    private array $data;

    /**
     * @var array
     */
    private array $items;

    /**
     * @param array $data
     * @param array $items
     */
    public function __construct(array $data, array $items)
    {
        $this->data  = $data;
        $this->items = $items;
    }

    /**
     * @return array
     */
    public function additionalData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function items(): array
    {
        return $this->items;
    }
}
