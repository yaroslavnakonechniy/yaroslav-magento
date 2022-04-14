<?php

declare(strict_types=1);

namespace Yaroslav\RegularCustomer\Controller\Index;

use Yaroslav\RegularCustomer\Model\DiscountRequest;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Json;

class Request implements
    \Magento\Framework\App\Action\HttpPostActionInterface,
    \Magento\Framework\App\CsrfAwareActionInterface
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     */
    private \Magento\Framework\Controller\Result\JsonFactory $jsonFactory;

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
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Yaroslav\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory,
        \Yaroslav\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->discountRequestFactory = $discountRequestFactory;
        $this->discountRequestResource = $discountRequestResource;
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
    }

    /**
     * Controller action
     *
     * @return Json
     */
    public function execute(): Json
    {
        /** @var DiscountRequest $discountRequest */
        $discountRequest = $this->discountRequestFactory->create();

        try {
            $discountRequest->setProductId((int) $this->request->getParam('product_id'))
                ->setName($this->request->getParam('name'))
                ->setEmail($this->request->getParam('email'))
                ->setStoreId($this->storeManager->getStore()->getId());

            $this->discountRequestResource->save($discountRequest);
            $message = __('You request for product %1 accepted for review!', $this->request->getParam('productName'));
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $message = __('Your request can\'t be sent. Please, contact us if you see this message.');
        }

        return $this->jsonFactory->create()
            ->setData([
                'message' => $message
            ]);
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
