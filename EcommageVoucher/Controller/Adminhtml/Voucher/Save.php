<?php

namespace Ecommage\EcommageVoucher\Controller\Adminhtml\Voucher;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Ecommage\EcommageVoucher\Model\VoucherFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Ecommage\EcommageVoucher\Api\VoucherRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action
{
    /**
     * @var PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var VoucherFactory
     */
    protected $voucherFactory;

    /**
     * @var VoucherRepositoryInterface
     */
    protected $voucherRepository;

    /**
     * @param Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     * @param VoucherFactory $voucherFactory
     */
    public function __construct(
        Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor,
        VoucherFactory $voucherFactory,
        VoucherRepositoryInterface $voucherRepository
    ) {
        $this->voucherRepository = $voucherRepository;
        $this->voucherFactory = $voucherFactory;
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save voucher
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            if (empty($data['voucher_id'])) {
                $data['voucher_id'] = null;
            }

            $model = $this->voucherFactory->create();
            $id = $this->getRequest()->getParam('voucher_id');
            if ($id) {
                try {
                    $model = $this->voucherRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This voucher no longer exists.'));
                    return $resultRedirect->setPath('*/*/index');
                }
            }

            if (!$this->dataProcessor->validateRequireEntry($data)) {

                return $resultRedirect->setPath('*/*/edit', ['voucher_id' => $model->getId(), '_current' => true]);
            }

            // Update model
            $model->setData($data);

            // Save data to database
            try {
                $this->voucherRepository->save($model);
                $this->messageManager->addSuccess(__('You saved the voucher.'));
                $this->dataPersistor->clear('voucher');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['voucher_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage(__('This voucher no longer exists.'));
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the voucher.'));
            }
            $this->dataPersistor->set('voucher', $data);
            return $resultRedirect->setPath('*/*/edit', ['voucher_id' => $this->getRequest()->getParam('id')]);
        }
        // Redirect to List page
        return $resultRedirect->setPath('*/*/index');
    }

}
