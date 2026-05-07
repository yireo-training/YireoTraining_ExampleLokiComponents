<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Component;

use Loki\Components\Component\AbstractComponentContext;
use Magento\Customer\Model\Session as CustomerSession;

/**
 * @method CustomerSession getCustomerSession()
 */
class ExampleComponentContext extends AbstractComponentContext
{
}
