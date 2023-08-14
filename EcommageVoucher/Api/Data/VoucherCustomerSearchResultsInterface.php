<?php

namespace Ecommage\EcommageVoucher\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface VoucherCustomerSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get voucher customer list.
     *
     * @return VoucherCustomerInterface[]
     */
    public function getItems(): array;
    /**
     * Set voucher customer list.
     *
     * @param VoucherCustomerInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
