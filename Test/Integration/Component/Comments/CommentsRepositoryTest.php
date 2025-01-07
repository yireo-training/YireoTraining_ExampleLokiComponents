<?php
declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Test\Integration\Component\Comments;

use Magento\Customer\Model\Session;
use Magento\Framework\App\ObjectManager;
use PHPUnit\Framework\TestCase;
use YireoTraining\ExampleLokiComponents\Component\Comments\CommentsRepository;

class CommentsRepositoryTest extends TestCase
{
    public function testGetValue()
    {
        $repository = ObjectManager::getInstance()->get(CommentsRepository::class);
        $this->assertEmpty($repository->getValue());

        $session = ObjectManager::getInstance()->get(Session::class);
        $session->setComments(['test']);
        $this->assertIsArray($repository->getValue());
        $this->assertEquals(1, count($repository->getValue()));
    }
}
