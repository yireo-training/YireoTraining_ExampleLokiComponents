<?php
declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Test\Integration\Component\Notification;

use Loki\Components\Component\Component;
use Loki\Components\Component\ComponentContext;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Message\Manager as MessageManager;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use YireoTraining\ExampleLokiComponents\Component\Notification\NotificationRepository;

class NotificationRepositoryTest extends TestCase
{
    protected function setUp(): void
    {
        $this->getMessageManager()->getMessages(true);
    }

    public function testAddsGlobalMessage()
    {
        $this->getRepository()->saveValue(['area' => 'global', 'type' => 'success', 'text' => 'Hello']);
        $messages = $this->getMessageManager()->getMessages(true);
        $this->assertSame(1, $messages->getCount());
        $this->assertSame('Hello', $messages->getLastAddedMessage()->getText());
    }

    public function testAddsLocalMessage()
    {
        $repository = $this->getRepository();
        $repository->saveValue(['area' => 'local', 'type' => 'error', 'text' => 'Hello']);
        $localMessages = $repository->getLocalMessageRegistry()->getMessages();
        $this->assertCount(1, $localMessages);
        $this->assertSame('error', $localMessages[0]->getType());
    }

    #[DataProvider('getInvalidData')]
    public function testIgnoresInvalidData(array $data)
    {
        $repository = $this->getRepository();
        $repository->saveValue($data);
        $this->assertSame(0, $this->getMessageManager()->getMessages(true)->getCount());
        $this->assertFalse($repository->getLocalMessageRegistry()->hasMessages());
    }

    public static function getInvalidData(): array
    {
        return [
            [['area' => 'global', 'type' => 'success']],
            [['area' => 'foo', 'type' => 'success', 'text' => 'Hello']],
            [['area' => 'local', 'type' => 'foo', 'text' => 'Hello']],
            [['area' => 'local', 'type' => 'success', 'text' => ['Hello']]],
            [['area' => 'global', 'type' => 'error', 'text' => '']],
            [['area' => 'global', 'type' => 'error', 'text' => str_repeat('a', 256)]],
            [['area' => ['global'], 'type' => 'error', 'text' => 'Hello']],
        ];
    }

    private function getRepository(): NotificationRepository
    {
        $context = ObjectManager::getInstance()->get(ComponentContext::class);
        $component = ObjectManager::getInstance()->create(Component::class, [
            'name' => 'test',
            'context' => $context
        ]);

        $repository = ObjectManager::getInstance()->create(NotificationRepository::class);
        $repository->setComponent($component);

        return $repository;
    }

    private function getMessageManager(): MessageManager
    {
        return ObjectManager::getInstance()->get(MessageManager::class);
    }
}
