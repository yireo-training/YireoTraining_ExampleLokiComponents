<?php
declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Controller\Example;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{
    public function __construct(
        private readonly PageFactory $pageFactory
    ) {
    }

    public function execute(): ResultInterface|ResponseInterface
    {
        return $this->pageFactory->create();
    }
}
