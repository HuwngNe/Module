<?php

namespace Ecommage\BuyTogether\Plugin;

use Ecommage\BuyTogether\Helper\CheckPercent;
use Ecommage\BuyTogether\Model\PackFactory;
use Magento\Checkout\Controller\Onepage\Success;

class AddQuantity
{
    protected $checkPercent;

    protected $packFactory;

    public function __construct(CheckPercent $checkPercent, PackFactory $packFactory)
    {
        $this->checkPercent = $checkPercent;
        $this->packFactory = $packFactory;
    }

    public function afterExecute(Success $subject, $result)
    {
        $items = $subject->getOnepage()->getCheckout()->getLastRealOrder()->getAllItems();
        $value = $this->checkPercent->checkProductInCart($items);
        if ($value != 0) {
            $pack = $this->packFactory->create()->load($this->checkPercent->getPackId());
            $pack->setQuantity($pack->getQuantity() + 1);
            $pack->save();
        }
        return $result;
    }
}
