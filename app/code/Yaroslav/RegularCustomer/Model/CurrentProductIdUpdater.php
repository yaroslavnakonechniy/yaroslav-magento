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
     * @var \Yaroslav\RegularCustomer\Model\Config $config
     */
    private \Yaroslav\RegularCustomer\Model\Config $config;

    /**
     * @param \Magento\Catalog\Helper\Data $productHelper
     * @param Config $config
     */
    public function __construct(
        \Magento\Catalog\Helper\Data $productHelper,
        \Yaroslav\RegularCustomer\Model\Config $config
    ) {
        $this->productHelper = $productHelper;
        $this->config = $config;
    }

    /**
     * Set current product id to jsLayout for passing it to the Knockout component
     *
     * @param array $value
     * @return array
     */
    public function update($value): array
    {
        // Product is not present when Varnish ESI block are rendered via \Magento\PageCache\Controller\Block\Esi
        if ($this->productHelper->getProduct()) {
            $value['components']['regularCustomerRequest']['children']['regularCustomerRequestForm']['config']
            ['productId'] = (int) $this->productHelper->getProduct()->getId();
            $value['components']['regularCustomerRequest']['children']['regularCustomerRequestLoginButton']['config']
            ['allowForGuests'] = (bool) $this->config->allowForGuests();
        }

        return $value;
    }
}
