<?php

declare(strict_types=1);

namespace Yaroslav\ControllerDemos\Controller\FooBar\YetAnotherFolder;

use Magento\Framework\Controller\Result\Raw;

class RawResponseDemo implements
    \Magento\Framework\App\Action\HttpGetActionInterface
{
    private \Magento\Framework\App\RequestInterface $request;

    private \Magento\Framework\Controller\Result\RawFactory $rawFactory;

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Controller\Result\RawFactory $rawFactory
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\Result\RawFactory $rawFactory

    ) {
        $this->rawFactory = $rawFactory;
        $this->request = $request;
    }

    /**
     * @return Raw
     */
    public function execute(): Raw
    {
        $result = $this->rawFactory->create();

        return $result->setHeader('Content-Type','text/html')
            ->setContents('
                <html>
                    <head>
                    </head>
                    <body>
                        <a href="https://yaroslav-n-magento.local/ya-roslav-controller-demos/foobar_yetanotherfolder/redirectresponsedemo">RedirectResponseDemo</a><br>
                        <a href="https://yaroslav-n-magento.local/ya-roslav-controller-demos/foobar_yetanotherfolder/jsonresponsedemo">JsonResponseDemo</a><br>
                        <a href="https://yaroslav-n-magento.local/ya-roslav-controller-demos/foobar_yetanotherfolder/forwardresponsedemo">ForwardResponseDemo</a><br>
                        <br><br>
                        <form method="get" action="jsonresponsedemo">
                            <label> vendor name:</label><br>
                            <input type="text" name="vendor" value="Yaroslav"><br><br>
                            <label> module name:</label><br>
                            <input type="text" name="module" value="Yaroslav_ControllerDemos"><br><br>
                            <button type="submit">Submit</button>
                        </form>
                    </body>
                </html>
            ');
    }
}
