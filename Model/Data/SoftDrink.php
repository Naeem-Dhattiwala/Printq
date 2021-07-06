<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Model\Data;

use Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface;

class SoftDrink extends \Magento\Framework\Api\AbstractExtensibleObject implements SoftDrinkInterface
{

    /**
     * Get softdrink_id
     * @return string|null
     */
    public function getSoftdrinkId()
    {
        return $this->_get(self::SOFTDRINK_ID);
    }

    /**
     * Set softdrink_id
     * @param string $softdrinkId
     * @return \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface
     */
    public function setSoftdrinkId($softdrinkId)
    {
        return $this->setData(self::SOFTDRINK_ID, $softdrinkId);
    }

    /**
     * Get name
     * @return string|null
     */
    public function getName()
    {
        return $this->_get(self::NAME);
    }

    /**
     * Set name
     * @param string $name
     * @return \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Printq\StoreLocationsManagement\Api\Data\SoftDrinkExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Printq\StoreLocationsManagement\Api\Data\SoftDrinkExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Printq\StoreLocationsManagement\Api\Data\SoftDrinkExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get image_thumbnail
     * @return string|null
     */
    public function getImageThumbnail()
    {
        return $this->_get(self::IMAGE_THUMBNAIL);
    }

    /**
     * Set image_thumbnail
     * @param string $imageThumbnail
     * @return \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface
     */
    public function setImageThumbnail($imageThumbnail)
    {
        return $this->setData(self::IMAGE_THUMBNAIL, $imageThumbnail);
    }

    /**
     * Get image_print
     * @return string|null
     */
    public function getImagePrint()
    {
        return $this->_get(self::IMAGE_PRINT);
    }

    /**
     * Set image_print
     * @param string $imagePrint
     * @return \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface
     */
    public function setImagePrint($imagePrint)
    {
        return $this->setData(self::IMAGE_PRINT, $imagePrint);
    }
}

