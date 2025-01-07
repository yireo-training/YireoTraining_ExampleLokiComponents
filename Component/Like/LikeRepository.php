<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Component\Like;

use Yireo\LokiComponents\Component\ComponentContext;
use Yireo\LokiComponents\Component\ComponentRepository;

/**
 * @method ComponentContext getContext()
 */
class LikeRepository extends ComponentRepository
{
    public function getValue(): mixed
    {
        return (int)$this->getContext()->getCustomerSession()->getLike();
    }

    public function saveValue(mixed $data): void
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
