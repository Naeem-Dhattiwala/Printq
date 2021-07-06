<?php
namespace Printq\CheckoutFields\Model\Config\Source;

class InputTypes implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var array
     */
    protected $options;

    const TYPE_TEXT = 'text';

    const TYPE_TEXTAREA = 'textarea';

    const TYPE_RADIO = 'radio';

    const TYPE_CHECKBOX = 'checkbox';

    const TYPE_SELECT = 'select';

    const TYPE_MULTIPLE = 'multiselect';

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        if (null == $this->options) {
            $this->options = [
            	['value' => self::TYPE_TEXT, 'label' => __('Text Field')],
                ['value' => self::TYPE_TEXTAREA, 'label' => __('Textarea Field')],
                ['value' => self::TYPE_RADIO, 'label' => __('Radio Field')],
                ['value' => self::TYPE_CHECKBOX, 'label' => __('Checkbox Field')],
                ['value' => self::TYPE_SELECT, 'label' => __('Select Field')],
                ['value' => self::TYPE_MULTIPLE, 'label' => __('Multiple Select Field')],
            ];
        }

        return $this->options;
    }
}