<?php

namespace Ecommage\BuyTogether\Controller\Adminhtml\Pack;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Ecommage\BuyTogether\Model\PackFactory;
use Ecommage\BuyTogether\Api\PackRepositoryInterface;
use Magento\Framework\Session\SessionManagerInterface;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Ecommage_BuyTogether::delete';

    /**
     * @var PackFactory
     */
    protected $packFactory;

    /**
     * @var PackRepositoryInterface
     */
    protected $packRepository;

    protected $sessionManager;


    public function __construct(Context $context, PackFactory $packFactory, PackRepositoryInterface $packRepository, SessionManagerInterface $sessionManager)
    {
        $this->sessionManager = $sessionManager;
        $this->packRepository = $packRepository;
        $this->packFactory = $packFactory;
        parent::__construct($context);
    }

    /**
     * Delete item pack
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('pack_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $this->packRepository->deleteById($id);

                $this->sessionManager->start();
                $this->sessionManager->unsMessage();

                // Display success message
                $this->messageManager->addSuccess(__('The pack has been deleted.'));

                // Redirect to list page
                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                // Display error message
                $this->messageManager->addError($e->getMessage());
                // Go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['pack_id' => $id]);
            }
        }

        // Display error message
        $this->messageManager->addError(__('We can\'t find a pack to delete.'));

        // Redirect to list page
        return $resultRedirect->setPath('*/*/index');
    }
}
