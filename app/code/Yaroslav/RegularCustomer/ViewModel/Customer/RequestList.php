<?php

declare(strict_types=1);

namespace Yaroslav\RegularCustomer\ViewModel\Customer;

use Yaroslav\RegularCustomer\Model\ResourceModel\DiscountRequest\Collection as DiscountRequestCollection;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Catalog\Model\Product;

class RequestList implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var \Yaroslav\RegularCustomer\Model\CustomerRequestsProvider $discountRequestCollectionFactory
     */
    private \Yaroslav\RegularCustomer\Model\CustomerRequestsProvider $customerRequestsProvider;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     */
    private \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory;

    /**
     * @var ProductCollection $loadedProductCollection
     */
    private ProductCollection $loadedProductCollection;


    /**
     * @param \Yaroslav\RegularCustomer\Model\CustomerRequestsProvider $discountRequestCollectionFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param Product\Visibility $productVisibility
     */
    public function __construct(
        \Yaroslav\RegularCustomer\Model\CustomerRequestsProvider $customerRequestsProvider,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $productVisibility
    ) {
        $this->customerRequestsProvider = $customerRequestsProvider;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->productVisibility = $productVisibility;
    }

    /**
     * Get a list of customer discount requests
     *
     * @return DiscountRequestCollection
     */
    public function getDiscountRequestCollection(): DiscountRequestCollection
    {
        return $this->customerRequestsProvider->getCurrentCustomerRequestCollection();
    }

    /**
     * Get product for customer discount request
     *
     * @param int $productId
     * @return Product|null
     */
    public function getProduct(int $productId): ?Product
    {
        if (isset($this->loadedProductCollection)) {
            return $this->loadedProductCollection->getItemById($productId);
        }

        $discountRequestCollection = $this->getDiscountRequestCollection();
        $productIds = array_unique(array_filter($discountRequestCollection->getColumnValues('product_id')));

        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToFilter('entity_id', $productIds)
            ->addAttributeToSelect('name')
            ->addWebsiteFilter();
        $this->loadedProductCollection = $productCollection;

        return $this->loadedProductCollection->getItemById($productId);
    }
}
