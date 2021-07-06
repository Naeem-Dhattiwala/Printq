<?php
/**
     * Copyright © 2016 Magento. All rights reserved.
     * See COPYING.txt for license details.
     */
    namespace Printq\Core\Block\Adminhtml\Form\Button;

    use Magento\Backend\Block\Widget\Context;
    use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

    /**
     * Class GenericButton
     */
    abstract class Generic implements ButtonProviderInterface {

        /**
         * @var Context
         */
        protected $context;

        public function __construct(
        Context $context
        ) {
            $this->context = $context;

        }

        /**
         * @return array
         */
        abstract public function getButtonData();

        public function getObjectId() {
            if( $id = $this->context->getRequest()->getParam( 'id' ) ) {
                return $id;
            }

            return null;
        }

        /**
         * Generate url by route and parameters
         *
         * @param   string $route
         * @param   array  $params
         *
         * @return  string
         */
        public function getUrl( $route = '', $params = [] ) {
            return $this->context->getUrlBuilder()->getUrl( $route, $params );
        }
    }
