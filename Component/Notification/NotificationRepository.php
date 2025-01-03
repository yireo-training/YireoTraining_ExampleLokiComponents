<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Component\Notification;

use Yireo\LokiComponents\Component\ComponentContext;
use Yireo\LokiComponents\Component\ComponentRepository;

/**
 * @method ComponentContext getContext()
 */
class NotificationRepository extends ComponentRepository
{
    protected function getData(): mixed
    {
        $this->getGlobalMessageRegistry()->addNotice('Hit the global buttons');

        if (false === $this->getContext()->isAjax()) {
            $this->getLocalMessageRegistry()->addNotice($this->component, 'Hit the local buttons');
        }

        return null;
    }

    protected function saveData(mixed $data): void
    {
        $data = (array)$data;
        if (!isset($data['area']) || !isset($data['type']) || !isset($data['text'])) {
            return;
        }

        if ($data['area'] === 'global') {
            switch ($data['type']) {
                case 'success':
                    $this->getGlobalMessageRegistry()->addSuccess($data['text']);
                    break;
                case 'warning':
                    $this->getGlobalMessageRegistry()->addWarning($data['text']);
                    break;
                case 'error':
                    $this->getGlobalMessageRegistry()->addError($data['text']);
                    break;
                default:
                    $this->getGlobalMessageRegistry()->addNotice($data['text']);
                    break;
            }
        }

        if ($data['area'] === 'local') {
            switch ($data['type']) {
                case 'success':
                    $this->getLocalMessageRegistry()->addSuccess($this->component, $data['text']);
                    break;
                case 'warning':
                    $this->getLocalMessageRegistry()->addWarning($this->component, $data['text']);
                    break;
                case 'error':
                    $this->getLocalMessageRegistry()->addError($this->component, $data['text']);
                    break;
                default:
                    $this->getLocalMessageRegistry()->addNotice($this->component, $data['text']);
                    break;
            }
        }
    }
}
