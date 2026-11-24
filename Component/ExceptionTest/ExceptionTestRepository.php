<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Component\ExceptionTest;

use RuntimeException;
use Loki\Components\Component\ComponentRepository;
use YireoTraining\ExampleLokiComponents\Config\Config;

class ExceptionTestRepository extends ComponentRepository
{
    public function __construct(
        private readonly Config $config
    ) {
    }

    public function getValue(): mixed
    {
        return '';
    }

    public function saveValue($value): void
    {
        if (false === $this->config->isEnabled()) {
            return;
        }

        $customerSession = $this->getContext()->getCustomerSession();
        $exceptionCounter = (int)$customerSession->getExceptionCounter();
        $exceptionCounter++;
        $customerSession->setExceptionCounter($exceptionCounter);

        throw new RuntimeException('This exception was thrown in the ExceptionTestRepository: '.$exceptionCounter);
    }
}
