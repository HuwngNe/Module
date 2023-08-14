<?php

namespace Ecommage\BuyTogether\Api\Data;

use Ecommage\BuyTogether\Api\Data\PackInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface PackSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get pack list.
     *
     * @return PackInterface[]
     */
    public function getItems(): array;

    /**
     * Set pack list.
     *
     * @param PackInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
