<?php

declare(strict_types=1);

namespace Yaroslav\RegularCustomer\Block\Product\View;

class DiscountRequest extends \Magento\Framework\View\Element\Template
{
    /**
     * Get cache key information incl. current product ID
     *
     * @return array
     */
    public function getCacheKeyInfo(): array
    {
        return array_merge(parent::getCacheKeyInfo(), ['product_id' => $this->getProduct()->getId()]);
    }
}
