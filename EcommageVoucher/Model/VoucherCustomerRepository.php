<?php

namespace Ecommage\EcommageVoucher\Model;


use Ecommage\EcommageVoucher\Api\VoucherCustomerRepositoryInterface;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Ecommage\EcommageVoucher\Model\ResourceModel\VoucherCustomer as ResourceVoucherCustomer;
use Ecommage\EcommageVoucher\Model\ResourceModel\VoucherCustomer\CollectionFactory as VoucherCustomerCollectionFactory;
use Ecommage\EcommageVoucher\Api\Data\VoucherCustomerInterface;
use Ecommage\EcommageVoucher\Api\Data\VoucherCustomerInterfaceFactory;
use Ecommage\EcommageVoucher\Api\Data\VoucherCustomerSearchResultsInterface;
use Ecommage\EcommageVoucher\Api\Data\VoucherCustomerSearchResultsInterfaceFactory;
use Ecommage\EcommageVoucher\Model\VoucherCustomerFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;

class VoucherCustomerRepository implements VoucherCustomerRepositoryInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var ResourceVoucherCustomer
     */
    private $resource;

    /**
     * @var VoucherCustomerCollectionFactory
     */
    private $collectionFactory;

    /**
     * @var VoucherCustomerRepository
     */
    private $voucherCustomerFactory;

    /**
     * @var VoucherCustomerInterfaceFactory
     */
    private $voucherCustomerInterfaceFactory;

    /**
     * @var VoucherCustomerSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    public function __construct(
        ResourceVoucherCustomer             $resource,
        VoucherCustomerFactory              $voucherCustomerFactory,
        VoucherCustomerInterfaceFactory     $voucherCustomerInterfaceFactory,
        VoucherCustomerCollectionFactory    $collectionFactory,
        VoucherCustomerSearchResultsInterfaceFactory    $searchResultsFactory,
        CollectionProcessorInterface        $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->voucherCustomerFactory = $voucherCustomerFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->voucherCustomerInterfaceFactory = $voucherCustomerInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    public function deleteById(int $vcusId): bool
    {
        return $this->delete($this->getById($vcusId));
    }

    public function delete(VoucherCustomerInterface $voucherCustomer): bool
    {
        try {
            $this->resource->delete($voucherCustomer);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the voucher: %1', $exception->getMessage())
            );
        }
        return true;
    }

    public function getById(int $vcusId): VoucherCustomerInterface
    {
        $voucherCustomer = $this->voucherCustomerFactory->create();
        $this->resource->load($voucherCustomer, $vcusId);
        if (!$voucherCustomer->getId()) {
            throw new NoSuchEntityException(__('The voucher with the "%1" ID doesn\'t exist.', $vcusId));
        }
        return $voucherCustomer;
    }

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

    public function save(VoucherCustomerInterface $voucherCustomer): VoucherCustomerInterface
    {
        try {
            $this->resource->save($voucherCustomer);
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
        return $voucherCustomer;
    }
}
