<?php

namespace Ecommage\EcommageVoucher\Model;

use Ecommage\EcommageVoucher\Api\Data\VoucherInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

class Voucher extends AbstractExtensibleModel implements VoucherInterface, IdentityInterface
{
    const CACHE_TAG = 'ecommage_ecommagevoucher_voucher';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Voucher::class);
        $this->setIdFieldName('voucher_id');
    }

    /**
     * @return string[]
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getVoucherId()];
    }

    /**
     * @return int
     */
    public function getVoucherId(): int
    {
        return $this->getData(self::VOUCHER_ID);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getData(self::TITLE);
    }

    public function getPercent(): float
    {
        return $this->getData(self::PERCENT);
    }

    public function getStartDate(): string
    {
        return $this->getData(self::START_DATE);
    }

    public function getEndDate(): string
    {
        return $this->getData(self::END_DATE);
    }

    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }

    public function getUpdatedAt(): string
    {
        return $this->getData(self::UPDATED_AT);
    }

    public function getStatus(): int
    {
        return $this->getData(self::STATUS);
    }

    public function setVoucherId(int $voucherId): VoucherInterface
    {
        return $this->setData(self::VOUCHER_ID, $voucherId);
    }

    public function setTitle(string $title): VoucherInterface
    {
        return $this->setData(self::TITLE, $title);
    }

    public function setPercent(float $percent): VoucherInterface
    {
        return $this->setData(self::PERCENT, $percent);
    }

    public function setStartDate(string $startDate): VoucherInterface
    {
        return $this->setData(self::START_DATE, $startDate);
    }

    public function setEndDate(string $endData): VoucherInterface
    {
        return $this->setData(self::END_DATE, $endData);
    }

    public function setCreatedAt(string $createdAt): VoucherInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function setUpdatedAt(string $updatedAt): VoucherInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    public function setStatus(int $status): VoucherInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Prepare data before saving
     *
     * @return VoucherInterface
     */
    public function beforeSave(): VoucherInterface
    {
        if ($this->hasDataChanges()) {
            $this->setUpdatedAt(date("Y-m-d H:i:s"));
        }
        return parent::beforeSave();
    }
}
