<?php

declare(strict_types=1);

namespace Yaroslav\RegularCustomer\Model;

class Authorization
{
    public const ACTION_DISCOUNT_REQUEST_EDIT = 'Yaroslav_RegularCustomer::edit';

    public const ACTION_DISCOUNT_REQUEST_DELETE = 'Yaroslav_RegularCustomer::delete';

    /**
     * @var \Magento\Framework\AuthorizationInterface $authorization
     */
    private \Magento\Framework\AuthorizationInterface $authorization;

    /**
     * Authorization constructor.
     * @param \Magento\Framework\AuthorizationInterface $authorization
     */
    public function __construct(
        \Magento\Framework\AuthorizationInterface $authorization
    ) {
        $this->authorization = $authorization;
    }

    /**
     * Check if resource is available for admin user
     *
     * @param string $alcResource
     * @return bool
     */
    public function isAllowed(string $alcResource): bool
    {
        return $this->authorization->isAllowed($alcResource);
    }
}
