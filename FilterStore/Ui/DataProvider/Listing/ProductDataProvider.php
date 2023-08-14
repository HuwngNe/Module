<?php

namespace Ecommage\FilterStore\Ui\DataProvider\Listing;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollection;

class ProductDataProvider extends \Magento\Catalog\Ui\DataProvider\Product\ProductDataProvider
{

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ProductCollection $collectionFactory
     * @param array $addFieldStrategies
     * @param array $addFilterStrategies
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        ProductCollection $collectionFactory,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $collectionFactory,
            $addFieldStrategies,
            $addFilterStrategies,
            $meta,
            $data
        );
        $this->collection->addAttributeToSelect(['status', 'thumbnail', 'name', 'price'], 'left');
    }

    /**
     * @return array
     */
    public function getData()
    {
        return parent::getData();
    }
}
