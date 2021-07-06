<?php
    /**
     *
     * @author        Delescu Andrei Vlad <ad@cloudlab.at>.
     * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
     * @link          https://cloudlab.ag/
     * @date          03/22/2021
     */
    
    namespace Printq\CustomAddress\Rewrite\Model\Quote;
    
    use Magento\Framework\Exception\NoSuchEntityException;
    use Magento\Quote\Api\Data\AddressInterface;
    use Magento\Quote\Api\Data\CartInterface;
    use Magento\Quote\Model\QuoteAddressValidator;
    
    use Printq\CustomAddress\Helper\Data as Helper;
    
    /**
     * Quote shipping/billing address validator service.
     *
     * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
     */
    class PrintqQuoteAddressValidator extends QuoteAddressValidator
    {
        /**
         * Address factory.
         *
         * @var \Magento\Customer\Api\AddressRepositoryInterface
         */
        protected $addressRepository;
        
        /**
         * Customer repository.
         *
         * @var \Magento\Customer\Api\CustomerRepositoryInterface
         */
        protected $customerRepository;
        
        /**
         * @deprecated 101.1.1 This class is not a part of HTML presentation layer and should not use sessions.
         */
        protected $customerSession;
        
        
        protected $helper;
        /**
         * Constructs a quote shipping address validator service object.
         *
         * @param \Magento\Customer\Api\AddressRepositoryInterface $addressRepository
         * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository Customer repository.
         * @param \Magento\Customer\Model\Session $customerSession
         */
        public function __construct(
            \Magento\Customer\Api\AddressRepositoryInterface $addressRepository,
            \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
            \Magento\Customer\Model\Session $customerSession,
            Helper $helper
        ) {
            $this->addressRepository = $addressRepository;
            $this->customerRepository = $customerRepository;
            $this->customerSession = $customerSession;
            $this->helper = $helper;
        }
        
        /**
         * Validate address.
         *
         * @param AddressInterface $address
         * @param int|null $customerId Cart belongs to
         * @return void
         * @throws \Magento\Framework\Exception\InputException The specified address belongs to another customer.
         * @throws \Magento\Framework\Exception\NoSuchEntityException The specified customer ID or address ID is not valid.
         */
        private function doValidate(AddressInterface $address, ?int $customerId): void
        {
            //validate customer id
            if ($customerId) {
                $customer = $this->customerRepository->getById($customerId);
                if (!$customer->getId()) {
                    throw new \Magento\Framework\Exception\NoSuchEntityException(
                        __('Invalid customer id %1', $customerId)
                    );
                }
            }
            
            if ($address->getCustomerAddressId()) {
                //Existing address cannot belong to a guest
                if (!$customerId) {
                    throw new \Magento\Framework\Exception\NoSuchEntityException(
                        __('Invalid customer address id %1', $address->getCustomerAddressId())
                    );
                }
                //Validating address ID
                try {
                    $this->addressRepository->getById($address->getCustomerAddressId());
                } catch (NoSuchEntityException $e) {
                    throw new \Magento\Framework\Exception\NoSuchEntityException(
                        __('Invalid address id %1', $address->getId())
                    );
                }
                //Finding available customer's addresses
                $applicableAddressIds = $this->getAddresses($address, $customerId);
                
                if (!in_array($address->getCustomerAddressId(), $applicableAddressIds)) {
                    throw new \Magento\Framework\Exception\NoSuchEntityException(
                        __('Invalid customer address id %1', $address->getCustomerAddressId())
                    );
                }
            }
        }
        
        /**
         * Validates the fields in a specified address data object.
         *
         * @param \Magento\Quote\Api\Data\AddressInterface $addressData The address data object.
         * @return bool
         * @throws \Magento\Framework\Exception\InputException The specified address belongs to another customer.
         * @throws \Magento\Framework\Exception\NoSuchEntityException The specified customer ID or address ID is not valid.
         */
        public function validate(AddressInterface $addressData)
        {
            $this->doValidate($addressData, $addressData->getCustomerId());
            
            return true;
        }
        
        /**
         * Validate address to be used for cart.
         *
         * @param CartInterface $cart
         * @param AddressInterface $address
         * @return void
         * @throws \Magento\Framework\Exception\InputException The specified address belongs to another customer.
         * @throws \Magento\Framework\Exception\NoSuchEntityException The specified customer ID or address ID is not valid.
         */
        public function validateForCart(CartInterface $cart, AddressInterface $address): void
        {
            $this->doValidate($address, $cart->getCustomerIsGuest() ? null : $cart->getCustomer()->getId());
        }
        
        private function getAddresses($address, $customerId){
            $applicableAddressIds = array_map(function ($address) {
                /** @var \Magento\Customer\Api\Data\AddressInterface $address */
                return $address->getId();
            }, $this->customerRepository->getById($customerId)->getAddresses());
            
            $customerId = $this->helper->getCustomerId();
            if($this->helper->isEnabled() && $customerId ) {
                $addresses = $this->helper->getAddresses();
                foreach($addresses as $addr){
                    $applicableAddressIds[] = $addr->getId();
                }
            }
            return $applicableAddressIds;
        }
    }
