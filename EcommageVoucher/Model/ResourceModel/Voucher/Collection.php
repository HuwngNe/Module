<?php

namespace Ecommage\EcommageVoucher\Model\ResourceModel\Voucher;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Ecommage\EcommageVoucher\Model\Voucher as VoucherModel;
use Ecommage\EcommageVoucher\Model\ResourceModel\Voucher as ResourceVoucher;

class Collection extends AbstractCollection
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(VoucherModel::class,ResourceVoucher::class);
    }

}
