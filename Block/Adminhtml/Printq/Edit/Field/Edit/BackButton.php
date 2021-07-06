<?php
declare(strict_types=1);

namespace Printq\NewFields\Block\Adminhtml\Printq\Edit\Field\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class BackButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * @return array
     */
    public function getButtonData()
    {
        
        return [
            'label' => __('BackButton'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        $str = explode("/",$url);
        $item_id = $str[count($str)-1];
        $id = '*/*/Back/id/'.$item_id;
        return $this->getUrl($id);
    }
}