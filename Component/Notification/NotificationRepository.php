<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Component\Notification;

use YireoTraining\ExampleLokiComponents\Component\Generic\GenericContext;
use Yireo\LokiComponents\Component\ComponentRepository;

/**
 * @method GenericContext getContext()
 */
class NotificationRepository extends ComponentRepository
{
    protected function getData(): mixed
    {
        echo 'JISSE1';
        $this->getGlobalMessageRegistry()->addNotice('Hit the buttons');

        $this->getLocalMessageRegistry()->addNotice($this->component, 'Hit the buttons');

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