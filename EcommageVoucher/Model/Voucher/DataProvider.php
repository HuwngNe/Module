<?php

namespace Ecommage\EcommageVoucher\Model\Voucher;

use Ecommage\EcommageVoucher\Model\ResourceModel\Voucher\CollectionFactory as VoucherCollection;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\DB\Adapter\AdapterInterface;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var VoucherCollection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var
     */
    protected $loadedData;

    /**
     * @var AdapterInterface|null
     */
    protected $connection;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param VoucherCollection $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param AdapterInterface|null $connection
     * @param array $meta
     * @param array $data
     */
    public function __construct($name, $primaryFieldName, $requestFieldName, VoucherCollection $collectionFactory, DataPersistorInterface $dataPersistor, AdapterInterface $connection = null, array $meta = [], array $data = [])
    {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->connection = $connection;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        foreach ($items as $block) {
            $this->loadedData[$block->getId()] = $block->getData();
        }

        $data = $this->dataPersistor->get('voucher');
        if (!empty($data)) {
            $block = $this->collection->getNewEmptyItem();
            $block->setData($data);
            $this->loadedData[$block->getId()] = $block->getData();
            $this->dataPersistor->clear('voucher');
        }

        return $this->loadedData;
    }
}
