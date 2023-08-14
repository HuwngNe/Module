<?php

namespace Ecommage\BuyTogether\Controller\Adminhtml\Pack;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Ecommage\BuyTogether\Model\PackFactory;
use Ecommage\BuyTogether\Api\PackRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollection;
use Magento\Framework\Session\SessionManagerInterface;

class Save extends Action
{
    /**
     * @var PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * @var PackFactory
     */
    protected $packFactory;

    /**
     * @var PackRepositoryInterface
     */
    protected $packRepository;

    protected $collectionFactory;

    protected $productIds = [];

    protected $sessionManager;


    public function __construct(
        Context $context,
        PostDataProcessor $dataProcessor,
        PackFactory $packFactory,
        PackRepositoryInterface $packRepository,
        ProductCollection $collectionFactory,
        SessionManagerInterface $sessionManager
    ) {
        $this->sessionManager = $sessionManager;
        $this->collectionFactory = $collectionFactory;
        $this->packRepository = $packRepository;
        $this->packFactory = $packFactory;
        $this->dataProcessor = $dataProcessor;
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

//        dd($data);
        if ($data) {

            if (empty($data['pack_id'])) {
                $data['pack_id'] = null;
            }

            $model = $this->packFactory->create();
            $id = $this->getRequest()->getParam('pack_id');
            if ($id) {
                $model = $model->load($id);
            }

            if (!$this->dataProcessor->validateRequireEntry($data)) {
                return $resultRedirect->setPath('*/*/edit', ['pack_id' => $model->getId(), '_current' => true]);
            }
            if (empty($data["links"]["products"])) {
                $this->messageManager->addErrorMessage("Main Product not null");
                return $resultRedirect->setPath('*/*/edit', ['pack_id' => $model->getId(), '_current' => true]);
            }
            if (!$this->dataProcessor->checkMainProduct($data["links"]["products"])) {
                return $resultRedirect->setPath('*/*/edit', ['pack_id' => $model->getId(), '_current' => true]);
            }
            if (!$this->dataProcessor->checkBundleProduct($data["links"]["product_bundle_pack"])) {
                return $resultRedirect->setPath('*/*/edit', ['pack_id' => $model->getId(), '_current' => true]);
            }

            $data["product_ids"] = $this->convertProduct($data["links"]["product_bundle_pack"],$data["links"]["products"][0]["entity_id"]);
            $data["main_product_id"] = $data["links"]["products"][0]["entity_id"];
            $data["quantity"] = "0";

            $data["discount"] = $this->discountGroup() * $data["percent"] / 100;

            // Update model
            $model->setData($data);

            // Save data to database
            try {
                $this->packRepository->save($model);

                $this->sessionManager->start();
                $this->sessionManager->unsMessage();

                $this->messageManager->addSuccess(__('You saved the pack.'));

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['pack_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the pack.'));
            }

            return $resultRedirect->setPath('*/*/edit', ['pack_id' => $this->getRequest()->getParam('pack_id')]);
        }

        // Redirect to List page
        return $resultRedirect->setPath('*/*/index');
    }

    private function convertProduct($array, $mainPro) {
        $id = [];
        foreach ($array as $item) {
            $id[] = $item["entity_id"];
        }
        if (!in_array($mainPro,$id)) {
            $id[] = $mainPro;
        }
        sort($id);

        $this->productIds = $id;

        $string = "";
        if (count($id) > 0) {
            foreach ($id as $value) {
                $string .= $value."/";
            }
            return rtrim($string,"/");
        }
        return $string;
    }

    private function discountGroup() {
        $product = $this->collectionFactory->create()->addIdFilter($this->productIds)->addAttributeToSelect("price","left");

        $count = 0;
        foreach ($product as $item) {
            $count += $item->getPrice();
        }

        return $count;
    }
}
