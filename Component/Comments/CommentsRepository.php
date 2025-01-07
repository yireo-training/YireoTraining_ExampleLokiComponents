<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Component\Comments;

use RuntimeException;
use Yireo\LokiComponents\Component\ComponentContext;
use Yireo\LokiComponents\Component\ComponentRepository;

/**
 * @method ComponentContext getContext()
 */
class CommentsRepository extends ComponentRepository
{
    public function getValue(): mixed
    {
        return (array)$this->getContext()->getCustomerSession()->getComments();
    }

    public function saveValue($data): void
    {
        if (false === is_array($data)) {
            throw new RuntimeException('Not an array');
        }

        if (false === isset($data['task'])) {
            throw new RuntimeException('No "task" parameter provided');
        }

        if (false === isset($data['comment'])) {
            throw new RuntimeException('No "comment" parameter provided');
        }

        $customerSession = $this->getContext()->getCustomerSession();
        $comments = (array)$customerSession->getComments();

        if ($data['task'] === 'add') {
            $comments[] = (string)$data['comment'];
            $customerSession->setComments($comments);
            $this->getGlobalMessageRegistry()->addNotice('Added a comment');
        }

        if ($data['task'] === 'remove') {
            $comments = array_filter($comments, function ($comment) use ($data) {
                return $data['comment'] !== $comment;
            });

            $customerSession->setComments($comments);
            $this->getGlobalMessageRegistry()->addNotice('Removed a comment');
        }
    }
}
