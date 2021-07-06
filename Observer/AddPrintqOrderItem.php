<?php
namespace Printq\NewFields\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\ObjectManager;
use Printq\NewFields\Model\NewFieldsFactory;
use Printq\NewFields\Model\NewCustomTableFieldsFactory;

class AddPrintqOrderItem implements ObserverInterface
{
	protected $newFieldsFactory;

	protected $orderRepository;

    protected $newCustomTableFieldsFactory;

	public function __construct(
	    \Magento\Quote\Model\QuoteFactory $quoteFactory,
	    NewFieldsFactory $newFieldsFactory,
        NewCustomTableFieldsFactory $newCustomTableFieldsFactory,
	    \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
    	array $data = []
	) {
	    $this->orderRepository = $orderRepository;
	    $this->newFieldsFactory = $newFieldsFactory;
        $this->newCustomTableFieldsFactory = $newCustomTableFieldsFactory;
	    $this->quoteFactory = $quoteFactory;
	}
	public function execute(Observer $observer) {

        $orderId = $observer->getEvent()->getOrderIds();
        $order = $this->orderRepository->get($orderId[0]);
        $items = $order->getAllVisibleItems();
        foreach ($items as $item) {
        	$data = [
                'order_id' => $orderId[0],
                'verrechnungskostenstelle' => $item->getVerrechnungskostenstelle(),
                'verrechnungskonto' => $item->getVerrechnungskonto(),
                'bemerkung' => $item->getBemerkung(),
                'wunschtermin' => $item->getWunschtermin(),
                'product_id' => $item->getProduct_id(),
                'product_name' => $item->getName(),
            ];	
			$this->newFieldsFactory->create(['order_id' => $orderId[0]])->addData($data)->save();
            $data2 = [
                'order_id' => $orderId[0],
                'product_id' => $item->getProduct_id(),
                'product_name' => $item->getName(),
            ];
            $this->newCustomTableFieldsFactory->create(['order_id' => $orderId[0]])->addData($data2)->save();
        }
    }
}