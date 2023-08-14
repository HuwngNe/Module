<?php

namespace Ecommage\BuyTogether\Controller\Adminhtml\Pack;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\View\Result\PageFactory;
use Ecommage\BuyTogether\Model\PackFactory;

class Edit extends Action
{
    const ADMIN_RESOURCE = "Ecommage_BuyTogether::save";


    protected $sessionManager;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var PackFactory
     */
    protected $packFactory;


    public function __construct(Context $context, SessionManagerInterface $sessionManager, PageFactory $pageFactory, PackFactory $packFactory)
    {
        $this->packFactory = $packFactory;
        $this->resultPageFactory = $pageFactory;
        $this->sessionManager = $sessionManager;
        parent::__construct($context);
    }

    /**
     * Light icon menu
     *
     * @return \Magento\Framework\View\Result\Page
     */
    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Ecommage_BuyTogether::pack');
        return $resultPage;
    }

    /**
     * Check create form or edit form
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        // Get ID and create model
        $id = $this->getRequest()->getParam('pack_id');
        $model = $this->packFactory->create();

        $this->sessionManager->start();
        $this->sessionManager->unsMessage();

        // Initial checking
        if ($id) {
            $model = $model->load($id);

            $this->sessionManager->setMessage($model->getMainProductId());

            if (!$model->getId()) {
                $this->messageManager->addError(__('This pack no exits.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/index');
            }
        }

        // Registry
//        $this->_coreRegistry->register('pack', $model);

        // Build form
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Buy Together') : __('Create Buy Together'));

        return $resultPage;
    }
}
