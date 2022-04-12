<?php

declare(strict_types=1);

namespace Yaroslav\RegularCustomer\Model\ResourceModel\DiscountRequest;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->_init(
            \Yaroslav\RegularCustomer\Model\DiscountRequest::class,
            \Yaroslav\RegularCustomer\Model\ResourceModel\DiscountRequest::class
        );
    }
}
