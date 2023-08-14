<?php

namespace Ecommage\EcommageVoucher\Api\Data;

interface VoucherInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    CONST VOUCHER_ID = "voucher_id";
    CONST TITLE = "title";
    CONST PERCENT = "percent";
    CONST START_DATE = "start_date";
    CONST END_DATE = "end_date";
    CONST CREATED_AT = "created_at";
    CONST UPDATED_AT = "updated_at";
    CONST STATUS = "status";

    /**
     * @return int
     */
    public function getVoucherId(): int;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return float
     */
    public function getPercent(): float;

    /**
     * @return string
     */
    public function getStartDate(): string;

    /**
     * @return string
     */
    public function getEndDate(): string;

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
     * @param int $voucherId
     * @return VoucherInterface
     */
    public function setVoucherId(int $voucherId): VoucherInterface;

    /**
     * @param string $title
     * @return VoucherInterface
     */
    public function setTitle(string $title): VoucherInterface;

    /**
     * @param float $percent
     * @return VoucherInterface
     */
    public function setPercent(float $percent): VoucherInterface;

    /**
     * @param string $startDate
     * @return VoucherInterface
     */
    public function setStartDate(string $startDate): VoucherInterface;

    /**
     * @param string $endData
     * @return VoucherInterface
     */
    public function setEndDate(string $endData): VoucherInterface;

    /**
     * @param string $createdAt
     * @return VoucherInterface
     */
    public function setCreatedAt(string $createdAt): VoucherInterface;

    /**
     * @param string $updatedAt
     * @return VoucherInterface
     */
    public function setUpdatedAt(string $updatedAt): VoucherInterface;

    /**
     * @param int $status
     * @return VoucherInterface
     */
    public function setStatus(int $status): VoucherInterface;

}
