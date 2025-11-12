<?php
declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Test\Integration\Component\Comments;

use Loki\Components\Component\Component;
use Loki\Components\Component\ComponentContext;
use Magento\Customer\Model\Session;
use Magento\Framework\App\ObjectManager;
use PHPUnit\Framework\TestCase;
use YireoTraining\ExampleLokiComponents\Component\Comments\CommentsRepository;

class CommentsRepositoryTest extends TestCase
{
    public function testGetValue()
    {
        $context = ObjectManager::getInstance()->get(ComponentContext::class);
        $component = ObjectManager::getInstance()->create(Component::class, [
            'name' => 'test',
            'context' => $context
        ]);

        $repository = ObjectManager::getInstance()->get(CommentsRepository::class);
        $repository->setComponent($component);
        $this->assertEmpty($repository->getValue());

        $session = ObjectManager::getInstance()->get(Session::class);
        $session->setComments(['test']);
        $this->assertIsArray($repository->getValue());
        $this->assertEquals(1, count($repository->getValue()));
    }
}
