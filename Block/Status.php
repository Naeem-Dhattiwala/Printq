<?php
namespace Printq\CheckoutShippingDropdown\Block;

class Status extends \Magento\Framework\View\Element\Template
{
   /**
     * @var \My\Module\Helper\Data
   */
   protected $_dataHelper;

 /**
 * @param \Magento\Framework\View\Element\Template\Context $context
 * @param \My\Module\Helper\Data $dataHelper
 * @param array $data
 */
public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
    \Printq\CheckoutShippingDropdown\Helper\Data $dataHelper,
    array $data = []
) {
    $this->_dataHelper = $dataHelper;
    parent::__construct($context, $data);
}

public function canShowDropdown()
{
    return $this->_dataHelper->isEnable();
}
}