<?php

namespace Ecommage\BuyTogether\Ui\Component\Listing\Column\Pack;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Catalog\Api\ProductRepositoryInterface;

class MainProduct  extends Column
{
    protected $productRepository;

    public function __construct(ContextInterface $context, ProductRepositoryInterface $productRepository, UiComponentFactory $uiComponentFactory, array $components = [], array $data = [])
    {
        $this->productRepository = $productRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        for ($i = 0; $i < count($dataSource["data"]["items"]); $i++) {
            $pro = $this->productRepository->getById($dataSource["data"]["items"][$i]["main_product_id"]);
            $dataSource["data"]["items"][$i]["main_product"] = $pro->getName();
        }

        return $dataSource;
    }
}
