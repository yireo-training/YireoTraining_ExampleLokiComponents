<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Component\Like;

use RuntimeException;
use YireoTraining\ExampleLokiComponents\Component\Generic\GenericContext;
use Yireo\LokiComponents\Component\ComponentRepository;

/**
 * @method GenericContext getContext()
 */
class LikeRepository extends ComponentRepository
{
    protected function getData(): mixed
    {
        return (int)$this->getContext()->getCustomerSession()->getLike();
    }

    protected function saveData(mixed $data): void
    {
        $value = (bool)$data;
        $this->getContext()->getCustomerSession()->setLike($value);

        if ($value) {
            $this->getGlobalMessageRegistry()->addNotice('You liked it');
        } else {
            $this->getGlobalMessageRegistry()->addWarning('You did not like it');
        }
    }
}
