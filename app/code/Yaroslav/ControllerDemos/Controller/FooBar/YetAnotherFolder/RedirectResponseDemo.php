<?php

declare(strict_types=1);

namespace Yaroslav\ControllerDemos\Controller\FooBar\YetAnotherFolder;

use Magento\Framework\Controller\Result\Redirect;

class RedirectResponseDemo implements
    \Magento\Framework\App\Action\HttpGetActionInterface
{
    private \Magento\Framework\App\RequestInterface $request;

    private \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory;

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory

    ) {
        $this->redirectFactory = $redirectFactory;
        $this->request = $request;
    }

    /**
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $result = $this->redirectFactory->create();
        return $result->setUrl('https://github.com/yaroslavnakonechniy/yaroslav-magento');

    }
}
