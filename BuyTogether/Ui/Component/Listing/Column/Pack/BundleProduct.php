<?php

namespace Ecommage\BuyTogether\Ui\Component\Listing\Column\Pack;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollection;

class BundleProduct extends Column
{
    protected $collectionFactory;

    public function __construct(ContextInterface $context, ProductCollection $collectionFactory, UiComponentFactory $uiComponentFactory, array $components = [], array $data = [])
    {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        for ($i = 0; $i < count($dataSource["data"]["items"]); $i++) {
            $productIds = explode('/', $dataSource["data"]["items"][$i]["product_ids"]);
            $pro = $this->collectionFactory->create()->addIdFilter($productIds)->addAttributeToSelect("name","left");
            $stringName = "";
            foreach ($pro as $item) {
                $stringName .= $item->getName().", ";

            }
            $stringName = rtrim($stringName,", ");
            $dataSource["data"]["items"][$i]["bundle_pack_product"] = $stringName;
        }
        return $dataSource;
    }
}
