<?php
namespace Printq\NewFields\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Printq\NewFields\Model\NewFieldsFactory;
use Printq\NewFields\Model\NewCustomTableFieldsFactory;

class AddAdminPrintqOrderItem implements ObserverInterface
{
	protected $newFieldsFactory;

    protected $newCustomTableFieldsFactory;

	public function __construct(
	    NewFieldsFactory $newFieldsFactory,
        NewCustomTableFieldsFactory $newCustomTableFieldsFactory,
    	array $data = []
	) {
	    $this->newFieldsFactory = $newFieldsFactory;
        $this->newCustomTableFieldsFactory = $newCustomTableFieldsFactory;
	}
	public function execute(Observer $observer) {
        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getId();
        
        $items = $order->getAllVisibleItems();
        foreach ($items as $item) {
        	$data = [
                'order_id' => $item->getOrderId(),
                'verrechnungskostenstelle' => $item->getVerrechnungskostenstelle(),
                'verrechnungskonto' => $item->getVerrechnungskonto(),
                'bemerkung' => $item->getBemerkung(),
                'wunschtermin' => $item->getWunschtermin(),
            ];
			$this->newFieldsFactory->create(['order_id' => $item->getOrderId()])->addData($data)->save();
            $data2 = [
                'order_id' => $item->getOrderId()
            ];
            $this->newCustomTableFieldsFactory->create(['order_id' => $item->getOrderId()])->addData($data2)->save();
        }
    }
}