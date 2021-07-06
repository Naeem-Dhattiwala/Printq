<?php
/**
 * Created by PhpStorm.
 * User: vb
 * Date: 27 Jan 2021
 * Time: 13:50
 */

namespace Printq\Core\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Customer\Model\Address\Config as AddressConfig;
use Magento\Customer\Model\Address\Mapper as AddressMapper;
use Magento\Customer\Api\AddressRepositoryInterface;

class AddressRenderer extends AbstractHelper {

    /*
     * @var AddressConfig
     */
    protected $_addressConfig;
    /*
     * @var AddressMapper
     */
    protected $_addressMapper;
    /*
     * @var AddressRepositoryInterface
     */
    protected $_addressRepository;

    public function __construct(
        AddressConfig $addressConfig,
        AddressMapper $addressMapper,
        AddressRepositoryInterface $addressRepository
    ) {
       $this->_addressConfig = $addressConfig;
       $this->_addressMapper = $addressMapper;
       $this->_addressRepository = $addressRepository;
    }

    /*
     * Magento\Customer\Model\Address\AbstractAddress->format()
     */
    public function formatCustomerAddress($addressId, $type) {
        $address = $this->_addressRepository->getById($addressId);
        $renderer = $this->_addressConfig->getFormatByCode($type)->getRenderer();
        $addressData = $this->_addressMapper->toFlatArray($address);
        return $renderer->renderArray($addressData);
    }
}
