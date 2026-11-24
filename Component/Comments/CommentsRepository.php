<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Component\Comments;

use Loki\Components\Component\ComponentRepository;
use Magento\Framework\Exception\LocalizedException;
use YireoTraining\ExampleLokiComponents\Component\ExampleComponentContext;

/**
 * @method ExampleComponentContext getContext()
 */
class CommentsRepository extends ComponentRepository
{
    public const MAX_COMMENT_LENGTH = 255;
    public const MAX_COMMENTS = 20;

    public function getValue(): mixed
    {
        return (array)$this->getContext()->getCustomerSession()->getComments();
    }

    public function saveValue($value): void
    {
        if (false === is_array($value)) {
            throw new LocalizedException(__('Not an array'));
        }

        $task = $value['task'] ?? null;
        if (false === in_array($task, ['add', 'remove'], true)) {
            throw new LocalizedException(__('Invalid "task" parameter provided'));
        }

        $comment = $value['comment'] ?? null;
        if (false === is_string($comment)) {
            throw new LocalizedException(__('Invalid "comment" parameter provided'));
        }

        $customerSession = $this->getContext()->getCustomerSession();
        $comments = (array)$customerSession->getComments();

        if ($task === 'add') {
            if (mb_strlen($comment) > self::MAX_COMMENT_LENGTH) {
                throw new LocalizedException(
                    __('A comment can have no more than %1 characters', self::MAX_COMMENT_LENGTH)
                );
            }

            if (count($comments) >= self::MAX_COMMENTS) {
                throw new LocalizedException(__('You can add no more than %1 comments', self::MAX_COMMENTS));
            }

            $comments[] = $comment;
            $customerSession->setComments($comments);
            $this->getGlobalMessageRegistry()->addNotice('Added a comment');
            return;
        }

        $comments = array_values(array_filter($comments, function ($existingComment) use ($comment) {
            return $comment !== $existingComment;
        }));

        $customerSession->setComments($comments);
        $this->getGlobalMessageRegistry()->addNotice('Removed a comment');
    }
}
