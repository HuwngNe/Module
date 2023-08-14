<?php

namespace Ecommage\FilterStore\Model\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Directory\Model\ResourceModel\Region\CollectionFactory as RegionFactory;

class RegionOption extends AbstractSource
{
    /**
     * @var RegionFactory
     */
    protected $regionFactory;

    /**
     * Construct
     *
     * @param RegionFactory $regionFactory
     */
    public function __construct(RegionFactory $regionFactory)
    {
        $this->regionFactory = $regionFactory;
    }

    /**
     * Take country_id return value region corresponding
     *
     * @return array
     */
    public function getAllOptions()
    {
        $options = [];
        $propertyMap = [
            'value' => 'region_id',
            'country_id' => 'country_id'
        ];
        $region = $this->regionFactory->create();
        foreach ($region as $item) {
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
