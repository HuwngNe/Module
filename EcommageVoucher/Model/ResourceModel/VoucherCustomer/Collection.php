<?php

namespace Ecommage\EcommageVoucher\Model\ResourceModel\VoucherCustomer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Ecommage\EcommageVoucher\Model\VoucherCustomer;
use Ecommage\EcommageVoucher\Model\ResourceModel\VoucherCustomer as VoucherCustomerResource;


class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(VoucherCustomer::class,VoucherCustomerResource::class);
    }
}
