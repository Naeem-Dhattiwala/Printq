<?php
    /**
     * Created by PhpStorm.
     * User: th
     * Date: 21 Aug 2017
     * Time: 11:14
     */

    namespace Printq\Core\Helper;


    use Magento\Framework\App\Filesystem\DirectoryList;
    use Magento\Framework\App\Helper\AbstractHelper;
    use Magento\Framework\App\Helper\Context;
    use Magento\Framework\Filesystem;
    use Magento\Framework\UrlInterface;
    use Magento\Store\Model\StoreManagerInterface;

    class CssConfig extends AbstractHelper {

        /**
         * @var \Magento\Framework\Filesystem
         */
        protected $_filesystem;
        /**
         * @var \Magento\Store\Model\StoreManagerInterface
         */
        protected $_storeManager;

        /**
         * @var string
         */
        protected $generatedCssDir;

        const THEME_CSS_PATH = 'printq/theme_css/';

        public function __construct(
            Context $context,
            Filesystem $filesystem,
            StoreManagerInterface $storeManager
        ) {

            parent::__construct( $context );

            $this->_filesystem     = $filesystem;
            $this->_storeManager   = $storeManager;
            $this->generatedCssDir = $this->_filesystem->getDirectoryWrite( DirectoryList::MEDIA )
                                                       ->getAbsolutePath( self::THEME_CSS_PATH );
        }

        public function getCssConfigDir() {
            return $this->generatedCssDir;
        }

        /**
         * @param $file
         * @param $css
         *
         * @throws \Magento\Framework\Exception\FileSystemException
         */
        public function writeCss( $file, $css ) {
            $this->_filesystem->getDirectoryWrite( DirectoryList::MEDIA )
                              ->writeFile( self::THEME_CSS_PATH . $file, $css );
        }

        public function getBaseMediaUrl() {
            return $this->_storeManager->getStore()->getBaseUrl( UrlInterface::URL_TYPE_MEDIA );
        }

        public function getCssFileName() {
            return 'design_' . $this->_storeManager->getStore()->getCode() . '.css';
        }

        public function designFileExists() {
            $file = $this->getCssConfigDir() . DIRECTORY_SEPARATOR . $this->getCssFileName();
            return is_file($file);
        }

        public function getDesignFile() {
            $time = filemtime($this->generatedCssDir . $this->getCssFileName());
            return $this->getBaseMediaUrl() . self::THEME_CSS_PATH . $this->getCssFileName() . '?_=' . $time;
        }

    }
