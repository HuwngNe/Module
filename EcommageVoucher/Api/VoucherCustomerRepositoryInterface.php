<?php

namespace Ecommage\EcommageVoucher\Api;

use Ecommage\EcommageVoucher\Api\Data\VoucherCustomerInterface;
use Ecommage\EcommageVoucher\Api\Data\VoucherCustomerSearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;

interface VoucherCustomerRepositoryInterface
{
    /**
     * Delete voucher customer.
     *
     * @param VoucherCustomerInterface $voucherCustomer
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(VoucherCustomerInterface $voucherCustomer): bool;
    /**
     * Delete voucher customer by ID.
     *
     * @param int $entityId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $entityId): bool;
    /**
     * Retrieve voucher customer.
     *
     * @param int $entityId
     * @return VoucherCustomerInterface
     * @throws LocalizedException
     */
    public function getById(int $entityId): VoucherCustomerInterface;
    /**
     * Retrieve vouchers customer matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return VoucherCustomerSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
    /**
     * Save voucher customer.
     *
     * @param VoucherCustomerInterface $voucherCustomer
     * @return VoucherCustomerInterface
     * @throws LocalizedException
     */
    public function save(VoucherCustomerInterface $voucherCustomer): VoucherCustomerInterface;

}
