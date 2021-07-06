<?php
    /**
     *
     * @author        Delescu Andrei Vlad <ad@cloudlab.at>.
     * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
     * @link          https://cloudlab.ag/
     * @date          03/22/2021
     */
    
    namespace Printq\CustomAddress\Plugin\Customer\Model\Address;
    
    use Magento\Customer\Model\Address\CustomerAddressDataFormatter;
    use Magento\Customer\Api\AddressRepositoryInterface;
    use Printq\CustomAddress\Helper\Data as Helper;
    
    class CustomerAddressDataProviderPlugin
    {
        protected $customerAddressDataFormatter;
        protected $addressRepository;
        protected $magentoAddress;
        protected $helper;
        
        public function __construct(
            AddressRepositoryInterface $addressRepository,
            CustomerAddressDataFormatter $customerAddressDataFormatter,
            Helper $helper
        ){
            $this->addressRepository = $addressRepository;
            $this->customerAddressDataFormatter = $customerAddressDataFormatter;
            $this->helper = $helper;
        }
        public function afterGetAddressDataByCustomer($subject, $result, $customer)
        {
            $customerId = $this->helper->getCustomerId();
            if($this->helper->isEnabled() && $customerId ) {
                $collection = $this->helper->getAddresses();
                if( $collection->getSize() ) {
                    foreach( $collection as $address) {
                        $address = $this->addressRepository->getById($address->getId());
                        $address->setCustomerId($customer->getId());
                        $result[$address->getId()] = $this->customerAddressDataFormatter->prepareAddress( $address );
                    }
                }
            }
            return $result;
        }
    }
