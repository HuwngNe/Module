<?php

namespace Ecommage\EcommageVoucher\Model;

use Ecommage\EcommageVoucher\Api\Data\VoucherCustomerInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

class VoucherCustomer extends AbstractExtensibleModel implements VoucherCustomerInterface, IdentityInterface
{
    const CACHE_TAG = 'ecommage_ecommagevoucher_vouchercustomer';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\VoucherCustomer::class);
        $this->setIdFieldName('vcus_id');
    }

    /**
     * @return string[]
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getVcusId()];
    }

    /**
     * @return int
     */
    public function getVcusId(): int
    {
        return $this->getData(self::VCUS_ID);
    }

    /**
     * @return int
     */
    public function getVoucherId(): int
    {
        return $this->getData(self::VOUCHER_ID);
    }

    public function getCustomerId(): int
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    public function getEmail(): string
    {
        return $this->getData(self::EMAIL);
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

    public function setVcusId(int $vcusId): VoucherCustomerInterface
    {
        return $this->setData(self::VCUS_ID, $vcusId);
    }

    public function setVoucherId(int $voucherId): VoucherCustomerInterface
    {
        return $this->setData(self::VOUCHER_ID, $voucherId);
    }

    public function setCustomerId(int $customerId): VoucherCustomerInterface
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    public function setEmail(string $email): VoucherCustomerInterface
    {
        return $this->setData(self::EMAIL, $email);
    }

    public function setCreatedAt(string $createdAt): VoucherCustomerInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function setUpdatedAt(string $updatedAt): VoucherCustomerInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    public function setStatus(int $status): VoucherCustomerInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Prepare data before saving
     *
     * @return VoucherCustomerInterface
     */
    public function beforeSave(): VoucherCustomerInterface
    {
        if ($this->hasDataChanges()) {
            $this->setUpdatedAt(date("Y-m-d H:i:s"));
        }
        return parent::beforeSave();
    }
}
