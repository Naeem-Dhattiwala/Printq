<?php
    /**
     *
     * @author        Krunal Padmashali <kp@cloudlab.at>.
     * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
     * @link          https://cloudlab.ag/
     * @date          07/01/2021
     */
    namespace Printq\CheckoutFields\Block\Adminhtml\CustomField;

    class Edit extends \Magento\Backend\Block\Widget\Form\Container
    {
        /**
         * @var string
         */
        protected $_blockGroup = 'Printq_CheckoutFields';

        /**
         * Core registry
         *
         * @var \Magento\Framework\Registry
         */
        protected $_coreRegistry = null;

        /**
         * @param \Magento\Backend\Block\Widget\Context $context
         * @param \Magento\Framework\Registry $registry
         * @param array $data
         */
        public function __construct(
            \Magento\Backend\Block\Widget\Context $context,
            \Magento\Framework\Registry $registry,
            array $data = []
        ) {
            $this->_coreRegistry = $registry;
            parent::__construct($context, $data);
        }

        /**
         * Construct block
         *
         * @return void
         */
        protected function _construct()
        {
            $this->_objectId = 'field_id';
            $this->_controller = 'adminhtml_customField';

            parent::_construct();

            $this->buttonList->update('save', 'label', __('Save Field'));
            $this->buttonList->update('save', 'class', 'save primary');
            $this->buttonList->update(
                'save',
                'data_field',
                ['mage-init' => ['button' => ['event' => 'save', 'target' => '#edit_form']]]
            );

            $this->addButton(
                'save_and_edit_button',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                        ],
                    ]
                ]
            );

            if ($this->_coreRegistry->registry('custom_field')->getId()) {
                $this->addButton(
                    'delete',
                    [
                        'label' => __('Delete Field'),
                        'onclick' => 'deleteConfirm(' . json_encode(__('Are you sure you want to do this field?'))
                            . ','
                            . json_encode($this->getDeleteUrl()
                            )
                            . ')',
                        'class' => 'scalable delete',
                        'level' => -1
                    ]
                );
            }

        }

        /**
         * Retrieve URL for delete
         *
         * @return string
         */
        public function getDeleteUrl()
        {
            return $this->getUrl('printq_checkoutfields/checkoutfields/delete',
                ['_current' => true, 'back' => null]);
        }

        /**
         * Retrieve header text
         *
         * @return \Magento\Framework\Phrase
         */
        public function getHeaderText()
        {
            if ($this->_coreRegistry->registry('custom_field')->getId()) {
                return __('Edit Field ');
            }
            return __('New Field');
        }

        /**
         * Retrieve URL for save
         *
         * @return string
         */
        public function getSaveUrl()
        {
            return $this->getUrl(
                'printq_checkoutfields/checkoutfields/save',
                ['_current' => true, 'back' => null]
            );
        }
    }
