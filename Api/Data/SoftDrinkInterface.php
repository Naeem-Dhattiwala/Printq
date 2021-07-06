<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Api\Data;

interface SoftDrinkInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const SOFTDRINK_ID = 'softdrink_id';
    const IMAGE_THUMBNAIL = 'image_thumbnail';
    const NAME = 'name';
    const IMAGE_PRINT = 'image_print';

    /**
     * Get softdrink_id
     * @return string|null
     */
    public function getSoftdrinkId();

    /**
     * Set softdrink_id
     * @param string $softdrinkId
     * @return \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface
     */
    public function setSoftdrinkId($softdrinkId);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface
     */
    public function setName($name);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Printq\StoreLocationsManagement\Api\Data\SoftDrinkExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Printq\StoreLocationsManagement\Api\Data\SoftDrinkExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Printq\StoreLocationsManagement\Api\Data\SoftDrinkExtensionInterface $extensionAttributes
    );

    /**
     * Get image_thumbnail
     * @return string|null
     */
    public function getImageThumbnail();

    /**
     * Set image_thumbnail
     * @param string $imageThumbnail
     * @return \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface
     */
    public function setImageThumbnail($imageThumbnail);

    /**
     * Get image_print
     * @return string|null
     */
    public function getImagePrint();

    /**
     * Set image_print
     * @param string $imagePrint
     * @return \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface
     */
    public function setImagePrint($imagePrint);
}

