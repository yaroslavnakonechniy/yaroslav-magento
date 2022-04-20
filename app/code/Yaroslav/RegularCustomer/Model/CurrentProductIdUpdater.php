<?php

declare(strict_types=1);

namespace Yaroslav\RegularCustomer\Model;

class CurrentProductIdUpdater implements \Magento\Framework\View\Layout\Argument\UpdaterInterface
{
    /**
     * @var \Magento\Catalog\Helper\Data $productHelper
     */
    private \Magento\Catalog\Helper\Data $productHelper;

    /**
     * @param \Magento\Catalog\Helper\Data $productHelper
     */
    public function __construct(\Magento\Catalog\Helper\Data $productHelper)
    {
        $this->productHelper = $productHelper;
    }

    /**
     * Set current product id to jsLayout for passing it to the Knockout component
     *
     * @param array $value
     * @return array
     */
    public function update($value): array
    {
        $value['components']['regularCustomerRequest']['children']['regularCustomerRequestForm']['config']
        ['productId'] = (int) $this->productHelper->getProduct()->getId();

        return $value;
    }
}
