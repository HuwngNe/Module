<?php

namespace Ecommage\EcommageVoucher\Model\Config\Source;

use Ecommage\EcommageVoucher\Model\ResourceModel\Voucher\CollectionFactory as VoucherCollection;

class VoucherOption implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var array
     */
    protected static $_options = [];

    /**
     * @var VoucherCollection
     */
    protected $collectionFactory;

    /**
     * @param VoucherCollection $collectionFactory
     */
    public function __construct(VoucherCollection $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Custom config choose Voucher send mail
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (!self::$_options) {
            array_push(self::$_options,[
                'label' => __("-- Please Choose --"),
                'value' => 0
            ]);
            $voucher = $this->collectionFactory->create()->addFieldToFilter("status",["eq"=>1]);
            foreach ($voucher as $item) {
                array_push(self::$_options,[
                    'label' => $item->getTitle(),
                    'value' => $item->getId()
                ]);
            }
        }

        return self::$_options;
    }
}
