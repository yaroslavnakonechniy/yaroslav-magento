<?php

declare(strict_types=1);

namespace Yaroslav\RegularCustomer\Controller\Request;

use Magento\Framework\Controller\ResultInterface;

class View implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory $pageResponseFactory
     */
    private \Magento\Framework\View\Result\PageFactory $pageResponseFactory;

    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     */
    private \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory;

    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory
     */
    private \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory;


    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private \Magento\Customer\Model\Session $customerSession;

    /**
     * @var \Magento\Customer\Model\Url $url
     */
    private \Magento\Customer\Model\Url $url;

    /**
     * @var \Yaroslav\RegularCustomer\Model\Config $config
     */
    private \Yaroslav\RegularCustomer\Model\Config $config;



    /**
     * @param \Magento\Framework\View\Result\PageFactory $pageResponseFactory
     * @param \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     * @param \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Model\Url $url
     * @param \Yaroslav\RegularCustomer\Model\Config $config
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $pageResponseFactory,
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory,
        \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\Url $url,
        \Yaroslav\RegularCustomer\Model\Config $config
    ) {
        $this->pageResponseFactory = $pageResponseFactory;
        $this->redirectFactory = $redirectFactory;
        $this->customerSession = $customerSession;
        $this->forwardFactory = $forwardFactory;
        $this->url = $url;
        $this->config = $config;
    }

    /**
     * View customer requests
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        if (!$this->config->enabled()) {
            return $this->forwardFactory->create()
                ->setController('index')
                ->forward('defaultNoRoute');
        }

        if (!$this->customerSession->isLoggedIn()) {
            return $this->redirectFactory->create()->setUrl(
                $this->url->getLoginUrl()
            );
        }

        return $this->pageResponseFactory->create();
    }
}
