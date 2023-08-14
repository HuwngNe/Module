<?php

namespace Ecommage\BuyTogether\Model;

use Ecommage\BuyTogether\Api\Data\PackInterface;
use Ecommage\BuyTogether\Api\Data\PackInterfaceFactory;
use Ecommage\BuyTogether\Api\Data\PackSearchResultsInterface;
use Ecommage\BuyTogether\Api\Data\PackSearchResultsInterfaceFactory;
use Ecommage\BuyTogether\Api\PackRepositoryInterface;
use Ecommage\BuyTogether\Model\ResourceModel\Pack as ResourcePack;
use Ecommage\BuyTogether\Model\ResourceModel\Pack\CollectionFactory as PackCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class PackRepository implements PackRepositoryInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var ResourcePack
     */
    private $resource;
    /**
     * @var PackCollectionFactory
     */
    private $collectionFactory;
    /**
     * @var PackFactory
     */
    private $packFactory;
    /**
     * @var PackInterfaceFactory
     */
    private $packInterfaceFactory;
    /**
     * @var PackSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @param ResourcePack $resource
     * @param PackFactory $packFactory
     * @param PackInterfaceFactory $packInterfaceFactory
     * @param PackCollectionFactory $collectionFactory
     * @param PackSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourcePack                      $resource,
        PackFactory                       $packFactory,
        PackInterfaceFactory              $packInterfaceFactory,
        PackCollectionFactory             $collectionFactory,
        PackSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface      $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->packFactory = $packFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->packInterfaceFactory = $packInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param int $packId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $packId): bool
    {
        return $this->delete($this->getById($packId));
    }

    /**
     * @param PackInterface $pack
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(PackInterface $pack): bool
    {
        try {
            $this->resource->delete($pack);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the pack: %1', $exception->getMessage())
            );
        }
        return true;
    }

    /**
     * @param int $packId
     * @return PackInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $packId): PackInterface
    {
        $pack = $this->packFactory->create();
        $this->resource->load($pack, $packId);
        if (!$pack->getId()) {
            throw new NoSuchEntityException(__('The pack with the "%1" ID doesn\'t exist.', $packId));
        }
        return $pack;
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
     * @param PackInterface $pack
     * @return PackInterface
     * @throws CouldNotSaveException
     */
    public function save(PackInterface $pack): PackInterface
    {
        try {
            $this->resource->save($pack);
        } catch (LocalizedException $exception) {
            throw new CouldNotSaveException(
                __('Could not save the pack: %1', $exception->getMessage()),
                $exception
            );
        } catch (\Throwable $exception) {
            throw new CouldNotSaveException(
                __('Could not save the pack: %1', __('Something went wrong while saving the pack.')),
                $exception
            );
        }
        return $pack;
    }
}
