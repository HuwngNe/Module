<?php

namespace Ecommage\BuyTogether\Api;

use Ecommage\BuyTogether\Api\Data\PackInterface;
use Ecommage\BuyTogether\Api\Data\PackSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

interface PackRepositoryInterface
{
    /**
     * Delete pack.
     *
     * @param PackInterface $pack
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(PackInterface $pack): bool;
    /**
     * Delete pack by ID.
     *
     * @param int $packId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $packId): bool;
    /**
     * Retrieve pack.
     *
     * @param int $packId
     * @return PackInterface
     * @throws LocalizedException
     */
    public function getById(int $packId): PackInterface;
    /**
     * Retrieve packs matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return PackSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
    /**
     * Save pack.
     *
     * @param PackInterface $pack
     * @return PackInterface
     * @throws LocalizedException
     */
    public function save(PackInterface $pack): PackInterface;
}
