<?php

namespace Ecommage\BuyTogether\Model\Pack;

use Ecommage\BuyTogether\Model\ResourceModel\Pack\CollectionFactory as PackCollection;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollection;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Framework\Registry;
use Magento\Framework\App\RequestInterface;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var PackCollection
     */
    protected $collection;

    protected $productCollection;

    protected $imageHelper;

    protected $registry;
    /**
     * @var
     */
    protected $loadedData;

    protected $request;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param Registry $registry
     * @param ImageHelper $imageHelper
     * @param ProductCollection $productCollection
     * @param PackCollection $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(string $name, string $primaryFieldName, string $requestFieldName, RequestInterface $request, Registry $registry, ImageHelper $imageHelper, ProductCollection $productCollection, PackCollection $collectionFactory,  array $meta = [], array $data = [])
    {
        $this->request = $request;
        $this->registry = $registry;
        $this->imageHelper = $imageHelper;
        $this->productCollection = $productCollection;
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     */
    public function getData()
    {
        // Get items
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $data = $this->collection->getData();
        if (!empty($data)) {
            if (!empty($data[0]['product_ids'])) {
                $productIds = explode('/', $data[0]['product_ids']);

                for ($i = 0; $i < count($productIds); $i++) {
                    if ($productIds[$i] == $data[0]["main_product_id"]) {
                        unset($productIds[$i]);
                        break;
                    }
                }

                $data[0]['links']['product_bundle_pack'] = $this->getReviewProducts($productIds);
                $data[0]['links']['products'] = $this->getReviewProducts($data[0]["main_product_id"]);
                $this->loadedData[$data[0]["pack_id"]] = $data[0];
            }
        }
        return $this->loadedData;
    }

    private function getReviewProducts($productIds)
    {
        if ($productIds) {
            $productCollection = $this->productCollection->create();
            $productCollection->addIdFilter($productIds)
                ->addAttributeToSelect(['status', 'thumbnail', 'name', 'price'], 'left');

            $result = [];
            foreach ($productCollection->getItems() as $product) {
                $result[] = $this->fillData($product);
            }
            return $result;
        }

        return null;
    }

    private function fillData($product)
    {
        return [
            'entity_id' => $product->getId(),
            'thumbnail' => $this->imageHelper->init($product, 'product_listing_thumbnail')->getUrl(),
            'name' => $product->getName(),
            'sku' => $product->getSku(),
            'price' => $product->getPrice()
        ];
    }
}
