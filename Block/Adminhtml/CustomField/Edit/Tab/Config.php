<?php
/**
 *
 * @author        Krunal Padmashali <kp@cloudlab.at>.
 * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
 * @link          https://cloudlab.ag/
 * @date          07/01/2021
 */
namespace Printq\CheckoutFields\Block\Adminhtml\CustomField\Edit\Tab;

class Config extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var \Printq\CheckoutFields\Model\Config\Source\InputTypesFactory
     */
    protected $_inputTypesFactory;

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
        \Printq\CheckoutFields\Model\Config\Source\InputTypesFactory $inputTypesFactory,
        array $data = []
    ) {
        $this->_inputTypesFactory = $inputTypesFactory;
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

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Configuration')]);

        $this->_addElementTypes($fieldset);

        $fieldset->addField(
            'input_type',
            'select',
            [
                'name'   => 'input_type',
                'label'  => __('Input Type'),
                'title'  => __('Input Type'),
                'value'  => 'text',
                'values' => $this->_inputTypesFactory->create()->toOptionArray()
            ]
        );

        $this->setForm($form);
        $form->setValues($customFieldObject->getData());
        parent::_prepareForm();

        return $this;
    }
}
