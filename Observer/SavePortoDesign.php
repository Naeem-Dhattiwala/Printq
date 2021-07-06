<?php
    /**
     * Created by PhpStorm.
     * User: th
     * Date: 21 Aug 2017
     * Time: 10:56
     */

    namespace Printq\Core\Observer;


    use Magento\Framework\Event\Observer;
    use Magento\Framework\Event\ObserverInterface;
    use Printq\Core\Model\Config\CssGenerator;

    class SavePortoDesign implements ObserverInterface {

        protected $_cssGenerator;

        public function __construct( CssGenerator $css_generator ) {
            $this->_cssGenerator = $css_generator;
        }

        /**
         * @param Observer $observer
         *
         * @return void
         */
        public function execute( Observer $observer ) {
            $this->_cssGenerator->generateCss( $observer->getData( "website" ), $observer->getData( "store" ) );
        }
    }
