<?php

namespace Ecommage\BuyTogether\Block\Adminhtml\Pack\Edit;

use Ecommage\BuyTogether\Model\PackFactory;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class BackButton
 */
class BackButton extends GenericButton implements ButtonProviderInterface
{
    protected $sessionManager;

    public function __construct(Context $context, PackFactory $packFactory, SessionManagerInterface $sessionManager)
    {
        $this->sessionManager = $sessionManager;
        parent::__construct($context, $packFactory);
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        $this->sessionManager->start();
        $this->sessionManager->unsMessage();
        return $this->getUrl('*/*/index');
    }
}
