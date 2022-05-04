<?php

declare(strict_types=1);

namespace Yaroslav\RegularCustomer\Ui\Component\DiscountRequest\Listing;

use Yaroslav\RegularCustomer\Model\Authorization;

class Columns extends \Magento\Ui\Component\Listing\Columns
{
    /**
     * @var \Yaroslav\RegularCustomer\Model\Authorization $authorization
     */
    private \Yaroslav\RegularCustomer\Model\Authorization $authorization;

    /**
     * @param \Yaroslav\RegularCustomer\Model\Authorization $authorization
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Yaroslav\RegularCustomer\Model\Authorization $authorization,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $components, $data);
        $this->authorization = $authorization;
    }

    /**
     * @inheritdoc
     */
    public function prepare(): void
    {
        parent::prepare();

        $configuration = $this->getConfiguration();

        if (!$this->authorization->isAllowed(Authorization::ACTION_DISCOUNT_REQUEST_EDIT)) {
            $configuration['editorConfig']['enabled'] = false;
        }

        $this->setData('config', $configuration);
    }
}
