<?php

namespace Ecommage\EcommageVoucher\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Ecommage\EcommageVoucher\Helper\SendMail;
use Ecommage\EcommageVoucher\Helper\Data;
use Ecommage\EcommageVoucher\Model\VoucherFactory;

class SendVoucher implements ObserverInterface
{
    /**
     * @var SendMail
     */
    protected $sendMail;

    /**
     * @var Data
     */
    protected $dataConfig;

    /**
     * @var VoucherFactory
     */
    protected $voucherFactory;

    /**
     * @param SendMail $sendMail
     * @param Data $dataConfig
     * @param VoucherFactory $voucherFactory
     */
    public function __construct(SendMail $sendMail, Data $dataConfig, VoucherFactory $voucherFactory)
    {
        $this->voucherFactory = $voucherFactory;
        $this->dataConfig = $dataConfig;
        $this->sendMail = $sendMail;
    }

    /**
     * Send mail
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        if ($this->dataConfig->getGeneralConfig("customer_voucher")) {
            $voucherConfig = $this->dataConfig->getGeneralConfig("customer_voucher");

            $dataVoucher = $this->voucherFactory->create()->load($voucherConfig);

            $data = $observer->getEvent();

            $this->sendMail->setVars([
                "customerName"  =>  $data->getOrder()->getCustomerFirstname()." ".$data->getOrder()->getCustomerLastname(),
                "percent"       =>  $dataVoucher->getPercent(),
                "startDate"     =>  $dataVoucher->getStartDate(),
                "endDate"       =>  $dataVoucher->getEndDate(),
                "idVoucher"     =>  $dataVoucher->getVoucherId(),
            ]);
            $this->sendMail->setToEmail($data->getOrder()->getCustomerEmail());

            $this->sendMail->sendLoadEmail();
        }
    }
}
