<?php
namespace Printq\CheckoutFields\Model\ResourceModel;

use \Magento\Framework\Model\AbstractModel;

use \Magento\Store\Model\StoreManagerInterface;

class CustomField extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context,
        StoreManagerInterface $storeManager
	)
	{
        $this->_storeManager = $storeManager;
		parent::__construct($context);
	}
	
	protected function _construct()
	{
		$this->_init('printq_custom_checkout_field', 'field_id');
	}

	public function getStoreLabelsByFieldId($fieldId)
    {
        if (!isset($this->storeLabelsCache[$fieldId])) {
            $connection = $this->getConnection();
            $bind = [':field_id' => $fieldId];
            $select = $connection->select()->from(
                $this->getTable('printq_custom_checkout_field_label'),
                ['store_id', 'value']
            )->where(
                'field_id = :field_id'
            );
            $this->storeLabelsCache[$fieldId] = $connection->fetchPairs($select, $bind);
        }

        return $this->storeLabelsCache[$fieldId];
    }

    protected function _afterSave(AbstractModel $object)
    {
        $this->_saveStoreLabels(
            $object
        )->_saveOption(
            $object
        );
        return parent::_afterSave($object);
    }

    protected function _saveStoreLabels(AbstractModel $object)
    {
        $storeLabels = $object->getFieldLabel();
        if (is_array($storeLabels)) {
            $connection = $this->getConnection();
            if ($object->getId()) {
                $condition = ['field_id =?' => $object->getId()];
                $connection->delete($this->getTable('printq_custom_checkout_field_label'), $condition);
            }
            foreach ($storeLabels as $storeId => $label) {
                if ($storeId == 0 || !strlen($label)) {
                    continue;
                }
                $bind = ['field_id' => $object->getId(), 'store_id' => $storeId, 'value' => $label];
                $connection->insert($this->getTable('printq_custom_checkout_field_label'), $bind);
            }
        }

        return $this;
    }

    protected function _saveOption(AbstractModel $object)
    {
        $option = $object->getOption();
        if (!is_array($option)) {
            return $this;
        }

        $defaultValue = $object->getDefault() ?: [];
        if (isset($option['value'])) {
            if (!is_array($object->getDefault())) {
                $object->setDefault([]);
            }
            $defaultValue = $this->_processfieldOptions($object, $option);
        }

        $this->_saveDefaultValue($object, $defaultValue);
        return $this;
    }

    protected function _saveDefaultValue($object, $defaultValue)
    {
        if ($defaultValue !== null) {
            $bind = ['default_value' => implode(',', $defaultValue)];
            $where = ['field_id = ?' => $object->getId()];
            $this->getConnection()->update($this->getMainTable(), $bind, $where);
        }
    }

    protected function _processfieldOptions($object, $option)
    {
        $defaultValue = [];
        foreach ($option['value'] as $optionId => $values) {
            $intOptionId = $this->_updatefieldOption($object, $optionId, $option);
            if ($intOptionId === false) {
                continue;
            }
            $this->_updateDefaultValue($object, $optionId, $intOptionId, $defaultValue);
            $this->_checkDefaultOptionValue($values);
            $this->_updateFieldOptionValues($intOptionId, $values);
        }
        return $defaultValue;
    }

    protected function _updateFieldOptionValues($optionId, $values)
    {
        $connection = $this->getConnection();
        $table = $this->getTable('printq_custom_checkout_field_option_value');

        $connection->delete($table, ['option_id = ?' => $optionId]);

        $stores = $this->_storeManager->getStores(true);
        foreach ($stores as $store) {
            $storeId = $store->getId();
            if (!empty($values[$storeId]) || isset($values[$storeId]) && $values[$storeId] == '0') {
                $data = ['option_id' => $optionId, 'store_id' => $storeId, 'value' => $values[$storeId]];
                $connection->insert($table, $data);
            }
        }
    }

    protected function _checkDefaultOptionValue($values)
    {
        if (!isset($values[0])) {
            throw new LocalizedException(
                __("The default option isn't defined. Set the option and try again.")
            );
        }
    }

    protected function _updateDefaultValue($object, $optionId, $intOptionId, &$defaultValue)
    {
        if (in_array($optionId, $object->getDefault())) {
            $inputType = $object->getInputType();
            if ($inputType === 'multiselect' || $inputType === 'checkbox') {
                $defaultValue[] = $intOptionId;
            } elseif ($inputType === 'select') {
                $defaultValue = [$intOptionId];
            }
        }
    }

    protected function _updatefieldOption($object, $optionId, $option)
    {
        $connection = $this->getConnection();
        $table = $this->getTable('printq_custom_checkout_field_option');
        // ignore strings that start with a number
        $intOptionId = is_numeric($optionId) ? (int)$optionId : 0;

        if (!empty($option['delete'][$optionId])) {
            if ($intOptionId) {
                $connection->delete($table, ['option_id = ?' => $intOptionId]);
                $this->clearSelectedOptionInEntities($object, $intOptionId);
            }
            return false;
        }

        $sortOrder = empty($option['order'][$optionId]) ? 0 : $option['order'][$optionId];
        if (!$intOptionId) {
            $data = ['field_id' => $object->getId(), 'sort_order' => $sortOrder];
            $connection->insert($table, $data);
            $intOptionId = $connection->lastInsertId($table);
        } else {
            $data = ['sort_order' => $sortOrder];
            $where = ['option_id = ?' => $intOptionId];
            $connection->update($table, $data, $where);
        }

        return $intOptionId;
    }
}