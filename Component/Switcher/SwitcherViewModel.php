<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Component\Switcher;

use Yireo\LokiComponents\Component\ComponentViewModel;

class SwitcherViewModel extends ComponentViewModel
{
    public function getTemplate(): ?string
    {
        if ($this->getValue() === 1) {
            return 'YireoTraining_ExampleLokiComponents::switcher/example2.phtml';
        }

        return null;
    }
}
