<?php

namespace Ecommage\BuyTogether\Block;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\View;
use Magento\Catalog\Helper\Product;
use Magento\Catalog\Model\ProductTypes\ConfigInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Locale\FormatInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Stdlib\StringUtils;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollection;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Ecommage\BuyTogether\Model\ResourceModel\Pack\CollectionFactory as PackCollection;

class Index extends View
{
    /**
     * @var ProductCollection
     */
    protected $collectionFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var PackCollection
     */
    protected $packCollection;

    protected $discount;

    public function __construct(
        Context $context,
        ProductCollection $collectionFactory,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        EncoderInterface           $jsonEncoder,
        StringUtils                $string,
        Product                    $productHelper,
        ConfigInterface            $productTypeConfig,
        FormatInterface            $localeFormat,
        Session                    $customerSession,
        ProductRepositoryInterface $productRepository,
        PriceCurrencyInterface     $priceCurrency,
        StoreManagerInterface      $storeManager,
        PackCollection             $packCollection,
        array $data = []
    ) {
        $this->packCollection = $packCollection;
        $this->storeManager = $storeManager;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $urlEncoder, $jsonEncoder, $string, $productHelper, $productTypeConfig, $localeFormat, $customerSession, $productRepository, $priceCurrency, $data);
    }

    /**
     * @return array|\Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getBTogether() {
         $productId = $this->getProduct()->getId();

         $product = $this->packCollection->create()->addFieldToFilter("main_product_id",["eq"=>$productId])->addFieldToFilter("status",["eq"=>1])->getData();

         if (empty($product)) return [];

         $this->setDiscount($product[0]["discount"]);

         $productIds = $product[0]["product_ids"];

         $productIds = explode("/",$productIds);

         $products = $this->collectionFactory->create()->addIdFilter($productIds)->addAttributeToSelect(["name","thumbnail","price"],"left");

         return $products;
    }

    public function getThumnailUrl() {
        return $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA). 'catalog/product';
    }

    public function setDiscount($discount) {
        $this->discount = $discount;
    }

    public function getDiscount() {
        return $this->discount;
    }
}
