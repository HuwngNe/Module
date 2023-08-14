<?php

namespace Ecommage\FilterStore\Model\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Directory\Model\CountryFactory;

class CountryOption extends AbstractSource
{
    /**
     * @var CountryFactory
     */
    protected $countryFactory;

    /**
     * Construct
     *
     * @param CountryFactory $countryFactory
     */
    public function __construct(CountryFactory $countryFactory)
    {
        $this->countryFactory = $countryFactory;
    }

    /**
     * Take value country
     *
     * @return array
     */
    public function getAllOptions()
    {
        $options = [];
        $countries = $this->countryFactory->create()->getCollection();

        foreach ($countries as $value) {
            $country = $this->countryFactory->create()->loadByCode($value->getCountryId());
            array_push($options,['label' => $country->getName(), 'value' => $value->getCountryId()]);
        }

        return $options;
    }
}
