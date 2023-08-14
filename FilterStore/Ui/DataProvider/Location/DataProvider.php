<?php

namespace Ecommage\FilterStore\Ui\DataProvider\Location;

use Ecommage\FilterStore\Model\ResourceModel\Location\CollectionFactory as LocationCollection;
use Magento\Framework\Api\Filter;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var \Ecommage\FilterStore\Model\ResourceModel\Location\Collection
     */
    protected $collection;

    /**
     * @var array
     */
    protected $addFilterStrategies;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param LocationCollection $collectionFactory
     * @param array $addFilterStrategies
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        LocationCollection $collectionFactory,
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->addFilterStrategies = $addFilterStrategies;
    }

    /**
     * @return array
     */
    public function getData()
    {

        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }
        $items = $this->getCollection()->toArray();

        return $items;
    }


    /**
     * @param Filter $filter
     * @return array|void
     */
    public function addFilter(Filter $filter)
    {
        $items = $this->getCollection();

        $items->getSelect()->where("main_table.title like ?","%".$filter->getValue()."%")->orWhere("main_table.address like ?","%".$filter->getValue()."%");

        $items = $items->toArray();

        return $items;
    }

}
