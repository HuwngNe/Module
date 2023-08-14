<?php

namespace Ecommage\BuyTogether\Ui\DataProvider\Listing;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollection;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\Message\ManagerInterface;

class ProductDataProviderE extends \Magento\Catalog\Ui\DataProvider\Product\ProductDataProvider
{
    protected $cookieManager;

    protected $managerInterface;

    protected $sessionManager;

    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        ProductCollection $collectionFactory,
        ManagerInterface $managerInterface,
        SessionManagerInterface $sessionManager,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $collectionFactory,
            $addFieldStrategies,
            $addFilterStrategies,
            $meta,
            $data
        );
        $this->sessionManager = $sessionManager;
        $this->managerInterface = $managerInterface;
        $this->collection->addAttributeToSelect(['status', 'thumbnail', 'name', 'price'], 'left');
    }

    /**
     * @return array
     */
    public function getData()
    {
        $idPro = $this->sessionManager->getMessage();
        if (!empty($idPro)) {
            $idPro = explode("/",$idPro);
            $this->collection->addFieldToFilter("entity_id",["nin"=>$idPro]);

        }
        return parent::getData();
    }
}
