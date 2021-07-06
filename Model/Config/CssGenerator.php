<?php
    /**
     * Created by PhpStorm.
     * User: th
     * Date: 21 Aug 2017
     * Time: 11:06
     */

    namespace Printq\Core\Model\Config;


    use Magento\Framework\Message\ManagerInterface;
    use Magento\Framework\Registry;
    use Magento\Framework\View\Context;
    use Magento\Framework\View\LayoutInterface;
    use Magento\Store\Model\StoreManagerInterface;
    use Printq\Core\Helper\CssConfig;

    class CssGenerator {

        protected $_messageManager;
        protected $_coreRegistry;
        protected $_storeManager;
        protected $_cssConfigData;
        /**
         * @var \Magento\Framework\View\LayoutInterface
         */
        protected $layout;
        /**
         * @var \Magento\Store\Model\App\Emulation
         */
        protected $emulation;

        public function __construct(
            Registry $coreRegistry,
            StoreManagerInterface $storeManager,
            LayoutInterface $layoutManager,
            ManagerInterface $messageManager,
            CssConfig $cssConfigData,
            \Magento\Store\Model\App\Emulation $emulation,
            Context $context
        ) {
            $this->_coreRegistry   = $coreRegistry;
            $this->_storeManager   = $storeManager;
            $this->_messageManager = $messageManager;
            $this->_cssConfigData  = $cssConfigData;
            $this->layout          = $context->getLayout();
            $this->emulation       = $emulation;
        }

        public function generateCss( $websiteId, $storeId ) {
            if ( ! $websiteId && ! $storeId ) {
                $websites = $this->_storeManager->getWebsites( false, false );
                foreach ( $websites as $id => $value ) {
                    $this->generateWebsiteCss( $id );
                }
            } else {
                if ( $storeId ) {
                    $this->generateStoreCss( $storeId );
                } else {
                    $this->generateWebsiteCss( $websiteId );
                }
            }
        }

        protected function generateWebsiteCss( $websiteId ) {
            $website = $this->_storeManager->getWebsite( $websiteId );
            foreach ( $website->getStoreIds() as $storeId ) {
                $this->generateStoreCss( $storeId );
            }
        }

        protected function generateStoreCss( $storeId ) {
            $store = $this->_storeManager->getStore( $storeId );
            if ( ! $store->isActive() ) {
                return;
            }
            $this->emulation->startEnvironmentEmulation( $storeId, \Magento\Framework\App\Area::AREA_FRONTEND, true);
            $storeCode      = $store->getCode();
            $designFileName = 'design_' . $storeCode . '.css';
            $templatePath   = 'Printq_Core::css/design.phtml';
            $this->_coreRegistry->register( 'printq_cssgen_store', $storeCode );

            try {
                $block = $this->layout->createBlock( 'Printq\Core\Block\CustomCss' )
                                      ->setData( 'area', 'frontend' )
                                      ->setTemplate( $templatePath )
                                      ->toHtml();
                $this->_cssConfigData->writeCss( $designFileName, $block );

                if ( empty( $block ) ) {
                    throw new \Exception( __( "Template file is empty or doesn't exist: " . $templatePath ) );
                }
            } catch ( \Exception $e ) {
                $this->_messageManager->addErrorMessage( __( 'Failed generating PrintQ CSS file: ' . $designFileName . ' in ' . $this->_cssConfigData->getCssConfigDir() ) . '. Message: ' . $e->getMessage() );
            }
            $this->_coreRegistry->unregister( 'printq_cssgen_store' );
            $this->emulation->stopEnvironmentEmulation();
        }
    }
