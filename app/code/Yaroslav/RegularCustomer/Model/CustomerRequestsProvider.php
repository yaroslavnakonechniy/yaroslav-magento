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
     * @var \Magento\Customer\Model\Config\Share $shareConfig
     */
    private \Magento\Customer\Model\Config\Share $shareConfig;

    /**
     * @param DiscountRequestCollectionFactory $discountRequestCollectionFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Customer\Model\Config\Share $shareConfig
     */
    public function __construct(
        DiscountRequestCollectionFactory $discountRequestCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Config\Share $shareConfig
    ) {
        $this->discountRequestCollectionFactory = $discountRequestCollectionFactory;
        $this->customerSession = $customerSession;
        $this->storeManager = $storeManager;
        $this->shareConfig = $shareConfig;
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

        // We need to decide whether we want to show requests from other websites or not
        // Maybe we can add config for this and show website name/url in case the request is from another website
        // A simple way to handle this is always adding the filter
        if ($this->shareConfig->isWebsiteScope()) {
            $collection->addFieldToFilter('store_id', ['in' => $website->getStoreIds()]);
        }

        $this->discountRequestCollection = $collection;

        return $this->discountRequestCollection;
    }
}
