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
     * @var array
     */
    private array $result;

    /**
     * @param array $data
     * @param array $items
     * @param array $result
     */
    public function __construct(array $data, array $items, array $result = [])
    {
        $this->data   = $data;
        $this->items  = $items;
        $this->result = $result;
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

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->result;
    }
}
