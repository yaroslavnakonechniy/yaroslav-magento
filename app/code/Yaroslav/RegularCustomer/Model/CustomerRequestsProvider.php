<?php

declare(strict_types=1);

namespace Yaroslav\RegularCustomer\Model;

use Yaroslav\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory as DiscountRequestCollectionFactory;
use Yaroslav\RegularCustomer\Model\ResourceModel\DiscountRequest\Collection as DiscountRequestCollection;
use Magento\Store\Model\Website;

class CustomerRequestsProvider
{
    /**
     * @var DiscountRequestCollectionFactory $discountRequestCollectionFactory
     */
    private DiscountRequestCollectionFactory $discountRequestCollectionFactory;

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private \Magento\Customer\Model\Session $customerSession;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private \Magento\Store\Model\StoreManagerInterface $storeManager;

    /**
     * @var DiscountRequestCollection $discountRequestCollection
     */
    private DiscountRequestCollection $discountRequestCollection;

    /**
     * @param DiscountRequestCollectionFactory $discountRequestCollectionFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        DiscountRequestCollectionFactory $discountRequestCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->discountRequestCollectionFactory = $discountRequestCollectionFactory;
        $this->customerSession = $customerSession;
        $this->storeManager = $storeManager;
    }

    /**
     * Cache and return a collection of discount requests for the current customer
     *
     * @return DiscountRequestCollection
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCurrentCustomerRequestCollection(): DiscountRequestCollection
    {
        if (isset($this->discountRequestCollection)) {
            return $this->discountRequestCollection;
        }

        /** @var Website $website */
        $website = $this->storeManager->getWebsite();

        /** @var DiscountRequestCollection $collection */
        $collection = $this->discountRequestCollectionFactory->create();
        $collection->addFieldToFilter('customer_id', $this->customerSession->getCustomerId());
        // @TODO: check if accounts are shared per website or not
        $collection->addFieldToFilter('store_id', ['in' => $website->getStoreIds()]);
        $this->discountRequestCollection = $collection;

        return $this->discountRequestCollection;
    }
}
