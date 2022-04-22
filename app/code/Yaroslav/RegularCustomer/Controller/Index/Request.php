<?php

declare(strict_types=1);

namespace Yaroslav\RegularCustomer\Controller\Index;

use Yaroslav\RegularCustomer\Controller\InvalidFormRequestException;
use Yaroslav\RegularCustomer\Model\DiscountRequest;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Store\Model\ScopeInterface;

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

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private \Magento\Customer\Model\Session $customerSession;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     */
    private \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory;

    /**
     * @var \Yaroslav\RegularCustomer\Model\Config $config
     */
    private \Yaroslav\RegularCustomer\Model\Config $config;


    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Yaroslav\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory,
        \Yaroslav\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Yaroslav\RegularCustomer\Model\Config $config,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->discountRequestFactory = $discountRequestFactory;
        $this->discountRequestResource = $discountRequestResource;
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->config = $config;
        $this->customerSession = $customerSession;
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
        $response = $this->jsonFactory->create();

        try {
            if (!$this->config->enabled()) {
                throw new InvalidFormRequestException();
            }

            if (!$this->customerSession->isLoggedIn() && !$this->config->allowForGuests()) {
                throw new InvalidFormRequestException();
            }

            $customerId = $this->customerSession->getCustomerId()
                ? (int) $this->customerSession->getCustomerId()
                : null;

            if ($this->customerSession->isLoggedIn()) {
                $name = $this->customerSession->getCustomer()->getName();
                $email = $this->customerSession->getCustomer()->getEmail();
            } else {
                $name = $this->request->getParam('name');
                $email = $this->request->getParam('email');
            }

            $productId = (int) $this->request->getParam('product_id');
            /** @var ProductCollection $productCollection */
            $productCollection = $this->productCollectionFactory->create();
            $productCollection->addIdFilter($productId)
                ->setPageSize(1);
            $product = $productCollection->getFirstItem();
            $productId = (int) $product->getId();

            if (!$productId) {
                throw new \InvalidArgumentException("Product with id $productId does not exist");
            }

            $discountRequest->setCustomerId($customerId)
                ->setName($name)
                ->setEmail($email)
                ->setProductId($productId)
                ->setStoreId($this->storeManager->getStore()->getId());

            $this->discountRequestResource->save($discountRequest);

            if (!$this->customerSession->isLoggedIn()) {
                $this->customerSession->setDiscountRequestCustomerName($name);
                $this->customerSession->setDiscountRequestCustomerEmail($email);
                $productIds = $this->customerSession->getDiscountRequestProductIds() ?? [];
                $productIds[] = $productId;
                $this->customerSession->setDiscountRequestProductIds(array_unique($productIds));
            }

            return $response->setData([
                'message' => __(
                    'You request for product %1 accepted for review!',
                    $this->request->getParam('productName')
                )
            ]);
        } catch (\Exception $e) {
            if (!($e instanceof InvalidFormRequestException)) {
                $this->logger->error($e->getMessage());
            }
        }

        return $response->setHttpResponseCode(400);
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
