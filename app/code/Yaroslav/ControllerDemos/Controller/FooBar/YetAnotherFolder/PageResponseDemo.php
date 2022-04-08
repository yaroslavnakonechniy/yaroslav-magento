<?php

declare(strict_types=1);

namespace Yaroslav\ControllerDemos\Controller\FooBar\YetAnotherFolder;

use Magento\Framework\View\Result\Page;

class PageResponseDemo implements \Magento\Framework\App\Action\HttpGetActionInterface
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
     * Page result demo: https://yaroslav-n-magento.local/ya-roslav-controller-demos/foobar_yetanotherfolder/pageresponsedemo
     *
     * @return Page
     */
    public function execute(): Page
    {
        return $this->pageFactory->create();
    }
}
