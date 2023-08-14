<?php

namespace Ecommage\FilterStore\Block\Adminhtml\Location\Edit;

use Magento\Backend\Block\Widget\Context;
use Ecommage\FilterStore\Model\LocationFactory;

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
     * @var LocationFactory
     */
    protected $locationFactory;

    /**
     * Construct
     *
     * @param Context $context
     * @param LocationFactory $locationFactory
     */
    public function __construct(
        Context $context,
        LocationFactory $locationFactory
    ) {
        $this->context = $context;
        $this->locationFactory = $locationFactory;
    }

    /**
     * Return CMS page ID
     *
     * @return int|null
     */
    public function getPost()
    {
        $id = $this->context->getRequest()->getParam('location_id');
        $post = $this->locationFactory->create()->load($id);
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
