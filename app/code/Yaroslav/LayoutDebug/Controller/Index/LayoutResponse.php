<?php

declare(strict_types=1);

namespace Yaroslav\LayoutDebug\Controller\Index;

use Magento\Framework\View\Result\Layout;

class LayoutResponse implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    private \Magento\Framework\View\Result\LayoutFactory $layoutFactory;

    /**
     * @param \Magento\Framework\View\Result\LayoutFactory $layoutFactory
     */
    public function __construct(\Magento\Framework\View\Result\LayoutFactory $layoutFactory)
    {
        $this->layoutFactory = $layoutFactory;
    }

    /**
     * Layout result demo: https://yaroslav-n-magento.local/ya-roslav-layout-debug/index/layoutresponse
     *
     * @return Layout
     */
    public function execute(): Layout
    {
        return $this->layoutFactory->create();
    }
}
