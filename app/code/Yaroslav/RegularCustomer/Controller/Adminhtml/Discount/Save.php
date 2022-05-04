<?php

declare(strict_types=1);

namespace Yaroslav\RegularCustomer\Controller\Adminhtml\Discount;

use Yaroslav\RegularCustomer\Model\Authorization;
use Magento\Framework\Controller\ResultInterface;

class Save extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    public const ADMIN_RESOURCE = Authorization::ACTION_DISCOUNT_REQUEST_EDIT;

    /**
     * @var \Yaroslav\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     */
    private \Yaroslav\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory;

    /**
     * @var \Yaroslav\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     */
    private \Yaroslav\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource;

    /**
     * Save constructor.
     * @param \Yaroslav\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     * @param \Yaroslav\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Yaroslav\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory,
        \Yaroslav\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource,
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->discountRequestFactory = $discountRequestFactory;
        $this->discountRequestResource = $discountRequestResource;
    }

    /**
     * Validate request data and save it
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $request = $this->getRequest();
        $discountRequestId = $request->getParam('request_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $discountRequest = $this->discountRequestFactory->create();
        $this->discountRequestResource->load($discountRequest, $request->getParam('request_id'));

        if ($discountRequestId && !$discountRequest->getId()) {
            $this->messageManager->addErrorMessage(__('This request no longer exists.'));

            return $resultRedirect->setPath('*/*/');
        }

        // @TODO (practice): validate Customer ID and Product ID, show error message in case they are invalid
        $discountRequest->setProductId(((int) $request->getParam('product_id')) ?: null)
            ->setCustomerId(((int) $request->getParam('customer_id')) ? : null)
            ->setName($request->getParam('name'))
            ->setEmail($request->getParam('email'))
            ->setMessage($request->getParam('message'))
            ->setStatus((int) $request->getParam('status'))
            ->setStoreId((int) $request->getParam('store_id'));

        try {
            $this->discountRequestResource->save($discountRequest);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        if ($discountRequest->getId()) {
            return $resultRedirect->setPath(
                '*/*/edit',
                [
                    'request_id' => $discountRequest->getId()
                ]
            );
        }

        return $resultRedirect->setPath('*/*/index');
    }
}
