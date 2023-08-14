<?php

namespace Ecommage\FilterStore\Ui\Component\Listing\Column\Location;

use Magento\Directory\Model\CountryFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class CountryName extends Column
{
    /**
     * @var CountryFactory
     */
    protected $countryFactory;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param CountryFactory $countryFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        CountryFactory $countryFactory,
        array $components = [],
        array $data = []
    ) {
        $this->countryFactory = $countryFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Take data full name country
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        $count = count($dataSource["data"]["items"]);
        for ($i = 0; $i < $count; $i++) {
            $dataSource["data"]["items"][$i]["country_name"] = $this->countryFactory->create()->loadByCode($dataSource["data"]["items"][$i]["country_id"])->getName();
        }

        return $dataSource;
    }

}
