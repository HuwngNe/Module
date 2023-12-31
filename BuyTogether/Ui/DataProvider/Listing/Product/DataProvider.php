<?php

namespace Ecommage\BuyTogether\Ui\DataProvider\Listing\Product;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Ui\DataProvider\Product\Form\ProductDataProvider;
use Magento\Ui\DataProvider\Modifier\PoolInterface;

class DataProvider extends ProductDataProvider
{
    public function __construct(string $name, string $primaryFieldName, string $requestFieldName, CollectionFactory $collectionFactory, PoolInterface $pool, array $meta = [], array $data = [])
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $collectionFactory, $pool, $meta, $data);
    }

    public function getData()
    {
        dd($this->collection->getData());
        return parent::getData(); // TODO: Change the autogenerated stub
    }

}
