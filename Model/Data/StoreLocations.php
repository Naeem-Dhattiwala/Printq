<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Model\Data;

use Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface;

class StoreLocations extends \Magento\Framework\Api\AbstractExtensibleObject implements StoreLocationsInterface
{

    /**
     * Get storelocations_id
     * @return string|null
     */
    public function getStorelocationsId()
    {
        return $this->_get(self::STORELOCATIONS_ID);
    }

    /**
     * Set storelocations_id
     * @param string $storelocationsId
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setStorelocationsId($storelocationsId)
    {
        return $this->setData(self::STORELOCATIONS_ID, $storelocationsId);
    }

    /**
     * Get address
     * @return string|null
     */
    public function getAddress()
    {
        return $this->_get(self::ADDRESS);
    }

    /**
     * Set address
     * @param string $address
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setAddress($address)
    {
        return $this->setData(self::ADDRESS, $address);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Printq\StoreLocationsManagement\Api\Data\StoreLocationsExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Printq\StoreLocationsManagement\Api\Data\StoreLocationsExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get city
     * @return string|null
     */
    public function getCity()
    {
        return $this->_get(self::CITY);
    }

    /**
     * Set city
     * @param string $city
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setCity($city)
    {
        return $this->setData(self::CITY, $city);
    }

    /**
     * Get state
     * @return string|null
     */
    public function getState()
    {
        return $this->_get(self::STATE);
    }

    /**
     * Set state
     * @param string $state
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setState($state)
    {
        return $this->setData(self::STATE, $state);
    }

    /**
     * Get zip
     * @return string|null
     */
    public function getZip()
    {
        return $this->_get(self::ZIP);
    }

    /**
     * Set zip
     * @param string $zip
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setZip($zip)
    {
        return $this->setData(self::ZIP, $zip);
    }

    /**
     * Get phone
     * @return string|null
     */
    public function getPhone()
    {
        return $this->_get(self::PHONE);
    }

    /**
     * Set phone
     * @param string $phone
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setPhone($phone)
    {
        return $this->setData(self::PHONE, $phone);
    }

    /**
     * Get store_number
     * @return string|null
     */
    public function getStoreNumber()
    {
        return $this->_get(self::STORE_NUMBER);
    }

    /**
     * Set store_number
     * @param string $storeNumber
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setStoreNumber($storeNumber)
    {
        return $this->setData(self::STORE_NUMBER, $storeNumber);
    }

    /**
     * Get is_active
     * @return string|null
     */
    public function getIsActive()
    {
        return $this->_get(self::IS_ACTIVE);
    }

    /**
     * Set is_active
     * @param string $isActive
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Get customer_group
     * @return string|null
     */
    public function getCustomerGroup()
    {
        return $this->_get(self::CUSTOMER_GROUP);
    }

    /**
     * Set customer_group
     * @param string $customerGroup
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setCustomerGroup($customerGroup)
    {
        return $this->setData(self::CUSTOMER_GROUP, $customerGroup);
    }

    /**
     * Get products
     * @return string|null
     */
    public function getProducts()
    {
        return $this->_get(self::PRODUCTS);
    }

    /**
     * Set products
     * @param string $products
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setProducts($products)
    {
        return $this->setData(self::PRODUCTS, $products);
    }

    /**
     * Get frachise_owner
     * @return string|null
     */
    public function getFrachiseOwner()
    {
        return $this->_get(self::FRACHISE_OWNER);
    }

    /**
     * Set frachise_owner
     * @param string $frachiseOwner
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setFrachiseOwner($frachiseOwner)
    {
        return $this->setData(self::FRACHISE_OWNER, $frachiseOwner);
    }

    /**
     * Get area_director
     * @return string|null
     */
    public function getAreaDirector()
    {
        return $this->_get(self::AREA_DIRECTOR);
    }

    /**
     * Set area_director
     * @param string $areaDirector
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setAreaDirector($areaDirector)
    {
        return $this->setData(self::AREA_DIRECTOR, $areaDirector);
    }

    /**
     * Get soft_drink
     * @return string|null
     */
    public function getSoftDrink()
    {
        return $this->_get(self::SOFT_DRINK);
    }

    /**
     * Set soft_drink
     * @param string $softDrink
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setSoftDrink($softDrink)
    {
        return $this->setData(self::SOFT_DRINK, $softDrink);
    }
}

