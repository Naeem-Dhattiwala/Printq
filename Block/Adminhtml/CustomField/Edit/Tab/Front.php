<?php
/**
 *
 * @author        Krunal Padmashali <kp@cloudlab.at>.
 * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
 * @link          https://cloudlab.ag/
 * @date          07/01/2021
 */
namespace Printq\CheckoutFields\Block\Adminhtml\CustomField\Edit\Tab;

use Printq\CheckoutFields\Model\ResourceModel\CustomField;

class Front extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var \Magento\Config\Model\Config\Source\YesnoFactory
     */
    protected $_yesnoFactory;

    /**
     * CustomField instance
     *
     * @var CustomField
     */
    protected $_customfield = null;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Config\Model\Config\Source\YesnoFactory $yesnoFactory,
        array $data = []
    ) {
        $this->_yesnoFactory = $yesnoFactory;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    public function getCustomFieldObject()
    {
        if (null === $this->_customfield) {
            return $this->_coreRegistry->registry('custom_field');
        }
        return $this->_customfield;
    }

    /**
     * @inheritdoc
     */
    protected function _prepareForm()
    {
        $customFieldObject = $this->getCustomFieldObject();

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Storefront Properties')]);

        $yesno = $this->_yesnoFactory->create()->toOptionArray();

        $fieldset->addField(
            'in_customer_order_view',
            'select',
            [
                'name' => 'in_customer_order_view',
                'label' => __('Show in customer order view'),
                'title' => __('Show in customer order view'),
                'values' => $yesno
            ]
        );

        $fieldset->addField(
            'in_admin_order_view',
            'select',
            [
                'name' => 'in_admin_order_view',
                'label' => __('Show in admin order view'),
                'title' => __('Show in admin order view'),
                'values' => $yesno
            ]
        );

        $fieldset->addField(
            'in_order_conf_email',
            'select',
            [
                'name' => 'in_order_conf_email',
                'label' => __('Show in order confirmation email'),
                'title' => __('Show in order confirmation email'),
                'values' => $yesno,
                'note' => __("To Show Value in Order Email, So Please Load Printq_CheckoutFields New Order Template if you used Default Order Email Template, Otherwise Please add '{{var printq_order_variable | raw}}' in your Exsisting template.")
            ]
        );

        $fieldset->addField(
            'in_invoice_email',
            'select',
            [
                'name' => 'in_invoice_email',
                'label' => __('Show in invoice email'),
                'title' => __('Show in invoice email'),
                'values' => $yesno,
                'note' => __("To Show Value in Invoice Email, So Please Load Printq_CheckoutFields New Invoice Template if you used Default Invoice Email Template, Otherwise Please add '{{var printq_invoice_variable | raw}}' in your Exsisting template.")
            ]
        );

        $this->setForm($form);
        $form->setValues($customFieldObject->getData());
        parent::_prepareForm();

        return $this;
    }
}
