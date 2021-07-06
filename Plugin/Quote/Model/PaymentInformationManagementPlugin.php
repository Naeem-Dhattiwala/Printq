<?php
/**
 *
 * @author        Krunal Padmashali <kp@cloudlab.at>.
 * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
 * @link          https://cloudlab.ag/
 * @date          07/01/2021
 */
namespace Printq\CheckoutFields\Plugin\Quote\Model;

class PaymentInformationManagementPlugin
{
    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $orderRepository;

    protected $_customFieldFactory;

    protected $_quoteValues;

    protected $_getcustomValues;

    protected $_ordervalues;

    /**
     * PaymentInformationManagementPlugin constructor.
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Framework\Serialize\Serializer\Json $json,
        \Printq\CheckoutFields\Model\CustomFieldFactory $customFieldFactory,
        \Printq\CheckoutFields\Model\QuoteValuesFactory $quoteValues,
        \Printq\CheckoutFields\Model\OrderValuesFactory $ordervalues,
        \Printq\CheckoutFields\Model\GetCustomValue $getcustomvalues
    ) {
        $this->orderRepository = $orderRepository;
        $this->_customFieldFactory = $customFieldFactory;
        $this->_getcustomValues = $getcustomvalues;
        $this->_quoteValues = $quoteValues;
        $this->_ordervalues = $ordervalues;
        $this->json = $json;
    }

    /**
     * Save order additional_comment attribute and add history comment
     *
     * @param \Magento\Checkout\Model\PaymentInformationManagement $subject
     * @param $result
     * @param $cartId
     * @param \Magento\Quote\Api\Data\PaymentInterface $paymentMethod
     * @param \Magento\Quote\Api\Data\AddressInterface|null $billingAddress
     * @return mixed
     * @throws \Exception
     */
    public function afterSavePaymentInformationAndPlaceOrder(
        \Magento\Checkout\Model\PaymentInformationManagement $subject,
        $result,
        $cartId,
        \Magento\Quote\Api\Data\PaymentInterface $paymentMethod,
        \Magento\Quote\Api\Data\AddressInterface $billingAddress = null
    ) {
        if ($result) {
            $order = $this->orderRepository->get($result);
            $extAttributes = $paymentMethod->getExtensionAttributes();
            if ($extAttributes->getPaymentCustomAttributes()) {
                $fieldData = $extAttributes->getPaymentCustomAttributes();
                $fieldCode = $extAttributes->getPaymentCustomAttributes2();
                if(strpos($fieldData, "undefined") !== false){
                    $fieldData  = str_replace("undefined", "",$fieldData);
                    $fieldData = explode("/", $fieldData);
                }
                if(strpos($fieldCode, "undefined") !== false){
                    $fieldCode  = str_replace("undefined", "",$fieldCode);
                    $fieldCode = explode("/", $fieldCode);
                }
                foreach ($fieldData as $key => $value) {
                    if($value != '') {
                        $customField = $this->_customFieldFactory->create()->load($fieldCode[$key], 'field_code');
                        $data2 = [
                            'field_id' => $customField->getId(),
                            'quote_id' => $cartId,
                            'value' => $value,
                        ];
                        $data3 = [
                            'field_id' => $customField->getId(),
                            'order_id' => $order->getId(),
                            'value' => $value,
                        ];
                        $this->_quoteValues->create()->loadByMultiple(['field_id' => $customField->getId(),'quote_id' => $cartId])->addData($data2)->save();

                        $this->_ordervalues->create()->loadByMultiple(['field_id' => $customField->getId(),'order_id' => $order->getId()])->addData($data3)->save();
                    }
                }
            }
        }
        return $result;
    }
}
