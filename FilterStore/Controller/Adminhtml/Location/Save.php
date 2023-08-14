<?php

namespace Ecommage\FilterStore\Controller\Adminhtml\Location;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Ecommage\FilterStore\Model\LocationFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Ecommage\FilterStore\Api\LocationRepositoryInterface;

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
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     * @param LocationFactory $locationFactory
     */
    public function __construct(
        Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor,
        LocationFactory $locationFactory,
        LocationRepositoryInterface $locationRepository
    ) {
        $this->locationRepository = $locationRepository;
        $this->locationFactory = $locationFactory;
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save form
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {

            if (empty($data['location_id'])) {
                $data['location_id'] = null;
            }

            $model = $this->locationFactory->create();
            $id = $this->getRequest()->getParam('location_id');
            if ($id) {
                $model = $this->locationRepository->getById($id);
            }

            if (!$this->dataProcessor->validateRequireEntry($data)) {

                return $resultRedirect->setPath('*/*/edit', ['location_id' => $model->getId(), '_current' => true]);
            }

            $data["product_ids"] = $this->convertProduct($data["products"]);

            // Update model
            $model->setData($data);

            // Save data to database
            try {
                $this->locationRepository->save($model);

                $this->messageManager->addSuccess(__('You saved the location.'));
                $this->dataPersistor->clear('location');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['location_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the location.'));
            }

            $this->dataPersistor->set('location', $data);
            return $resultRedirect->setPath('*/*/edit', ['location_id' => $this->getRequest()->getParam('id')]);
        }

        // Redirect to List page
        return $resultRedirect->setPath('*/*/index');
    }

    private function convertProduct($array) {
        $string = "";
        if (count($array) > 0) {
            foreach ($array as $value) {
                $string .= $value["entity_id"]."/";
            }
            return rtrim($string,"/");
        }
        return $string;
    }
}
