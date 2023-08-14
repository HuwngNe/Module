<?php

namespace Ecommage\FilterStore\Model\Location;

use Magento\Framework\Registry;
use Ecommage\FilterStore\Model\ResourceModel\Location\CollectionFactory as LocationCollection;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollection;
use Magento\Catalog\Helper\Image as ImageHelper;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var \Ecommage\FilterStore\Model\ResourceModel\Location\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    protected $productCollection;

    protected $imageHelper;

    protected $registry;
    /**
     * @var
     */
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param LocationCollection $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(string $name,string $primaryFieldName,string $requestFieldName, Registry $registry, ImageHelper $imageHelper, ProductCollection $productCollection, LocationCollection $collectionFactory, DataPersistorInterface $dataPersistor, array $meta = [], array $data = [])
    {
        $this->registry = $registry;
        $this->imageHelper = $imageHelper;
        $this->productCollection = $productCollection;
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     */
    public function getData()
    {
        // Get items
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $data = $this->collection->getData();
        if ($data[0]) {
            if (!empty($data[0]['product_ids'])) {
                $productIds = explode('/', $data[0]['product_ids']);
                $data[0]['links']['products'] = $this->getReviewProducts($productIds);
            }
            $this->loadedData[$data[0]["location_id"]] = $data[0];
        }

        return $this->loadedData;
    }

    private function getReviewProducts($productIds)
    {
        if ($productIds) {
            $productCollection = $this->productCollection->create();
            $productCollection->addIdFilter($productIds)
                ->addAttributeToSelect(['status', 'thumbnail', 'name', 'price'], 'left');

            $result = [];
            foreach ($productCollection->getItems() as $product) {
                $result[] = $this->fillData($product);
            }
            return $result;
        }

        return null;
    }

    private function fillData($product)
    {
        return [
            'entity_id' => $product->getId(),
            'thumbnail' => $this->imageHelper->init($product, 'product_listing_thumbnail')->getUrl(),
            'name' => $product->getName(),
            'sku' => $product->getSku(),
            'price' => $product->getPrice()
        ];
    }
}
