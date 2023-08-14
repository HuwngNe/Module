<?php

namespace Ecommage\EcommageVoucher\Api\Data;

interface VoucherCustomerInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    CONST VCUS_ID = "vcus_id";
    CONST VOUCHER_ID = "voucher_id";
    CONST CUSTOMER_ID = "customer_id";
    CONST EMAIL = "email";
    CONST CREATED_AT = "created_at";
    CONST UPDATED_AT = "updated_at";
    CONST STATUS = "status";

    /**
     * @return int
     */
    public function getVcusId(): int;

    /**
     * @return int
     */
    public function getVoucherId(): int;

    /**
     * @return int
     */
    public function getCustomerId(): int;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @param int $entityId
     * @return VoucherCustomerInterface
     */
    public function setVcusId(int $vcusId): VoucherCustomerInterface;

    /**
     * @param int $voucherId
     * @return VoucherCustomerInterface
     */
    public function setVoucherId(int $voucherId): VoucherCustomerInterface;

    /**
     * @param int $customerId
     * @return VoucherCustomerInterface
     */
    public function setCustomerId(int $customerId): VoucherCustomerInterface;

    /**
     * @param string $email
     * @return VoucherCustomerInterface
     */
    public function setEmail(string $email): VoucherCustomerInterface;

    /**
     * @param string $createdAt
     * @return VoucherCustomerInterface
     */
    public function setCreatedAt(string $createdAt): VoucherCustomerInterface;

    /**
     * @param string $updatedAt
     * @return VoucherCustomerInterface
     */
    public function setUpdatedAt(string $updatedAt): VoucherCustomerInterface;

    /**
     * @param int $status
     * @return VoucherCustomerInterface
     */
    public function setStatus(int $status): VoucherCustomerInterface;
}
