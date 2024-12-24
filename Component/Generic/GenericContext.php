<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Component\Generic;

use Magento\Customer\Model\Session as CustomerSession;
use Yireo\LokiComponents\Component\ComponentContextInterface;

class GenericContext implements ComponentContextInterface
{
    public function __construct(
        public readonly CustomerSession $customerSession,
    ){
    }
}
