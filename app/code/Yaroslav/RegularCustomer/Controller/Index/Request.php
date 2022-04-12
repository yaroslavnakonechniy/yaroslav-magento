<?php

declare(strict_types=1);

namespace Yaroslav\RegularCustomer\Controller\Index;

use Yaroslav\RegularCustomer\Model\DiscountRequest;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Redirect;

class Request implements
    \Magento\Framework\App\Action\HttpPostActionInterface,
    \Magento\Framework\App\CsrfAwareActionInterface
{
    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     */
    private \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory;

    /**
     * @var \Magento\Framework\Message\ManagerInterface $messageManager
     */
    private \Magento\Framework\Message\ManagerInterface $messageManager;

    /**
     * @param \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @var \Yaroslav\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     */
    private \Yaroslav\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory;

    /**
     * @var \Yaroslav\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     */
    private \Yaroslav\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource;

    /**
     * @var \Magento\Framework\App\RequestInterface $request
     */
    private \Magento\Framework\App\RequestInterface $request;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private \Magento\Store\Model\StoreManagerInterface $storeManager;

    /**
     * @var \Psr\Log\LoggerInterface $logger
     */
    private \Psr\Log\LoggerInterface $logger;

    public function __construct(
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Yaroslav\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory,
        \Yaroslav\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->redirectFactory = $redirectFactory;
        $this->messageManager = $messageManager;
        $this->discountRequestFactory = $discountRequestFactory;
        $this->discountRequestResource = $discountRequestResource;
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
    }

    /**
     * Controller action
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        /** @var DiscountRequest $discountRequest */
        $discountRequest = $this->discountRequestFactory->create();

        try {
            $discountRequest->setProductId((int) $this->request->getParam('product_id'))
                ->setName($this->request->getParam('name'))
                ->setEmail($this->request->getParam('email'))
                ->setStoreId($this->storeManager->getStore()->getId());

            $this->discountRequestResource->save($discountRequest);
            $this->messageManager->addSuccessMessage(
                __('You request for product %1 accepted for review!', $this->request->getParam('productName'))
            );
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $this->messageManager->addErrorMessage(
                __('Your request can\'t be sent. Please, contact us if you see this message.')
            );
        }

        $redirect = $this->redirectFactory->create();
        $redirect->setRefererUrl();

        return $redirect;
    }

    /**
     * Create exception in case CSRF validation failed. Return null if default exception will suffice.
     *
     * @param RequestInterface $request
     * @return InvalidRequestException|null
     */
    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        return null;
    }

    /**
     * Perform custom request validation. Return null if default validation is needed.
     *
     * @param RequestInterface $request
     * @return bool|null
     */
    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return null;
    }
}
