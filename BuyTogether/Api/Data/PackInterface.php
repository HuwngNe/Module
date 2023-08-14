<?php

namespace Ecommage\BuyTogether\Api\Data;

interface PackInterface
{
    CONST PACK_ID = "pack_id";

    CONST TITLE = "title";

    CONST QUANTITY = "quantity";

    CONST DISCOUNT = "discount";

    CONST MAIN_PRODUCT_ID = "main_product_id";

    CONST PRODUCT_IDS = "product_ids";

    CONST STATUS = "status";

    CONST PERCENT = "percent";

    CONST CREATED_AT = "created_at";

    CONST UPDATED_AT = "updated_at";

    public function getPackId(): int;

    public function getTitle(): string;

    public function getQuantity(): int;

    public function getDiscount(): float;

    public function getMainProductId(): int;

    public function getProductIds(): string;

    public function getStatus():int;

    public function getPercent():float;

    public function getCreatedAt(): string;

    public function getUpdateAt(): string;

    public function setPackId(int $packId): PackInterface;

    public function setTitle(string $title): PackInterface;

    public function setQuantity(int $quantity): PackInterface;

    public function setMainProductId(int $mainProductId): PackInterface;

    public function setProductIds(string $productIds): PackInterface;

    public function setStatus(int $status): PackInterface;

    public function setPercent(float $percent): PackInterface;

    public function setDiscount(float $discount): PackInterface;

    public function setCreatedAt(string $createdAt): PackInterface;

    public function setUpdatedAt(string $updatedAt): PackInterface;
}
