<?php
/**
 *
 * @author        Krunal Padmashali <kp@cloudlab.at>.
 * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
 * @link          https://cloudlab.ag/
 * @date          07/01/2021
 */
namespace Printq\CheckoutFields\Plugin\Quote\Model;


use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Quote\Model\QuoteRepository;
use Printq\CheckoutFields\Model\CustomFieldFactory;
use Printq\CheckoutFields\Model\QuoteValuesFactory;

class ShippingAddressManagement
{
    /**
     * @var QuoteRepository
     */
    protected $quoteRepository;

    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    protected $json;

    /**
     * @var QuoteValuesFactory
     */
    protected $quoteValues;

    /**
     * @var CustomFieldFactory
     */
    protected $customFieldFactory;

    /**
     * ShippingInformationManagement constructor.
     *
     * @param \Magento\Framework\Serialize\Serializer\Json $json
     * @param QuoteRepository                              $quoteRepository
     * @param QuoteValuesFactory                           $quoteValues
     */
    public function __construct(
        QuoteRepository $quoteRepository,
        \Magento\Framework\Serialize\Serializer\Json $json,
        CustomFieldFactory $customFieldFactory,
        QuoteValuesFactory $quoteValues
    )
    {
        $this->quoteRepository    = $quoteRepository;
        $this->json               = $json;
        $this->customFieldFactory = $customFieldFactory;
        $this->quoteValues        = $quoteValues;
    }

    /**
     * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
     * @param                                                       $cartId
     * @param ShippingInformationInterface                          $addressInformation
     */
    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        ShippingInformationInterface $addressInformation
    )
    {
        $extAttributes = $addressInformation->getExtensionAttributes();
        if (!$extAttributes->getShippingCustomAttributes()) {
            return;
        }

        $unserialized = $this->json->unserialize($extAttributes->getShippingCustomAttributes());
        foreach ($unserialized as $fieldCode => $fieldValue) {
            if(strpos($fieldCode, "-prepared-for-send") !== false){
                $fieldCode  = str_replace("-prepared-for-send", "",$fieldCode);
            }
            $customField = $this->customFieldFactory->create()->load($fieldCode, 'field_code');
            if (is_array($fieldValue)) {
               $fieldValue = implode(',', $fieldValue);
            }
            $data = [
                'field_id' => $customField->getId(),
                'quote_id' => $cartId,
                'value'    => $fieldValue,
            ];

            $this->quoteValues
                ->create()
                ->loadByMultiple(['field_id' => $customField->getId(), 'quote_id' => $cartId])
                ->addData($data)
                ->save();
        }
    }
}
