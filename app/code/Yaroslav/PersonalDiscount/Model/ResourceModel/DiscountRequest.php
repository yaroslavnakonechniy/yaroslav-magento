<?php

declare(strict_types=1);

namespace Yaroslav\PersonalDiscount\Model\ResourceModel;

class DiscountRequest extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected $_idFieldName = 'discount_request_id';

    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init('dv_campus_personal_discount_request', 'discount_request_id');
    }
}
