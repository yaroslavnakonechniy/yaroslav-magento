<?php

declare(strict_types=1);

namespace Yaroslav\RegularCustomer\Model;

/**
 * @method int|string|null getRequestId()
 * @method int|string|null getProductId()
 * @method $this setProductId(int $productId)
 * @method int|string|null getCustomerId()
 * @method $this setCustomerId(int $customerId)
 * @method string|null getName()
 * @method $this setName(string $name)
 * @method string|null getEmail()
 * @method $this setEmail(string $name)
 * @method string|null getAdminUserId()
 * @method $this setAdminUserId(string $admin_user_id)
 * @method int|string|null getStoreId()
 * @method $this setStoreId(int $websiteId)
 * @method int|string|null getCreatedAt()
 * @method int|string|null getUpdatedAt()
 */
class DiscountRequest extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->_init(\Yaroslav\RegularCustomer\Model\ResourceModel\DiscountRequest::class);
    }
}
