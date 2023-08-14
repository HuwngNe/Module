<?php

namespace Ecommage\EcommageVoucher\Controller\Adminhtml\Voucher;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Ecommage\EcommageVoucher\Api\VoucherRepositoryInterface;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Ecommage_EcommageVoucher::delete';

    /**
     * @var VoucherRepositoryInterface
     */
    protected $voucherRepository;

    /**
     * @param Context $context
     * @param VoucherRepositoryInterface $voucherRepository
     */
    public function __construct(Context $context, VoucherRepositoryInterface $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
        parent::__construct($context);
    }

    /**
     * Delete item voucher
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('voucher_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $this->voucherRepository->deleteById($id);

                // Display success message
                $this->messageManager->addSuccess(__('The voucher has been deleted.'));

                // Redirect to list page
                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                // Display error message
                $this->messageManager->addError($e->getMessage());
                // Go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['voucher_id' => $id]);
            }
        }

        // Display error message
        $this->messageManager->addError(__('We can\'t find a voucher to delete.'));

        // Redirect to list page
        return $resultRedirect->setPath('*/*/index');
    }
}
