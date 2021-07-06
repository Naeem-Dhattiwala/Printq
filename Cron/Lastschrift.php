<?php

declare(strict_types=1);

namespace Printq\Lastschrift\Cron;

class Lastschrift
{
    protected $logger;

    /** @var \Magento\Sales\Model\ResourceModel\Order\Payment\Collection    */
    protected $_paymentCollectionFactory;
    /**
     * Constructor
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Sales\Model\ResourceModel\Order\Payment\CollectionFactory $paymentCollectionFactory,
        \Magento\Framework\Module\Dir\Reader $moduleReader
    )
    {
        $this->logger = $logger;
        $this->_paymentCollectionFactory = $paymentCollectionFactory;
        $baseDir = $moduleReader->getModuleDir('', 'Printq_Lastschrift');
        $this->dir = $baseDir . '/etc/PrintqPayment/';

    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
        $this->logger->addInfo("Cronjob Lastschrift is executed.");
        $dir = $this->dir;
        $date = date('F-y-m-d');
        $fileName = $date.'.xml';
        $content = '<?xml version="1.0" encoding="utf-8"?>'.PHP_EOL;
        $collection = $this->_paymentCollectionFactory->create()->addFieldToSelect('*');
        foreach ($collection as $value) {
            $content .=  '<PaymentCollection>'.PHP_EOL;
            $content .=  '<Id>'.$value->getEntity_id().'</Id>'.PHP_EOL;
            $content .=  '<Order_amount>'.$value->getAmount_ordered().'</Order_amount>'.PHP_EOL;
            $content .=  '<Shipping_amount>'.$value->getShipping_amount().'</Shipping_amount>'.PHP_EOL;
            $content .=  '<Method_title>'.$value->getAdditional_information('method_title').'</Method_title>'.PHP_EOL;
            $content .=  '<Kontoinhaber>'.$value->getKontoinhaber().'</Kontoinhaber>'.PHP_EOL;
            $content .=  '<Iban>'.$value->getIban().'</Iban>'.PHP_EOL;
            $content .=  '<Bic>'.$value->getBic().'</Bic>'.PHP_EOL;
            $content .=  '</PaymentCollection>'.PHP_EOL;
        }
        $myfile = fopen($dir . '/' . $fileName, "w") or die("Unable to open file!");
        try {
          fwrite($myfile, $content);
          fclose($myfile);
        } catch (Exception $e) {
          $this->_logger($e->getMessage());
        }
        return;
    }

}