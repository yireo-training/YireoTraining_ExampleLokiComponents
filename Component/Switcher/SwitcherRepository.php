<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Component\Switcher;

use YireoTraining\ExampleLokiComponents\Component\Generic\GenericContext;
use Yireo\LokiComponents\Component\ComponentRepository;

/**
 * @method GenericContext getContext()
 */
class SwitcherRepository extends ComponentRepository
{
    protected function getData(): mixed
    {
        return (int)$this->getContext()->customerSession->getLike();
    }

    protected function saveData(mixed $data): void
    {
        $value = (bool)$data;
        $this->getContext()->customerSession->setLike($value);
        $msg = $value ? 'You liked it' : 'You did not liked it';
        $this->getGlobalMessageRegistry()->addSuccess($msg);
    }
}
