<?php
/**
 * @author        Theodor Flavian Hanu <th@cloudlab.at>.
 * @copyright     Copyright(c) 2020 CloudLab AG (http://cloudlab.ag)
 * @link          http://www.cloudlab.ag
 */

namespace Printq\Core\Plugin\Quote;


class ItemPlugin
{
    /**
     * \Printq\Core\Helper\Data
     */
    protected $printqCoreHelper;
    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $priceCurrency;

    public function __construct(
        \Printq\Core\Helper\Data $printqCoreHelper,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
    ) {
        $this->printqCoreHelper = $printqCoreHelper;
        $this->priceCurrency = $priceCurrency;
    }

    public function afterCalcRowTotal(\Magento\Quote\Model\Quote\Item $subject, $result)
    {
        $qty = $subject->getTotalQty();
        // Round unit price before multiplying to prevent losing 1 cent on subtotal
        if($this->printqCoreHelper->disableUnitPriceRounding()) {
            $total = $subject->getCalculationPriceOriginal() * $qty;
            $baseTotal = $subject->getBaseCalculationPriceOriginal() * $qty;
            $subject->setRowTotal($this->priceCurrency->round($total));
            $subject->setBaseRowTotal($this->priceCurrency->round($baseTotal));
        }
        return $result;
    }
}
