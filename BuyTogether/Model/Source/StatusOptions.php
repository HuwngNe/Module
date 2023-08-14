<?php

namespace Ecommage\BuyTogether\Model\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Ecommage\BuyTogether\Api\PackRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

class StatusOptions extends AbstractSource
{
    protected $packRepository;

    protected $searchCriteria;

    public function __construct(PackRepositoryInterface $packRepository, SearchCriteriaInterface $searchCriteria)
    {
        $this->packRepository = $packRepository;
        $this->searchCriteria = $searchCriteria;
    }

    public function getAllOptions()
    {
        $options = [
            [
                "label" => "Active",
                "value" =>  1
            ],
            [
                "label" => "Non Active",
                "value" => 2
            ]
        ];
        return $options;
    }
}
