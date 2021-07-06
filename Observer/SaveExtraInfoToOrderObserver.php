<?php
namespace Printq\Lastschrift\Observer;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\OfflinePayments\Model\Banktransfer;
class SaveExtraInfoToOrderObserver implements ObserverInterface {
    protected $_inputParamsResolver;
    protected $_quoteRepository;
    protected $logger;
    protected $_state;
    public function __construct(\Magento\Webapi\Controller\Rest\InputParamsResolver $inputParamsResolver, \Magento\Quote\Model\QuoteRepository $quoteRepository, \Psr\Log\LoggerInterface $logger,\Magento\Framework\App\State $state) {
        $this->_inputParamsResolver = $inputParamsResolver;
        $this->_quoteRepository = $quoteRepository;
        $this->logger = $logger;
        $this->_state = $state;
    }
    public function execute(EventObserver $observer) {
        $inputParams = $this->_inputParamsResolver->resolve();
        if($this->_state->getAreaCode() != \Magento\Framework\App\Area::AREA_ADMINHTML){
            foreach ($inputParams as $inputParam) {
                if ($inputParam instanceof \Magento\Quote\Model\Quote\Payment) {
                    $paymentData = $inputParam->getData('additional_data');
                    $paymentOrder = $observer->getEvent()->getPayment();
                    $order = $paymentOrder->getOrder();
                    $quote = $this->_quoteRepository->get($order->getQuoteId());
                    $paymentQuote = $quote->getPayment();
                    $method = $paymentQuote->getMethodInstance()->getCode();
                    if ($method == 'lastschrift') {    
                        if(isset($paymentData['kontoinhaber'])){
                            $paymentQuote->setData('kontoinhaber', $paymentData['kontoinhaber']);
                            $paymentOrder->setData('kontoinhaber', $paymentData['kontoinhaber']);
                        }
                        if(isset($paymentData['iban'])){
                            $paymentQuote->setData('iban', $paymentData['iban']);
                            $paymentOrder->setData('iban', $paymentData['iban']);
                        }
                        if(isset($paymentData['bic'])){
                            $paymentQuote->setData('bic', $paymentData['bic']);
                            $paymentOrder->setData('bic', $paymentData['bic']);
                        }
                    }
                }
            }
        }
    }
}