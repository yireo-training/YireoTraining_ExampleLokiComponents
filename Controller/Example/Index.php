<?php
declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Controller\Example;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\View\Result\PageFactory;
use YireoTraining\ExampleLokiComponents\Config\Config;

class Index implements HttpGetActionInterface
{
    public function __construct(
        private readonly PageFactory $pageFactory,
        private readonly Config $config
    ) {
    }

    public function execute(): ResultInterface|ResponseInterface
    {
        if (false === $this->config->isEnabled()) {
            throw new NotFoundException(__('Page not found.'));
        }

        return $this->pageFactory->create();
    }
}
