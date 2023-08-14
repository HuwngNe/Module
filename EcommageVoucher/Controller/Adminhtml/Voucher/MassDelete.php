<?php

namespace Ecommage\EcommageVoucher\Controller\Adminhtml\Voucher;

use Magento\Backend\App\Action\Context;
use Ecommage\EcommageVoucher\Model\VoucherFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\App\Action;
use Ecommage\EcommageVoucher\Api\VoucherRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;

class MassDelete extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Ecommage_EcommageVoucher::block';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var VoucherFactory
     */
    protected $collectionFactory;

    /**
     * @var VoucherRepositoryInterface
     */
    protected $voucherRepository;

    public function __construct(Context $context, Filter $filter, VoucherFactory $collectionFactory, VoucherRepositoryInterface $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Delete many item voucher
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create()->getCollection());
            $data = $collection->getData();
            $collectionSize = $collection->getSize();
            for ($i = 0; $i < $collectionSize; $i++) {
                $this->voucherRepository->deleteById($data[$i]['voucher_id']);
            }

            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        } catch (LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        }
        return $resultRedirect->setPath('*/*/index');
    }
}
