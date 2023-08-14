<?php

namespace Ecommage\FilterStore\Controller\Adminhtml\Location;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Ecommage\FilterStore\Model\LocationFactory;
use Ecommage\FilterStore\Api\LocationRepositoryInterface;

class Edit extends Action
{
    const ADMIN_RESOURCE = "Ecommage_FilterStore::save";

    /**
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var LocationFactory
     */
    protected $locationFactory;

    /**
     * @var LocationRepositoryInterface
     */
    protected $locationRepository;

    /**
     * Construct
     *
     * @param Context $context
     * @param Registry $registry
     * @param PageFactory $pageFactory
     * @param LocationFactory $locationFactory
     */
    public function __construct(Context $context, Registry $registry, PageFactory $pageFactory, LocationFactory $locationFactory, LocationRepositoryInterface $locationRepository)
    {
        $this->locationRepository = $locationRepository;
        $this->locationFactory = $locationFactory;
        $this->resultPageFactory = $pageFactory;
        $this->_coreRegistry = $registry;
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
        $resultPage->setActiveMenu('Ecommage_LocationStore::location');
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
        $id = $this->getRequest()->getParam('location_id');
        $model = $this->locationFactory->create();

        // Initial checking
        if ($id) {
            $model = $this->locationRepository->getById($id);

            if (!$model->getId()) {
                $this->messageManager->addError(__('This location no exits.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/index');
            }
        }

        // Registry
        $this->_coreRegistry->register('location', $model);

        // Build form
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Location Store') : __('Create Location Store'));

        return $resultPage;
    }
}
