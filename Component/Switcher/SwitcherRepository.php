<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Component\Switcher;

use Yireo\LokiComponents\Component\ComponentContext;
use Yireo\LokiComponents\Component\ComponentRepository;

/**
 * @method ComponentContext getContext()
 */
class SwitcherRepository extends ComponentRepository
{
    public function getValue(): mixed
    {
        return (int)$this->getContext()->getCustomerSession()->getTemplateSwitch();
    }

    public function saveValue(mixed $data): void
    {
        $value = (bool)$data;
        $this->getContext()->getCustomerSession()->setTemplateSwitch($value);
        $this->getGlobalMessageRegistry()->addSuccess('Toggling template: '.(int)$value);
    }
}
