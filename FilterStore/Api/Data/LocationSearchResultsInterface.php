<?php

namespace Ecommage\FilterStore\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface LocationSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get location list.
     *
     * @return LocationInterface[]
     */
    public function getItems(): array;

    /**
     * Set location list.
     *
     * @param LocationInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
