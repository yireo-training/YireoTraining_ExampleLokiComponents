<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Component\Like;

use Yireo\LokiComponents\Component\ComponentViewModel;

class LikeViewModel extends ComponentViewModel
{
    public function liked(): bool
    {
        return (int)$this->getData() === 1;
    }
}
