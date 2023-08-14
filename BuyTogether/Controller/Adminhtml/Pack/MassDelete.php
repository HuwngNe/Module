<?php

namespace Ecommage\BuyTogether\Controller\Adminhtml\Pack;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\App\Action;
use Ecommage\BuyTogether\Model\PackFactory;
use Ecommage\BuyTogether\Api\PackRepositoryInterface;

class MassDelete extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Ecommage_BuyTogether::block';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var PackFactory
     */
    protected $collectionFactory;

    /**
     * @var PackRepositoryInterface
     */
    protected $packRepository;

    protected $sessionManager;

    public function __construct(Context $context, Filter $filter, PackFactory $collectionFactory, PackRepositoryInterface $packRepository, SessionManagerInterface $sessionManager)
    {
        $this->sessionManager = $sessionManager;
        $this->packRepository = $packRepository;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Delete many items
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create()->getCollection());
        $data = $collection->getData();
        $collectionSize = $collection->getSize();
        for ($i = 0; $i < $collectionSize; $i++) {
            $this->packRepository->deleteById($data[$i]['pack_id']);
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

        $this->sessionManager->start();
        $this->sessionManager->unsMessage();

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/index');
    }
}
