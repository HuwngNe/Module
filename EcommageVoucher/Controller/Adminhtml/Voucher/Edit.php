<?php

namespace Ecommage\EcommageVoucher\Controller\Adminhtml\Voucher;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Ecommage\EcommageVoucher\Model\VoucherFactory;

class Edit extends Action
{
    const ADMIN_RESOURCE = "Ecommage_EcommageVoucher::save";

    /**
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var VoucherFactory
     */
    protected $voucherFactory;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param PageFactory $pageFactory
     * @param VoucherFactory $voucherFactory
     */
    public function __construct(Context $context, Registry $registry, PageFactory $pageFactory, VoucherFactory $voucherFactory)
    {
        $this->voucherFactory = $voucherFactory;
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
        $resultPage->setActiveMenu('Ecommage_EcommageVoucher::voucher');
        return $resultPage;
    }

    /**
     * Check create form of edit form
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        // Get ID and create model
        $id = $this->getRequest()->getParam('voucher_id');
        $model = $this->voucherFactory->create();

        // Initial checking
        if ($id) {
            $model->load($id);

            if (!$model->getId()) {
                $this->messageManager->addError(__('This voucher no exits.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/index');
            }
        }

        // Registry
        $this->_coreRegistry->register('voucher', $model);

        // Build form
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Voucher') : __('Create Voucher'));

        return $resultPage;
    }
}
