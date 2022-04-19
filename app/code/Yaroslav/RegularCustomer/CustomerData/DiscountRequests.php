<?php

declare(strict_types=1);

namespace Yaroslav\RegularCustomer\CustomerData;

class DiscountRequests implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    /**
     * @var \Yaroslav\RegularCustomer\Model\CustomerRequestsProvider $customerRequestsProvider
     */
    private \Yaroslav\RegularCustomer\Model\CustomerRequestsProvider $customerRequestsProvider;

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private \Magento\Customer\Model\Session $customerSession;

    /**
     * @param \Yaroslav\RegularCustomer\Model\CustomerRequestsProvider $customerRequestsProvider
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        \Yaroslav\RegularCustomer\Model\CustomerRequestsProvider $customerRequestsProvider,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->customerRequestsProvider = $customerRequestsProvider;
        $this->customerSession = $customerSession;
    }

    /**
     * @inheritDoc
     */
    public function getSectionData(): array
    {
        $name = (string) $this->customerSession->getDiscountRequestCustomerName();
        $email = (string) $this->customerSession->getDiscountRequestCustomerEmail();

        if ($this->customerSession->isLoggedIn()) {
            if (!$name) {
                $name = $this->customerSession->getCustomer()->getName();
            }

            if (!$email) {
                $email = $this->customerSession->getCustomer()->getEmail();
            }

            $discountRequestCollection = $this->customerRequestsProvider->getCurrentCustomerRequestCollection();
            $productIds = $discountRequestCollection->getColumnValues('product_id');
            $productIds = array_unique($productIds);
            $productIds = array_values(array_map('intval', $productIds));
        } else {
            $productIds = (array) $this->customerSession->getDiscountRequestProductIds();
        }
        return [
            'name' => $name,
            'email' => $email,
            'productIds' => $productIds,
            'isLoggedIn' => $this->customerSession->isLoggedIn()
        ];
    }
}
