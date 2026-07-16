<?php

declare(strict_types=1);

namespace HK2\AddBootstrap5\Controller\Demo;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{
    /**
     * @param PageFactory $resultPageFactory
     * @param RequestInterface $request
     */
    public function __construct(
        private readonly PageFactory $resultPageFactory,
        private readonly RequestInterface $request
    ) {
    }

    /**
     * Execute the action
     *
     * @return Page|ResultInterface
     */
    public function execute(): Page|ResultInterface
    {
        $resultPage = $this->resultPageFactory->create();

        $version = (string)$this->request->getParam('version', '5');

        $resultPage->getConfig()->getTitle()->set(
            __(
                $version === '4'
                    ? 'Bootstrap 4 Demo Page'
                    : 'Bootstrap 5 Demo Page'
            )
        );

        return $resultPage;
    }
}
