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

class Main extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var \Magento\Config\Model\Config\Source\YesnoFactory
     */
    protected $_yesnoFactory;

    /**
     * @var \Printq\CheckoutFields\Model\Config\Source\PositionsFactory
     */
    protected $_positionFactory;

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
        \Magento\Store\Model\System\Store $systemStore,
        \Printq\CheckoutFields\Model\Config\Source\PositionsFactory $positionFactory,
        array $data = []
    ) {
        $this->_yesnoFactory = $yesnoFactory;
        $this->_positionFactory = $positionFactory;
        $this->_systemStore = $systemStore;
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

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('General')]);

        if ($customFieldObject && $customFieldObject->getFieldId()) {
            $fieldset->addField('field_id', 'hidden', ['name' => 'field_id']);
        }

        $this->_addElementTypes($fieldset);

        $labels = $customFieldObject->getFrontendLabel();
        $fieldset->addField(
            'frontend_label',
            'text',
            [
                'name' => 'field_label[0]',
                'label' => __('Default Label'),
                'title' => __('Default label'),
                'required' => true,
                'value' => is_array($labels) ? $labels[0] : $labels,
                'class' => 'validate-no-html-tags',
            ]
        );

        $yesno = $this->_yesnoFactory->create()->toOptionArray();

        $validateClass = 'validate-code';
        $fieldset->addField(
            'field_code',
            'text',
            [
                'name' => 'field_code',
                'label' => __('Field Code'),
                'title' => __('Field Code'),
                'class' => $validateClass,
                'required' => true
            ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'name' => 'status',
                'label' => __('Enabled'),
                'title' => __('Enabled'),
                'values' => $yesno
            ]
        );

        $fieldset->addField(
            'store_ids',
            'multiselect',
            [
              'name'     => 'store_ids[]',
              'label'    => __('Store Views'),
              'title'    => __('Store Views'),
              'required' => true,
              'values'   => $this->_systemStore->getStoreValuesForForm(false, true),
            ]
         );

        $fieldset->addField(
            'sort_order',
            'text',
            [
                'name' => 'sort_order',
                'label' => __('Sort Order'),
                'title' => __('Sort Order')
            ]
        );

        $fieldset->addField(
            'position',
            'select',
            [
                'name' => 'position',
                'label' => __('Location on Frontend'),
                'title' => __('Location on Frontend'),
                'value' => 'text',
                'values' => $this->_positionFactory->create()->toOptionArray()
            ]
        );

        if ($customFieldObject && $customFieldObject->getId()) {
            $form->getElement('field_code')->setDisabled(1);
        }

        $this->setForm($form);
        $form->setValues($customFieldObject->getData());

        parent::_prepareForm();

        return $this;
    }

    /**
     * @inheritdoc
     */
    protected function _getAdditionalElementTypes()
    {
        return ['apply' => HelperApply::class];
    }
}
