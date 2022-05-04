<?php

declare(strict_types=1);

namespace Yaroslav\RegularCustomer\Controller\Adminhtml\Discount;

use Yaroslav\RegularCustomer\Model\Authorization;
use Magento\Backend\Model\View\Result\Forward;
use Magento\Framework\Controller\ResultInterface;

class NewRequest extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    public const ADMIN_RESOURCE = Authorization::ACTION_DISCOUNT_REQUEST_EDIT;
    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory $forwardFactory
     */
    private \Magento\Backend\Model\View\Result\ForwardFactory $forwardFactory;

    /**
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $forwardFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\Model\View\Result\ForwardFactory $forwardFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->forwardFactory = $forwardFactory;
    }


    /**
     * Create new request action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Forward $resultForward */
        $resultForward = $this->forwardFactory->create();

        return $resultForward->forward('edit');
    }
}
