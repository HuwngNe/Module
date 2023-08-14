<?php

namespace Ecommage\FilterStore\Controller\Adminhtml\Location;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\App\Action;
use Ecommage\FilterStore\Model\LocationFactory;
use Ecommage\FilterStore\Api\LocationRepositoryInterface;

class MassDelete extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Ecommage_FilterStore::block';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var LocationFactory
     */
    protected $collectionFactory;

    /**
     * @var LocationRepositoryInterface
     */
    protected $locationRepository;
    /**
     * Construct
     *
     * @param Context $context
     * @param Filter $filter
     * @param LocationFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, LocationFactory $collectionFactory, LocationRepositoryInterface $locationRepository)
    {
        $this->locationRepository = $locationRepository;
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
            $this->locationRepository->deleteById($data[$i]['location_id']);
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/index');
    }
}
