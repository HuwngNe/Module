<?php

namespace Ecommage\EcommageVoucher\Api;

use Ecommage\EcommageVoucher\Api\Data\VoucherInterface;
use Ecommage\EcommageVoucher\Api\Data\VoucherSearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;

interface VoucherRepositoryInterface
{
    /**
     * Delete voucher.
     *
     * @param VoucherInterface $voucher
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(VoucherInterface $voucher): bool;
    /**
     * Delete voucher by ID.
     *
     * @param int $voucherId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $voucherId): bool;
    /**
     * Retrieve voucher.
     *
     * @param int $voucherId
     * @return VoucherInterface
     * @throws LocalizedException
     */
    public function getById(int $voucherId): VoucherInterface;
    /**
     * Retrieve vouchers matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return VoucherSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
    /**
     * Save voucher.
     *
     * @param VoucherInterface $voucher
     * @return VoucherInterface
     * @throws LocalizedException
     */
    public function save(VoucherInterface $voucher): VoucherInterface;
}
