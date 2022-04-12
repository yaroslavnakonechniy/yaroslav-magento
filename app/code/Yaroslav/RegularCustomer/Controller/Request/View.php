<?php

declare(strict_types=1);

namespace Yaroslav\RegularCustomer\Controller\Request;

use Magento\Framework\View\Result\Page;

class View implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory $pageResponseFactory
     */
    private \Magento\Framework\View\Result\PageFactory $pageResponseFactory;

    /**
     * @param \Magento\Framework\View\Result\PageFactory $pageResponseFactory
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $pageResponseFactory
    ) {
        $this->pageResponseFactory = $pageResponseFactory;
    }

    /**
     * View customer requests
     *
     * @return Page
     */
    public function execute(): Page
    {
        return $this->pageResponseFactory->create();
    }
}
