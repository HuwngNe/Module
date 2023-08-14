<?php

namespace Ecommage\BuyTogether\Plugin;

use Magento\Ui\Controller\Adminhtml\Index\Render;
use Magento\Ui\Component\Filters\FilterModifier;
use Magento\Framework\Session\SessionManagerInterface;

class SaveMainProductId
{
    const FILTER_MODIFIER = 'filters_modifier';

    protected $cookieManager;

    protected $filterModifier;

    protected $sessionManager;

    public function __construct(FilterModifier $filterModifier, SessionManagerInterface $sessionManager)
    {
        $this->sessionManager = $sessionManager;
        $this->filterModifier = $filterModifier;
    }

    public function afterExecute(Render $subject, $result)
    {
        if ($subject->getRequest()->getParam("isAjax")) {
            if ($subject->getRequest()->getParam("namespace") === "ecommage_product_listing") {
                if ($subject->getRequest()->getParam(self::FILTER_MODIFIER)) {
                    $filterModifier = $subject->getRequest()->getParam(self::FILTER_MODIFIER);
                    if (!empty($filterModifier["entity_id"]["value"])) {
                        $productIds = implode("/",$filterModifier["entity_id"]["value"]);
                        $this->sessionManager->start();
                        $this->sessionManager->setMessage($productIds);
                    }
                }
            }
        }
        return $result;
    }
}
