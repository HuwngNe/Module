<?php

namespace Ecommage\EcommageVoucher\Controller\Adminhtml\Voucher;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var bool|PageFactory
     */
    protected $resultPageFactory = false;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Page Voucher
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function  execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu("Ecommage_EcommageVoucher::voucher");
        $resultPage->getConfig()->getTitle()->prepend((__('VOUCHER')));

        return $resultPage;
    }
}
