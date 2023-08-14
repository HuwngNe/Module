<?php

namespace Ecommage\BuyTogether\Model\Total\Quote;

use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use Ecommage\BuyTogether\Helper\CheckPercent;
use Magento\Quote\Model\Quote;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote\Address\Total;

class Custom extends AbstractTotal
{
    /**
     * @var PriceCurrencyInterface
     */
    protected $_priceCurrency;

    protected $checkPercent;

    /**
     * @param PriceCurrencyInterface $priceCurrency
     * @param CheckPercent $checkPercent
     */
    public function __construct(
        PriceCurrencyInterface $priceCurrency,
        CheckPercent $checkPercent,
    ) {
        $this->checkPercent = $checkPercent;
        $this->_priceCurrency = $priceCurrency;
    }

    public function collect(
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);

        $baseDiscount = $this->checkPercent->checkPercent();

        $customDiscount = - $this->_priceCurrency->convert($baseDiscount);

        $total->addTotalAmount('customdiscount', $customDiscount);

        $total->addBaseTotalAmount('customdiscount', $customDiscount);

        return $this;
    }

}
