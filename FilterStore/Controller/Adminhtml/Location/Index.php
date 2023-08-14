<?php
namespace Ecommage\FilterStore\Controller\Adminhtml\Location;

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
     * Construct
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Page Location
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function  execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu("Ecommage_FilterStore::location");
        $resultPage->getConfig()->getTitle()->prepend((__('LOCATION STORE')));

        return $resultPage;
    }
}
