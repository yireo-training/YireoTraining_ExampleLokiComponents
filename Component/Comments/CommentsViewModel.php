<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Component\Comments;

use Yireo\LokiComponents\Component\ComponentViewModel;

class CommentsViewModel extends ComponentViewModel
{
    public function getComments(): array
    {
        return (array)$this->getData();
    }
}
