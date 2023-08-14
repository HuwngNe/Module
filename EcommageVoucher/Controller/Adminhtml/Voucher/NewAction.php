<?php

namespace Ecommage\EcommageVoucher\Controller\Adminhtml\Voucher;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;

class NewAction extends Action
{
    const ADMIN_RESOURCE = "Ecommage_EcommageVoucher::save";

    /**
     * @var ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @param Context $context
     * @param ForwardFactory $forwardFactory
     */
    public function __construct(Context $context, ForwardFactory $forwardFactory)
    {
        $this->resultForwardFactory = $forwardFactory;
        parent::__construct($context);
    }

    /**
     * Redirect controller edit
     *
     * @return \Magento\Backend\Model\View\Result\Forward|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
