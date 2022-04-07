<?php

declare(strict_types=1);

namespace Yaroslav\ControllerDemos\Controller\FooBar\YetAnotherFolder;

use Magento\Framework\Controller\Result\Json;

class JsonResponseDemo implements
    \Magento\Framework\App\Action\HttpGetActionInterface
{
    private \Magento\Framework\App\RequestInterface $request;

    private \Magento\Framework\Controller\Result\JsonFactory $jsonFactory;

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory

    ) {
        $this->jsonFactory = $jsonFactory;
        $this->request = $request;
    }

    /**
     * @return Json
     */
    public function execute(): Json
    {
        $result = $this->jsonFactory->create();

        return $result->setData([
            'parameter-1' => $this->request->getParam('vendor','Yaroslav'),
            'parameter-2' => $this->request->getParam('module','Yaroslav_ControllerDemos')
        ]);
    }
}
