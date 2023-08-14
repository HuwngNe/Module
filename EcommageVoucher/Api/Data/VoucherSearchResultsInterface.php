<?php

namespace Ecommage\EcommageVoucher\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface VoucherSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get voucher list.
     *
     * @return VoucherInterface[]
     */
    public function getItems(): array;
    /**
     * Set voucher list.
     *
     * @param VoucherInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
