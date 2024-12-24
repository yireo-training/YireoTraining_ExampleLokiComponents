<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Component\Comments;

use RuntimeException;
use YireoTraining\ExampleLokiComponents\Component\Generic\GenericContext;
use Yireo\LokiComponents\Component\ComponentRepository;

/**
 * @method GenericContext getContext()
 */
class CommentsRepository extends ComponentRepository
{
    protected function getData(): mixed
    {
        return (array)$this->getContext()->customerSession->getComments();
    }

    protected function saveData($data): void
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

        $customerSession = $this->getContext()->customerSession;
        $comments = (array)$customerSession->getComments();

        if ($data['task'] === 'add') {
            $comments[] = (string)$data['comment'];
            $customerSession->setComments($comments);
            $this->messageManager->addGlobalNotice('Added a comment');
        }

        if ($data['task'] === 'remove') {
            $comments = array_filter($comments, function ($comment) use ($data) {
                return $data['comment'] !== $comment;
            });

            $customerSession->setComments($comments);
            $this->messageManager->addGlobalNotice('Removed a comment');
        }
    }
}
