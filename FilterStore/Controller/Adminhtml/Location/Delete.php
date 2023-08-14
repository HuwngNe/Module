<?php

namespace Ecommage\FilterStore\Controller\Adminhtml\Location;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Ecommage\FilterStore\Model\LocationFactory;
use Ecommage\FilterStore\Api\LocationRepositoryInterface;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Ecommage_FilterStore::delete';

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
     * @param LocationFactory $locationFactory
     */
    public function __construct(Context $context, LocationFactory $locationFactory, LocationRepositoryInterface $locationRepository)
    {
        $this->locationRepository = $locationRepository;
        $this->locationFactory = $locationFactory;
        parent::__construct($context);
    }

    /**
     * Delete item location
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('location_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $this->locationRepository->deleteById($id);

                // Display success message
                $this->messageManager->addSuccess(__('The location has been deleted.'));

                // Redirect to list page
                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                // Display error message
                $this->messageManager->addError($e->getMessage());
                // Go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['location_id' => $id]);
            }
        }

        // Display error message
        $this->messageManager->addError(__('We can\'t find a location to delete.'));

        // Redirect to list page
        return $resultRedirect->setPath('*/*/index');
    }
}
