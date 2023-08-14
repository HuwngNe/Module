<?php

namespace Ecommage\FilterStore\Api;

use Ecommage\FilterStore\Api\Data\LocationInterface;
use Ecommage\FilterStore\Api\Data\LocationSearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;

interface LocationRepositoryInterface
{
    /**
     * Delete location.
     *
     * @param LocationInterface $location
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(LocationInterface $location): bool;
    /**
     * Delete location by ID.
     *
     * @param int $locationId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $locationId): bool;
    /**
     * Retrieve location.
     *
     * @param int $locationId
     * @return LocationInterface
     * @throws LocalizedException
     */
    public function getById(int $locationId): LocationInterface;
    /**
     * Retrieve locations matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return LocationSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
    /**
     * Save location.
     *
     * @param LocationInterface $location
     * @return LocationInterface
     * @throws LocalizedException
     */
    public function save(LocationInterface $location): LocationInterface;
}
