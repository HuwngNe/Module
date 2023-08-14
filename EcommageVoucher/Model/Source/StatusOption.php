<?php

namespace Ecommage\EcommageVoucher\Model\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class StatusOption extends AbstractSource
{
    /**
     * Custom status voucher
     *
     * @return array[]
     */
    public function getAllOptions()
    {
        $options = [
            [
                "label" => "Close",
                "value" =>  0
            ],
            [
                "label" => "Active",
                "value" =>  1
            ]
        ];

        return $options;
    }
}
