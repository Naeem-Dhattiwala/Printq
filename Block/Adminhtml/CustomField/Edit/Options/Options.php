<?php
/**
 *
 * @author        Krunal Padmashali <kp@cloudlab.at>.
 * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
 * @link          https://cloudlab.ag/
 * @date          07/01/2021
 */
namespace Printq\CheckoutFields\Block\Adminhtml\CustomField\Edit\Options;

use Magento\Store\Model\ResourceModel\Store\Collection;
use Printq\CheckoutFields\Model\CustomField;
use Printq\CheckoutFields\Model\Config\Source\InputTypes;

class Options extends \Magento\Backend\Block\Template
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * @var \Printq\CheckoutFields\Model\ResourceModel\CustomFieldOptions\CollectionFactory
     */
    protected $_customFieldOptionCollectionFactory;

    /**
     * @var string
     */
    protected $_template = 'Printq_CheckoutFields::customfield/options.phtml';

    /**
     * @var \Magento\Framework\Validator\UniversalFactory $universalFactory
     */
    protected $_universalFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Printq\CheckoutFields\Model\ResourceModel\CustomFieldOptions\CollectionFactory $customFieldOptionCollectionFactory
     * @param \Magento\Framework\Validator\UniversalFactory $universalFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Printq\CheckoutFields\Model\ResourceModel\CustomFieldOptions\CollectionFactory $customFieldOptionCollectionFactory,
        \Magento\Framework\Validator\UniversalFactory $universalFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_registry = $registry;
        $this->_customFieldOptionCollectionFactory = $customFieldOptionCollectionFactory;
        $this->_universalFactory = $universalFactory;
    }

    /**
     * Retrieve stores collection with default store
     *
     * @return array
     */
    public function getStores()
    {
        if (!$this->hasStores()) {
            $this->setData('stores', $this->_storeManager->getStores(true));
        }
        return $this->_getData('stores');
    }

    /**
     * Returns stores sorted by Sort Order
     *
     * @return array
     * @since 100.1.0
     */
    public function getStoresSortedBySortOrder()
    {
        $stores = $this->getStores();
        if (is_array($stores)) {
            usort(
                $stores,
                function ($storeA, $storeB) {
                    if ($storeA->getSortOrder() == $storeB->getSortOrder()) {
                        return $storeA->getId() < $storeB->getId() ? -1 : 1;
                    }

                    return ($storeA->getSortOrder() < $storeB->getSortOrder()) ? -1 : 1;
                }
            );
        }
        return $stores;
    }

    /**
     * Retrieve customfield option values if customfield input type select or multiselect
     *
     * @return array
     */
    public function getOptionValues()
    {
        $values = $this->_getData('option_values');
        if ($values === null) {
            $values = [];

            $customfield = $this->getCustomFieldObject();
            $optionCollection = $this->_getOptionValuesCollection($customfield);
            if ($optionCollection) {
                $values = $this->_prepareOptionValues($customfield, $optionCollection);
            }

            $this->setData('option_values', $values);
        }

        return $values;
    }

    /**
     * Preparing values of customfield options
     *
     * @param CustomField $customfield
     * @param array|\Printq\CheckoutFields\Model\ResourceModel\CustomFieldOptions\Collection $optionCollection
     * @return array
     */
    protected function _prepareOptionValues(
        CustomField $customfield,
        $optionCollection
    ) {
        $type = $customfield->getInputType();
        if ($type === InputTypes::TYPE_SELECT || $type === InputTypes::TYPE_MULTIPLE || $type === InputTypes::TYPE_RADIO || $type === InputTypes::TYPE_CHECKBOX) {
            $defaultValues = explode(',', $customfield->getDefaultValue());
                $inputType = 'checkbox';
            if ($type === InputTypes::TYPE_SELECT || InputTypes::TYPE_RADIO) {
                $inputType = 'radio';
            }
        } else {
            $defaultValues = [];
            $inputType = '';
        }

        $values = [];
        $optionCollection->setPageSize(200);
        $pageCount = $optionCollection->getLastPageNumber();
        $currentPage = 1;
        while ($currentPage <= $pageCount) {
            $optionCollection->clear();
            $optionCollection->setCurPage($currentPage);
            $values = $this->getPreparedValues($optionCollection, $inputType, $defaultValues);
            $currentPage++;
        }

        return array_merge([], $values);
    }

    /**
     * Return prepared values of system or user defined customfield options
     *
     * @param array|\Printq\CheckoutFields\Model\ResourceModel\CustomFieldOptions\Collection $optionCollection
     * @param string $inputType
     * @param array $defaultValues
     */
    private function getPreparedValues(
        $optionCollection,
        string $inputType,
        array $defaultValues
    ) {
        $values = [];
        foreach ($optionCollection as $option) {
            $bunch = $this->_prepareFieldOptionValues(
                $option,
                $inputType,
                $defaultValues
            );
            foreach ($bunch as $value) {
                $values[] = new \Magento\Framework\DataObject($value);
            }
        }

        return $values;
    }

    /**
     * Retrieve option values collection
     *
     * It is represented by an array in case of system attribute
     *
     * @param CustomField $customfield
     * @return array|\Printq\CheckoutFields\Model\ResourceModel\CustomFieldOptions\Collection
     */
    protected function _getOptionValuesCollection(CustomField $customfield)
    {
        return $this->_customFieldOptionCollectionFactory->create()->setCustomFieldFilter(
            $customfield->getId()
        )->setPositionOrder(
            'asc',
            true
        )->load();
    }

    /**
     * Prepare option values of user defined attribute
     *
     * @param array|\Printq\CheckoutFields\Model\ResourceModel\CustomFieldOptions $option
     * @param string $inputType
     * @param array $defaultValues
     * @return array
     */
    protected function _prepareFieldOptionValues($option, $inputType, $defaultValues)
    {
        $optionId = $option->getId();

        $value['checked'] = in_array($optionId, $defaultValues) ? 'checked="checked"' : '';
        $value['intype'] = $inputType;
        $value['id'] = $optionId;
        $value['sort_order'] = $option->getSortOrder();

        foreach ($this->getStores() as $store) {
            $storeId = $store->getId();
            $storeValues = $this->getStoreOptionValues($storeId);
            $value['store' . $storeId] = isset(
                $storeValues[$optionId]
            ) ? $this->_escaper->escapeHtml(
                $storeValues[$optionId]
            ) : '';
        }

        return [$value];
    }

    /**
     * Retrieve customfield option values for given store id
     *
     * @param int $storeId
     * @return array
     */
    public function getStoreOptionValues($storeId)
    {
        $values = $this->getData('store_option_values_' . $storeId);
        if ($values === null) {
            $values = [];
            $valuesCollection = $this->_customFieldOptionCollectionFactory->create()->setCustomFieldFilter(
                $this->getCustomFieldObject()->getId()
            )->setStoreFilter(
                $storeId,
                false
            )->load();
            foreach ($valuesCollection as $item) {
                $values[$item->getId()] = $item->getValue();
            }
            $this->setData('store_option_values_' . $storeId, $values);
        }
        return $values;
    }

    /**
     * Retrieve attribute object from registry
     *
     * @return \Magento\Eav\Model\Entity\Attribute\AbstractAttribute
     * @codeCoverageIgnore
     */
    protected function getCustomFieldObject()
    {
        return $this->_registry->registry('custom_field');
    }
}
