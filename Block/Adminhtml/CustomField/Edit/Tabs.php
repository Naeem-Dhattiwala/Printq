<?php
/**
 *
 * @author        Krunal Padmashali <kp@cloudlab.at>.
 * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
 * @link          https://cloudlab.ag/
 * @date          07/01/2021
 */
namespace Printq\CheckoutFields\Block\Adminhtml\CustomField\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('printq_customfield_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Custom Field Information'));
    }

    /**
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'main',
            [
                'label' => __('General'),
                'title' => __('General'),
                'content' => $this->getChildHtml('main'),
                'active' => true
            ]
        );
        $this->addTab(
            'labels',
            [
                'label' => __('Manage Labels'),
                'title' => __('Manage Labels'),
                'content' => $this->getChildHtml('labels')
            ]
        );
        $this->addTab(
            'configuration',
            [
                'label' => __('Configuration'),
                'title' => __('Configuration'),
                'content' => $this->getChildHtml('configuration')
            ]
        );
        $this->addTab(
            'front',
            [
                'label' => __('Storefront Properties'),
                'title' => __('Storefront Properties'),
                'content' => $this->getChildHtml('front')
            ]
        );

        return parent::_beforeToHtml();
    }
}
