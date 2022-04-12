<?php

declare(strict_types=1);

namespace Yaroslav\RegularCustomer\Controller\Request;

use Magento\Framework\View\Result\Page;

class Form implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    private \Magento\Framework\View\Result\PageFactory $pageFactory;

    /**
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     */
    public function __construct(\Magento\Framework\View\Result\PageFactory $pageFactory)
    {

        $this->pageFactory = $pageFactory;
    }

    /**
     * Lyaout result demo: https://yaroslav-n-magento.local/ya-roslav-regular-customer/request/form
     *
     *
     * @return Page
     */
    public function execute(): Page
    {
        return $this->pageFactory->create();
    }
}
