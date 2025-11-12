<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Component\Comments;

use RuntimeException;
use Loki\Components\Component\ComponentContext;
use Loki\Components\Component\ComponentRepository;

/**
 * @method ComponentContext getContext()
 */
class CommentsRepository extends ComponentRepository
{
    public function getValue(): mixed
    {
        return (array)$this->getContext()->getCustomerSession()->getComments();
    }

    public function saveValue($value): void
    {
        if (false === is_array($value)) {
            throw new RuntimeException('Not an array');
        }

        if (false === isset($value['task'])) {
            throw new RuntimeException('No "task" parameter provided');
        }

        if (false === isset($value['comment'])) {
            throw new RuntimeException('No "comment" parameter provided');
        }

        $customerSession = $this->getContext()->getCustomerSession();
        $comments = (array)$customerSession->getComments();

        if ($value['task'] === 'add') {
            $comments[] = (string)$value['comment'];
            $customerSession->setComments($comments);
            $this->getGlobalMessageRegistry()->addNotice('Added a comment');
        }

        if ($value['task'] === 'remove') {
            $comments = array_filter($comments, function ($comment) use ($value) {
                return $value['comment'] !== $comment;
            });

            $customerSession->setComments($comments);
            $this->getGlobalMessageRegistry()->addNotice('Removed a comment');
        }
    }
}
