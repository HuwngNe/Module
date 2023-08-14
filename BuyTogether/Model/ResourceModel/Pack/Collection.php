<?php

namespace Ecommage\BuyTogether\Model\ResourceModel\Pack;

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
        $this->_init('\Ecommage\BuyTogether\Model\Pack','\Ecommage\BuyTogether\Model\ResourceModel\Pack');
    }

    /**
     * Join table
     *
     * @return void
     */
    protected function _initSelect()
    {
        parent::_initSelect();

    }
}
