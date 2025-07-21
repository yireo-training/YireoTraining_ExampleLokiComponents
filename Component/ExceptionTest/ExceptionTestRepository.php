<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Component\ExceptionTest;

use RuntimeException;
use Loki\Components\Component\ComponentRepository;

class ExceptionTestRepository extends ComponentRepository
{
    public function getValue(): mixed
    {
        return '';
    }

    public function saveValue($value): void
    {
        throw new RuntimeException('This exception was thrown in the ExceptionTestRepository');
    }
}
