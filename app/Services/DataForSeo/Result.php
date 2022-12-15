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
     * @var array
     */
    private array $results;

    /**
     * @param array $data
     * @param array $items
     * @param array $result
     * @param array $results
     */
    public function __construct(array $data, array $items, array $result = [], array $results = [])
    {
        $this->data    = $data;
        $this->items   = $items;
        $this->result  = $result;
        $this->results = $results;
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

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->results;
    }
}
