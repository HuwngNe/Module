<?php

namespace Ecommage\BuyTogether\Model;

use Ecommage\BuyTogether\Api\Data\PackInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

class Pack extends AbstractExtensibleModel implements PackInterface, IdentityInterface
{
    const CACHE_TAG = 'ecommage_buytogether_pack';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Pack::class);
        $this->setIdFieldName('pack_id');
    }

    /**
     * @return string[]
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getPackId()];
    }

    /**
     * @return int
     */
    public function getPackId(): int
    {
        return $this->getData(self::PACK_ID);
    }

    /**
     * @return string
     */
    public function getTitle():string
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->getData(self::QUANTITY);
    }

    /**
     * @return int
     */
    public function getMainProductId(): int
    {
        return $this->getData(self::MAIN_PRODUCT_ID);
    }

    /**
     * @return string
     */
    public function getProductIds(): string
    {
        return $this->getData(self::PRODUCT_IDS);
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @return float
     */
    public function getPercent(): float
    {
        return $this->getData(self::PERCENT);
    }

    public function getDiscount(): float
    {
        return $this->getData(self::DISCOUNT);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @return string
     */
    public function getUpdateAt(): string
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @param int $packId
     * @return PackInterface
     */
    public function setPackId(int $packId): PackInterface
    {
        return $this->setData(self::PACK_ID, $packId);
    }

    /**
     * @param string $title
     * @return PackInterface
     */
    public function setTitle(string $title): PackInterface
    {
        return $this->setData(self::TITLE,$title);
    }

    /**
     * @param int $quantity
     * @return PackInterface
     */
    public function setQuantity(int $quantity): PackInterface
    {
        return $this->setData(self::QUANTITY, $quantity);
    }

    /**
     * @param int $mainProductId
     * @return PackInterface
     */
    public function setMainProductId(int $mainProductId): PackInterface
    {
        return $this->setData(self::MAIN_PRODUCT_ID, $mainProductId);
    }

    /**
     * @param string $productIds
     * @return PackInterface
     */
    public function setProductIds(string $productIds): PackInterface
    {
        return $this->setData(self::PRODUCT_IDS,$productIds);
    }

    /**
     * @param int $status
     * @return PackInterface
     */
    public function setStatus(int $status): PackInterface
    {
        return $this->setData(self::PACK_ID, $status);
    }

    /**
     * @param float $percent
     * @return PackInterface
     */
    public function setPercent(float $percent): PackInterface
    {
        return $this->setData(self::PERCENT, $percent);
    }

    public function setDiscount(float $discount): PackInterface
    {
        return $this->setData(self::DISCOUNT, $discount);
    }

    /**
     * @param string $createdAt
     * @return PackInterface
     */
    public function setCreatedAt(string $createdAt): PackInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @param string $updatedAt
     * @return PackInterface
     */
    public function setUpdatedAt(string $updatedAt): PackInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * Prepare data before saving
     *
     * @return PackInterface
     */
    public function beforeSave(): PackInterface
    {
        if ($this->hasDataChanges()) {
            $this->setUpdatedAt(date("Y-m-d H:i:s"));
        }
        return parent::beforeSave();
    }
}
