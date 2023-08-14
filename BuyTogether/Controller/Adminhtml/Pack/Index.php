<?php
namespace Ecommage\BuyTogether\Controller\Adminhtml\Pack;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var bool|PageFactory
     */
    protected $resultPageFactory = false;


    protected $sessionManager;


    public function __construct(Context $context, SessionManagerInterface $sessionManager, PageFactory $resultPageFactory)
    {
        $this->sessionManager = $sessionManager;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Stdlib\Cookie\FailureToSendException
     */
    public function  execute()
    {
        $this->sessionManager->start();
        $this->sessionManager->unsMessage();

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu("Ecommage_BuyTogether::pack");
        $resultPage->getConfig()->getTitle()->prepend((__('List buy together')));

        return $resultPage;
    }
}
