<?php

namespace Ecommage\FilterStore\Model\ResourceModel\Location;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * Construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('\Ecommage\FilterStore\Model\Location','\Ecommage\FilterStore\Model\ResourceModel\Location');
    }

    /**
     * Join table
     *
     * @return void
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->join(["rt"=>"directory_country_region"],"rt.region_id = main_table.region_id","rt.default_name")
        ->join(["ct"=>"directory_region_city"],"ct.city_id = main_table.city_id","ct.name")
        ->addFilterToMap('location_id', 'main_table.location_id');
    }


}
