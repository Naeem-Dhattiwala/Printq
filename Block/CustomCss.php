<?php
    /**
     * Created by PhpStorm.
     * User: th
     * Date: 7 Aug 2017
     * Time: 17:42
     */

    namespace Printq\Core\Block;

    use Magento\Framework\Registry;
    use Magento\Framework\View\Element\Template;
    use Magento\Framework\View\Element\Template\Context;
    use Magento\Store\Model\ScopeInterface;

    class CustomCss extends Template {

        protected $_coreRegistry;

        public function __construct(
            Context $context,
            Registry $coreRegistry,
            array $data = []
        ) {
            $this->_coreRegistry = $coreRegistry;
            parent::__construct( $context, $data );
        }

        /**
         * @return \Magento\Framework\Registry
         */
        public function getCoreRegistry() : Registry {
            return $this->_coreRegistry;
        }


        public function getConfig( $config_path, $storeCode = null ) {
            return $this->_scopeConfig->getValue(
                $config_path,
                ScopeInterface::SCOPE_STORE,
                $storeCode
            );
        }

        public function getFormattedColor( $color ) {
            if ( strlen( $color ) == 6 ) {
                $color = "#" . $color;
            }

            return $color;
        }
    }
