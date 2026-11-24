<?php
declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Test\Integration\Component\ExceptionTest;

use Loki\Components\Component\Component;
use Loki\Components\Component\ComponentContext;
use Magento\Framework\App\ObjectManager;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use YireoTraining\ExampleLokiComponents\Component\ExceptionTest\ExceptionTestRepository;

class ExceptionTestRepositoryTest extends TestCase
{
    /**
     * @magentoConfigFixture current_store loki_example_components/general/enabled 0
     */
    public function testDoesNotThrowWhenDisabled()
    {
        $this->getRepository()->saveValue('');
        $this->addToAssertionCount(1);
    }

    /**
     * @magentoConfigFixture current_store loki_example_components/general/enabled 1
     */
    public function testThrowsWhenEnabled()
    {
        $this->expectException(RuntimeException::class);
        $this->getRepository()->saveValue('');
    }

    private function getRepository(): ExceptionTestRepository
    {
        $context = ObjectManager::getInstance()->get(ComponentContext::class);
        $component = ObjectManager::getInstance()->create(Component::class, [
            'name' => 'test',
            'context' => $context
        ]);

        $repository = ObjectManager::getInstance()->create(ExceptionTestRepository::class);
        $repository->setComponent($component);

        return $repository;
    }
}
