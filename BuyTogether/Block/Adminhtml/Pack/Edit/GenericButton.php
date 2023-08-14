<?php

namespace Ecommage\BuyTogether\Block\Adminhtml\Pack\Edit;

use Magento\Backend\Block\Widget\Context;
use Ecommage\BuyTogether\Model\PackFactory;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var PackFactory
     */
    protected $packFactory;

    /**
     * Construct
     *
     * @param Context $context
     * @param PackFactory $packFactory
     */
    public function __construct(
        Context $context,
        PackFactory $packFactory
    ) {
        $this->context = $context;
        $this->packFactory = $packFactory;
    }

    /**
     * Return CMS page ID
     *
     * @return int|null
     */
    public function getPost()
    {
        $id = $this->context->getRequest()->getParam('pack_id');
        $post = $this->packFactory->create()->load($id);
        if ($post->getId()) return $id;
        return null;
    }

    /**
     * Generate url by route and parameters
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
