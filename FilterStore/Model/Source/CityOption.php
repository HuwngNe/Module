<?php

namespace Ecommage\FilterStore\Model\Source;

//use Ecommage\Address\Model\ResourceModel\City\CollectionFactory as CityCollection;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class CityOption extends AbstractSource
{
    /**
     * @var CityCollection
     */
    protected $collectionFactory;

    /**
     * Construct
     *
     * @param CityCollection $collectionFactory
     */
//    public function __construct(CityCollection $collectionFactory)
//    {
//        $this->collectionFactory = $collectionFactory;
//    }

    /**
     * Take region_id return value city corresponding
     *
     * @return array
     */
    public function getAllOptions()
    {
        $options = [];
        $propertyMap = [
            'value' => 'city_id',
            'region_id' => 'region_id'
        ];
        $coll = $this->collectionFactory->create();
        foreach ($coll as $item) {
            $option = [];
            foreach ($propertyMap as $code => $field) {
                $option[$code] = $item->getData($field);
            }
            $option['label'] = $item->getName();
            $options[] = $option;
        }
        return $options;
    }

}
