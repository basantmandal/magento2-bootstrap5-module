<?php

namespace HK2\AddBootstrap5\Controller\Demo;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

    /**
     * Initialize dependencies and set page factory.
     *
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result.
     *
     * @return Page|ResultInterface|ResponseInterface
     */
    public function execute(): Page|ResultInterface|ResponseInterface
    {
        $resultPage = $this->resultPageFactory->create();
        $version = $this->getRequest()->getParam('version', '5');

        if ($version == '4') {
            $resultPage->getConfig()->getTitle()->set(__('Bootstrap 4 Demo Page'));
        } else {
            $resultPage->getConfig()->getTitle()->set(__('Bootstrap 5 Demo Page'));
        }

        return $resultPage;
    }
}
