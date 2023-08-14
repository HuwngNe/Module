<?php

namespace Ecommage\BuyTogether\Controller\Adminhtml\Pack;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\Stdlib\Cookie\SensitiveCookieMetadata;

class NewAction extends Action
{
    const ADMIN_RESOURCE = "Ecommage_BuyTogether::save";

    /**
     * @var ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var CookieManagerInterface
     */
    protected $cookieManager;

    protected $metadata;


    public function __construct(Context $context, CookieManagerInterface $cookieManager, ForwardFactory $forwardFactory, SensitiveCookieMetadata $metadata)
    {
        $this->metadata = $metadata;
        $this->cookieManager = $cookieManager;
        $this->resultForwardFactory = $forwardFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Forward|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Stdlib\Cookie\FailureToSendException
     */
    public function execute()
    {
        $this->cookieManager->deleteCookie("mainProductIds",$this->metadata);
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
