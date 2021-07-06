<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Api\Data;

interface StoreLocationsInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const STORE_NUMBER = 'store_number';
    const IS_ACTIVE = 'is_active';
    const FRACHISE_OWNER = 'frachise_owner';
    const CITY = 'city';
    const STATE = 'state';
    const PRODUCTS = 'products';
    const ZIP = 'zip';
    const CUSTOMER_GROUP = 'customer_group';
    const ADDRESS = 'address';
    const AREA_DIRECTOR = 'area_director';
    const PHONE = 'phone';
    const SOFT_DRINK = 'soft_drink';
    const STORELOCATIONS_ID = 'storelocations_id';

    /**
     * Get storelocations_id
     * @return string|null
     */
    public function getStorelocationsId();

    /**
     * Set storelocations_id
     * @param string $storelocationsId
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setStorelocationsId($storelocationsId);

    /**
     * Get address
     * @return string|null
     */
    public function getAddress();

    /**
     * Set address
     * @param string $address
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setAddress($address);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Printq\StoreLocationsManagement\Api\Data\StoreLocationsExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Printq\StoreLocationsManagement\Api\Data\StoreLocationsExtensionInterface $extensionAttributes
    );

    /**
     * Get city
     * @return string|null
     */
    public function getCity();

    /**
     * Set city
     * @param string $city
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setCity($city);

    /**
     * Get state
     * @return string|null
     */
    public function getState();

    /**
     * Set state
     * @param string $state
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setState($state);

    /**
     * Get zip
     * @return string|null
     */
    public function getZip();

    /**
     * Set zip
     * @param string $zip
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setZip($zip);

    /**
     * Get phone
     * @return string|null
     */
    public function getPhone();

    /**
     * Set phone
     * @param string $phone
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setPhone($phone);

    /**
     * Get store_number
     * @return string|null
     */
    public function getStoreNumber();

    /**
     * Set store_number
     * @param string $storeNumber
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setStoreNumber($storeNumber);

    /**
     * Get is_active
     * @return string|null
     */
    public function getIsActive();

    /**
     * Set is_active
     * @param string $isActive
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setIsActive($isActive);

    /**
     * Get customer_group
     * @return string|null
     */
    public function getCustomerGroup();

    /**
     * Set customer_group
     * @param string $customerGroup
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setCustomerGroup($customerGroup);

    /**
     * Get products
     * @return string|null
     */
    public function getProducts();

    /**
     * Set products
     * @param string $products
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setProducts($products);

    /**
     * Get frachise_owner
     * @return string|null
     */
    public function getFrachiseOwner();

    /**
     * Set frachise_owner
     * @param string $frachiseOwner
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setFrachiseOwner($frachiseOwner);

    /**
     * Get area_director
     * @return string|null
     */
    public function getAreaDirector();

    /**
     * Set area_director
     * @param string $areaDirector
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setAreaDirector($areaDirector);

    /**
     * Get soft_drink
     * @return string|null
     */
    public function getSoftDrink();

    /**
     * Set soft_drink
     * @param string $softDrink
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     */
    public function setSoftDrink($softDrink);
}

