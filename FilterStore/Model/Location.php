<?php

namespace Ecommage\FilterStore\Model;

use Ecommage\FilterStore\Api\Data\LocationInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

class Location extends AbstractExtensibleModel implements LocationInterface, IdentityInterface
{
    const CACHE_TAG = 'ecommage_filterstore_location';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Location::class);
        $this->setIdFieldName('location_id');
    }

    /**
     * @return string[]
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getLocationId()];
    }

    /**
     * @return int
     */
    public function getLocationId(): int
    {
        return $this->getData(self::LOCATION_ID);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @return int
     */
    public function getCountryId(): int
    {
        return $this->getData(self::COUNTRY_ID);
    }

    /**
     * @return int
     */
    public function getRegionId(): int
    {
        return $this->getData(self::REGION_ID);
    }

    /**
     * @return int
     */
    public function getCityId(): int
    {
        return $this->getData(self::CITY_ID);
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->getData(self::ADDRESS);
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->getData(self::PHONE);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * @return string
     */
    public function getProductIds(): string
    {
        return $this->getData(self::PRODUCT_IDS);
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
    public function getUpdatedAt(): string
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @param int $locationId
     * @return LocationInterface
     */
    public function setLocationId(int $locationId): LocationInterface
    {
        return $this->setData(self::LOCATION_ID, $locationId);
    }

    /**
     * @param string $title
     * @return LocationInterface
     */
    public function setTitle(string $title): LocationInterface
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @param int $countryId
     * @return LocationInterface
     */
    public function setCountryId(int $countryId): LocationInterface
    {
        return $this->setData(self::COUNTRY_ID, $countryId);
    }

    /**
     * @param int $regionId
     * @return LocationInterface
     */
    public function setRegionId(int $regionId): LocationInterface
    {
        return $this->setData(self::REGION_ID, $regionId);
    }

    /**
     * @param int $cityId
     * @return LocationInterface
     */
    public function setCityId(int $cityId): LocationInterface
    {
        return $this->setData(self::CITY_ID, $cityId);
    }

    /**
     * @param string $address
     * @return LocationInterface
     */
    public function setAddress(string $address): LocationInterface
    {
        return $this->setData(self::ADDRESS, $address);
    }

    /**
     * @param string $phone
     * @return LocationInterface
     */
    public function setPhone(string $phone): LocationInterface
    {
        return $this->setData(self::PHONE, $phone);
    }

    /**
     * @param string $email
     * @return LocationInterface
     */
    public function setEmail(string $email): LocationInterface
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * @param string $productIds
     * @return LocationInterface
     */
    public function setProductIds(string $productIds): LocationInterface
    {
        return $this->setData(self::PRODUCT_IDS, $productIds);
    }

    /**
     * @param string $createdAt
     * @return LocationInterface
     */
    public function setCreatedAt(string $createdAt): LocationInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @param string $updatedAt
     * @return LocationInterface
     */
    public function setUpdatedAt(string $updatedAt): LocationInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * Prepare data before saving
     *
     * @return LocationInterface
     */
    public function beforeSave(): LocationInterface
    {
        if ($this->hasDataChanges()) {
            $this->setUpdatedAt(date("Y-m-d H:i:s"));
        }
        return parent::beforeSave();
    }
}
