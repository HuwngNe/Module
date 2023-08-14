<?php

namespace Ecommage\EcommageVoucher\Block\Adminhtml\Voucher\Edit;

use Magento\Backend\Block\Widget\Context;
use Ecommage\EcommageVoucher\Model\VoucherFactory;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    protected $voucherFactory;


    public function __construct(
        Context $context,
        VoucherFactory $voucherFactory
    ) {
        $this->context = $context;
        $this->voucherFactory = $voucherFactory;
    }

    /**
     * Return CMS page ID
     *
     * @return int|null
     */
    public function getPost()
    {
        $id = $this->context->getRequest()->getParam('voucher_id');
        $post = $this->voucherFactory->create()->load($id);
        if ($post->getId())
            return $id;
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
