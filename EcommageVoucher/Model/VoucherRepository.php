<?php

namespace Ecommage\EcommageVoucher\Model;

use Ecommage\EcommageVoucher\Api\Data\VoucherInterface;
use Ecommage\EcommageVoucher\Api\Data\VoucherInterfaceFactory;
use Ecommage\EcommageVoucher\Api\Data\VoucherSearchResultsInterface;
use Ecommage\EcommageVoucher\Api\Data\VoucherSearchResultsInterfaceFactory;
use Ecommage\EcommageVoucher\Api\VoucherRepositoryInterface;
use Ecommage\EcommageVoucher\Model\ResourceModel\Voucher as ResourceVoucher;
use Ecommage\EcommageVoucher\Model\ResourceModel\Voucher\CollectionFactory as VoucherCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
/**
 * Voucher repository
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class VoucherRepository implements VoucherRepositoryInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var ResourceVoucher
     */
    private $resource;
    /**
     * @var VoucherCollectionFactory
     */
    private $collectionFactory;
    /**
     * @var VoucherFactory
     */
    private $voucherFactory;
    /**
     * @var VoucherInterfaceFactory
     */
    private $voucherInterfaceFactory;
    /**
     * @var VoucherSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @param ResourceVoucher $resource
     * @param VoucherFactory $voucherFactory
     * @param VoucherInterfaceFactory $voucherInterfaceFactory
     * @param VoucherCollectionFactory $collectionFactory
     * @param VoucherSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceVoucher                      $resource,
        VoucherFactory                       $voucherFactory,
        VoucherInterfaceFactory              $voucherInterfaceFactory,
        VoucherCollectionFactory             $collectionFactory,
        VoucherSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface      $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->voucherFactory = $voucherFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->voucherInterfaceFactory = $voucherInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param int $voucherId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $voucherId): bool
    {
        return $this->delete($this->getById($voucherId));
    }

    /**
     * @param VoucherInterface $voucher
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(VoucherInterface $voucher): bool
    {
        try {
            $this->resource->delete($voucher);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the voucher: %1', $exception->getMessage())
            );
        }
        return true;
    }

    /**
     * @param int $voucherId
     * @return VoucherInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $voucherId): VoucherInterface
    {
        $voucher = $this->voucherFactory->create();
        $this->resource->load($voucher, $voucherId);
        if (!$voucher->getId()) {
            throw new NoSuchEntityException(__('The voucher with the "%1" ID doesn\'t exist.', $voucherId));
        }
        return $voucher;
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
     * @param VoucherInterface $voucher
     * @return VoucherInterface
     * @throws CouldNotSaveException
     */
    public function save(VoucherInterface $voucher): VoucherInterface
    {
        try {
            $this->resource->save($voucher);
        } catch (LocalizedException $exception) {
            throw new CouldNotSaveException(
                __('Could not save the voucher: %1', $exception->getMessage()),
                $exception
            );
        } catch (\Throwable $exception) {
            throw new CouldNotSaveException(
                __('Could not save the voucher: %1', __('Something went wrong while saving the voucher.')),
                $exception
            );
        }
        return $voucher;
    }
}
