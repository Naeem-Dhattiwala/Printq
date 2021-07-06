<?php
    /**
     *
     * @author        Delescu Andrei Vlad <ad@cloudlab.at>.
     * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
     * @link          https://cloudlab.ag/
     * @date          03/22/2021
     */
    
    namespace Printq\CustomAddress\Logger\Handler;
    
    use Magento\Framework\Logger\Handler\Base as MagentoLoggerBaseHandler;
    use Monolog\Logger as MonologLogger;
    
    class Manage extends MagentoLoggerBaseHandler{
        
        protected $loggerType = MonologLogger::DEBUG;
        
        protected $fileName = '/var/log/printq/custom_address_changes.log';
    }
