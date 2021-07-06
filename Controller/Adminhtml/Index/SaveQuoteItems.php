<?php
declare(strict_types=1);

namespace Printq\NewFields\Controller\Adminhtml\Index;

class SaveQuoteItems extends \Magento\Backend\App\Action
{

    protected $resultPageFactory;
    protected $jsonHelper;
    protected $quoteRepository;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context  $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Quote\Model\QuoteRepository $quoteRepository,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonHelper = $jsonHelper;
        $this->logger = $logger;
        $this->quoteRepository = $quoteRepository;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $quote_id = $this->getRequest()->getParam('quoteid');
        $quote = $this->quoteRepository->get($quote_id);
        $id = $this->getRequest()->getParam('id');
        $item = $quote->getItemById($id);
        $item->setVerrechnungskostenstelle($this->getRequest()->getParam('verrechnungskostenstelle'));
        $item->setVerrechnungskonto($this->getRequest()->getParam('verrechnungskonto'));
        $item->setBemerkung($this->getRequest()->getParam('bemerkung'));
        $item->setWunschtermin($this->getRequest()->getParam('wunschtermin'));
        $item->save();
    }

    /**
     * Create json response
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function jsonResponse($response = '')
    {
        return $this->getResponse()->representJson(
            $this->jsonHelper->jsonEncode($response)
        );
    }
}