<?php

namespace Ecommage\FilterStore\Model;

use Ecommage\FilterStore\Api\Data\LocationInterface;
use Ecommage\FilterStore\Api\Data\LocationInterfaceFactory;
use Ecommage\FilterStore\Api\Data\LocationSearchResultsInterface;
use Ecommage\FilterStore\Api\Data\LocationSearchResultsInterfaceFactory;
use Ecommage\FilterStore\Api\LocationRepositoryInterface;
use Ecommage\FilterStore\Model\ResourceModel\Location as ResourceLocation;
use Ecommage\FilterStore\Model\ResourceModel\Location\CollectionFactory as LocationCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Location repository
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class LocationRepository implements LocationRepositoryInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var ResourceLocation
     */
    private $resource;
    /**
     * @var LocationCollectionFactory
     */
    private $collectionFactory;
    /**
     * @var LocationFactory
     */
    private $locationFactory;
    /**
     * @var LocationInterfaceFactory
     */
    private $LocationInterfaceFactory;
    /**
     * @var LocationSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @param ResourceLocation $resource
     * @param LocationFactory $locationFactory
     * @param LocationInterfaceFactory $LocationInterfaceFactory
     * @param LocationCollectionFactory $collectionFactory
     * @param LocationSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceLocation                      $resource,
        LocationFactory                       $locationFactory,
        LocationInterfaceFactory              $LocationInterfaceFactory,
        LocationCollectionFactory             $collectionFactory,
        LocationSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface      $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->locationFactory = $locationFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->LocationInterfaceFactory = $LocationInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param int $locationId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $locationId): bool
    {
        return $this->delete($this->getById($locationId));
    }

    /**
     * @param LocationInterface $location
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(LocationInterface $location): bool
    {
        try {
            $this->resource->delete($location);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the location: %1', $exception->getMessage())
            );
        }
        return true;
    }

    /**
     * @param int $locationId
     * @return LocationInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $locationId): LocationInterface
    {
        $location = $this->locationFactory->create();
        $this->resource->load($location, $locationId);
        if (!$location->getId()) {
            throw new NoSuchEntityException(__('The location with the "%1" ID doesn\'t exist.', $locationId));
        }
        return $location;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @param LocationInterface $location
     * @return LocationInterface
     * @throws CouldNotSaveException
     */
    public function save(LocationInterface $location): LocationInterface
    {
        try {
            $this->resource->save($location);
        } catch (LocalizedException $exception) {
            throw new CouldNotSaveException(
                __('Could not save the location: %1', $exception->getMessage()),
                $exception
            );
        } catch (\Throwable $exception) {
            throw new CouldNotSaveException(
                __('Could not save the location: %1', __('Something went wrong while saving the location.')),
                $exception
            );
        }
        return $location;
    }
}

