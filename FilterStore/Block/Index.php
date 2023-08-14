<?php

namespace Ecommage\FilterStore\Block;

use Ecommage\FilterStore\Model\ResourceModel\Location\CollectionFactory as LocationCollection;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Block\Product\View;
use Magento\Framework\Locale\FormatInterface;
use Magento\Catalog\Model\ProductTypes\ConfigInterface;
use Magento\Catalog\Helper\Product;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Stdlib\StringUtils;
use Magento\Customer\Model\Session;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Catalog\Block\Product\Context;

class Index extends View
{
    /**
     * @var LocationCollection
     */
    protected $collectionFactory;

    /**
     * @var array
     */
    protected $region;

    /**
     * @var array
     */
    protected $city;

    /**
     * @param Context $context
     * @param LocationCollection $collectionFactory
     * @param \Magento\Framework\Url\EncoderInterface $urlEncoder
     * @param EncoderInterface $jsonEncoder
     * @param StringUtils $string
     * @param Product $productHelper
     * @param ConfigInterface $productTypeConfig
     * @param FormatInterface $localeFormat
     * @param Session $customerSession
     * @param ProductRepositoryInterface $productRepository
     * @param PriceCurrencyInterface $priceCurrency
     * @param array $data
     */
    public function __construct(
        Context $context,
        LocationCollection $collectionFactory,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        EncoderInterface $jsonEncoder,
        StringUtils $string,
        Product $productHelper,
        ConfigInterface $productTypeConfig,
        FormatInterface $localeFormat,
        Session $customerSession,
        ProductRepositoryInterface $productRepository,
        PriceCurrencyInterface $priceCurrency,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->region = [];
        $this->city = [];
        parent::__construct($context, $urlEncoder, $jsonEncoder, $string, $productHelper, $productTypeConfig, $localeFormat, $customerSession, $productRepository, $priceCurrency, $data);
    }

    /**
     * get All Infor Stores have this product
     *
     * @return \Ecommage\FilterStore\Model\ResourceModel\Location\Collection | string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getLocationStore() {
        $idProduct = $this->getProduct()->getId();

        if ($this->productRepository->getById($idProduct)->getQuantityAndStockStatus()['qty'] > 0) {
            $location = $this->collectionFactory->create();
            $location->addFieldToFilter("product_ids",[["like"=>"%/".$idProduct."/%"],["like"=>$idProduct."/%"],["like"=>"%/".$idProduct]]);

            $check = [];
            $checkCity = [];

            foreach ($location as $value) {
                if (!in_array($value->getRegionId(),$check)) {
                    array_push($this->region,[
                        "id"     =>  $value->getRegionId(),
                        "label"  =>  $value->getDefaultName()
                    ]);

                    array_push($check,$value->getRegionId());
                }

                if (!in_array($value->getRegionId(),$checkCity)) {
                    array_push($this->city, [
                        "id" => $value->getCityId(),
                        "region_id" => $value->getRegionId(),
                        "label" => $value->getName()
                    ]);

                    array_push($checkCity,$value->getCityId());
                }
            }

            return $location;
        }

        return "";
    }

    /**
     * Cities of stores have this product
     *
     * @return array
     */
    public function getAllRegion() {
        return $this->region;
    }

    /**
     * Wards of stores have this product
     *
     * @return array
     */
    public function getAllCity() {
        return $this->city;
    }
}
