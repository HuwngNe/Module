<?php

namespace Ecommage\BuyTogether\Helper;

use Ecommage\BuyTogether\Model\ResourceModel\Pack\CollectionFactory as PackCollection;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Checkout\Model\Session;

class CheckPercent extends AbstractHelper
{
    /**
     * @var CartRepositoryInterface
     */
    protected $cartRepository;

    /**
     * @var PackCollection
     */
    protected $packCollection;

    /**
     * @var null
     */
    protected $packId = null;

    /**
     * @var Session
     */
    protected $__session;

    /**
     * @param Context $context
     * @param PackCollection $packCollection
     * @param CartRepositoryInterface $cartRepository
     * @param Session $session
     */
    public function __construct(Context $context, PackCollection $packCollection, CartRepositoryInterface $cartRepository, Session $session)
    {
        $this->packCollection = $packCollection;
        $this->cartRepository = $cartRepository;
        $this->__session = $session;
        parent::__construct($context);
    }

    /**
     * @return int|mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function checkPercent() {

        $qid = $this->__session->getQuoteId();

        if (empty($qid)) return 0;

        $quoteCa = $this->cartRepository->get($qid);
        $items = $quoteCa->getItems();

        return $this->checkProductInCart($items);

    }

    /**
     * check product in cart has in the bundle pack
     *
     * @param $items
     * @return int|mixed
     */
    public function checkProductInCart($items) {
        if (empty($items)) return 0;

        $productId = [];
        foreach ($items as $item) {
            $productId[] = $item->getProductId();
        }
        sort($productId);

        $productId = implode("/", $productId);

        $quote = $this->packCollection->create()
            ->addFieldToFilter("product_ids",["like"=>$productId])
            ->addFieldToFilter("status",["eq"=>1])->setOrder("discount","desc")->getData();

        if (empty($quote)) {
            $totalPack = $this->packCollection->create()->addFieldToFilter("status",["eq"=>1])->setOrder("discount","desc")->getData();

            if (empty($totalPack)) return 0;

            $totalProductIds = [];
            foreach ($totalPack as $item) {
                $totalProductIds[] = $item["product_ids"];
            }

            $index = -1;
            $maxDiscount = 0;
            for ($i = 0; $i < count($totalProductIds); $i++) {
                if (strpos($productId,$totalProductIds[$i]) > -1) {
                    if ($maxDiscount < $totalPack[$i]["discount"]) {
                        $index = $i;
                        $maxDiscount = $totalPack[$i]["discount"];
                        break;
                    }
                }
            }

            if ($index == -1) return 0;

            $this->setPackId($totalPack[$index]["pack_id"]);
            return $maxDiscount;
        }

        $this->setPackId($quote[0]["pack_id"]);
        return $quote[0]["discount"];
    }

    /**
     * @param $id
     * @return void
     */
    private function setPackId($id) {
        $this->packId = $id;
    }

    /**
     * @return int
     */
    public function getPackId() {
        return $this->packId;
    }
}
