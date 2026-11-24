<?php
declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Test\Integration\Component\Comments;

use Loki\Components\Component\Component;
use Loki\Components\Component\ComponentContext;
use Magento\Customer\Model\Session;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\LocalizedException;
use PHPUnit\Framework\TestCase;
use YireoTraining\ExampleLokiComponents\Component\Comments\CommentsRepository;

class CommentsRepositoryTest extends TestCase
{
    protected function setUp(): void
    {
        ObjectManager::getInstance()->get(Session::class)->setComments([]);
    }

    public function testGetValue()
    {
        $repository = $this->getRepository();
        $this->assertEmpty($repository->getValue());

        $session = ObjectManager::getInstance()->get(Session::class);
        $session->setComments(['test']);
        $this->assertIsArray($repository->getValue());
        $this->assertEquals(1, count($repository->getValue()));
    }

    public function testAddAndRemoveComment()
    {
        $repository = $this->getRepository();
        $repository->saveValue(['task' => 'add', 'comment' => 'foo']);
        $repository->saveValue(['task' => 'add', 'comment' => 'bar']);
        $this->assertSame(['foo', 'bar'], $repository->getValue());

        $repository->saveValue(['task' => 'remove', 'comment' => 'foo']);
        $this->assertSame(['bar'], $repository->getValue());
    }

    public function testRejectsTooLongComment()
    {
        $repository = $this->getRepository();
        $this->expectException(LocalizedException::class);
        $repository->saveValue([
            'task' => 'add',
            'comment' => str_repeat('a', CommentsRepository::MAX_COMMENT_LENGTH + 1),
        ]);
    }

    public function testAcceptsCommentWithMaximumLength()
    {
        $repository = $this->getRepository();
        $comment = str_repeat('a', CommentsRepository::MAX_COMMENT_LENGTH);
        $repository->saveValue(['task' => 'add', 'comment' => $comment]);
        $this->assertSame([$comment], $repository->getValue());
    }

    public function testRejectsTooManyComments()
    {
        $repository = $this->getRepository();
        for ($i = 0; $i < CommentsRepository::MAX_COMMENTS; $i++) {
            $repository->saveValue(['task' => 'add', 'comment' => 'comment '.$i]);
        }

        try {
            $repository->saveValue(['task' => 'add', 'comment' => 'one too many']);
            $this->fail('Expected exception when adding too many comments');
        } catch (LocalizedException $exception) {
            $this->assertCount(CommentsRepository::MAX_COMMENTS, $repository->getValue());
        }
    }

    public function testRejectsNonStringComment()
    {
        $repository = $this->getRepository();
        $this->expectException(LocalizedException::class);
        $repository->saveValue(['task' => 'add', 'comment' => ['foo']]);
    }

    public function testRejectsUnknownTask()
    {
        $repository = $this->getRepository();
        try {
            $repository->saveValue(['task' => 'clear', 'comment' => 'foo']);
            $this->fail('Expected exception for an unknown task');
        } catch (LocalizedException $exception) {
            $this->assertEmpty($repository->getValue());
        }
    }

    private function getRepository(): CommentsRepository
    {
        $context = ObjectManager::getInstance()->get(ComponentContext::class);
        $component = ObjectManager::getInstance()->create(Component::class, [
            'name' => 'test',
            'context' => $context
        ]);

        $repository = ObjectManager::getInstance()->create(CommentsRepository::class);
        $repository->setComponent($component);

        return $repository;
    }
}
