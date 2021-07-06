<?php
/**
 * @author        Theodor Flavian Hanu <th@cloudlab.at>.
 * @copyright    Copyright(c) 2020 CloudLab AG (http://cloudlab.ag)
 * @link        http://www.cloudlab.ag
 */

namespace Printq\Core\Plugin\Plugin\Tax;

class CalculationPlugin
{


    /**
     * @var \Printq\Core\Helper\Data
     */
    protected $coreHelper;

    public function __construct(\Printq\Core\Helper\Data $coreHelper)
    {
        $this->coreHelper = $coreHelper;
    }

    public function afterRound(\Magento\Tax\Model\Calculation $subject, $result, $originalPrice)
    {
        if ($this->coreHelper->disableUnitPriceRounding()) {
            return $originalPrice;
        }
        return $result;

    }
}
