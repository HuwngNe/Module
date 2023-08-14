<?php

namespace Ecommage\BuyTogether\Controller\Product;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Checkout\Model\SessionFactory;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollection;

class AddToCart extends Action
{
    /** @var SessionFactory */
    private $checkoutSession;

    /** @var CartRepositoryInterface */
    private $cartRepository;

    /**
     * @var ProductCollection
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param SessionFactory $checkoutSession
     * @param CartRepositoryInterface $cartRepository
     * @param ProductCollection $collectionFactory
     */
    public function __construct(
        Context $context,
        SessionFactory $checkoutSession,
        CartRepositoryInterface $cartRepository,
        ProductCollection $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->checkoutSession = $checkoutSession;
        $this->cartRepository = $cartRepository;
        parent::__construct($context);
    }

    /**
     * add products to cart
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $productIds = $this->getRequest()->getParam('productIds');
        $productIds = explode("/",$productIds);

        $product = $this->collectionFactory->create()->addIdFilter($productIds)->addAttributeToSelect(["price"],"left");

        foreach ($product as $item) {
            $session = $this->checkoutSession->create();
            $quote = $session->getQuote();
            $quote->addProduct($item);

            $this->cartRepository->save($quote);
        }
    }

}
