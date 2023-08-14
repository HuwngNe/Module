<?php

namespace Ecommage\FilterStore\Api\Data;

interface LocationInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    CONST LOCATION_ID = "location_id";
    CONST TITLE = "title";
    CONST COUNTRY_ID = "country_id";
    CONST REGION_ID = "region_id";
    CONST CITY_ID = "city_id";
    CONST ADDRESS = "address";
    CONST PHONE = "phone";
    CONST EMAIL = "email";

    CONST PRODUCT_IDS = "product_ids";
    CONST CREATED_AT = "created_at";
    CONST UPDATED_AT = "updated_at";

    /**
     * @return int
     */
    public function getLocationId(): int;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return int
     */
    public function getCountryId(): int;

    /**
     * @return int
     */
    public function getRegionId(): int;

    /**
     * @return int
     */
    public function getCityId(): int;

    /**
     * @return string
     */
    public function getAddress(): string;

    /**
     * @return string
     */
    public function getPhone(): string;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @return string
     */
    public function getProductIds(): string;

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @param int $locationId
     * @return LocationInterface
     */
    public function setLocationId(int $locationId): LocationInterface;

    /**
     * @param string $title
     * @return LocationInterface
     */
    public function setTitle(string $title): LocationInterface;

    /**
     * @param int $countryId
     * @return LocationInterface
     */
    public function setCountryId(int $countryId): LocationInterface;

    /**
     * @param int $regionId
     * @return LocationInterface
     */
    public function setRegionId(int $regionId): LocationInterface;

    /**
     * @param int $cityId
     * @return LocationInterface
     */
    public function setCityId(int $cityId): LocationInterface;

    /**
     * @param string $address
     * @return LocationInterface
     */
    public function setAddress(string $address): LocationInterface;

    /**
     * @param string $phone
     * @return LocationInterface
     */
    public function setPhone(string $phone): LocationInterface;

    /**
     * @param string $email
     * @return LocationInterface
     */
    public function setEmail(string $email): LocationInterface;

    /**
     * @param string $productIds
     * @return LocationInterface
     */
    public function setProductIds(string $productIds): LocationInterface;

    /**
     * @param string $createdAt
     * @return LocationInterface
     */
    public function setCreatedAt(string $createdAt): LocationInterface;

    /**
     * @param string $updatedAt
     * @return LocationInterface
     */
    public function setUpdatedAt(string $updatedAt): LocationInterface;

}
