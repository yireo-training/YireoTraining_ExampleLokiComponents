<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Component\Notification;

use Loki\Components\Component\ComponentContext;
use Loki\Components\Component\ComponentRepository;
use Loki\Components\Util\Ajax;
use Magento\Framework\Message\Manager as MessageManager;

/**
 * @method ComponentContext getContext()
 */
class NotificationRepository extends ComponentRepository
{
    public function __construct(
        private MessageManager $messageManager,
        private Ajax $ajax
    ) {
    }

    public function getValue(): mixed
    {
        $this->messageManager->addNoticeMessage('Hit the global buttons');

        if (false === $this->ajax->isAjax()) {
            $this->getLocalMessageRegistry()->addNotice('Hit the local buttons');
        }

        return null;
    }

    public function saveValue(mixed $data): void
    {
        $data = (array)$data;
        if (!isset($data['area']) || !isset($data['type']) || !isset($data['text'])) {
            return;
        }

        if ($data['area'] === 'global') {
            switch ($data['type']) {
                case 'success':
                    $this->messageManager->addSuccessMessage($data['text']);
                    break;
                case 'warning':
                    $this->messageManager->addWarningMessage($data['text']);
                    break;
                case 'error':
                    $this->messageManager->addErrorMessage($data['text']);
                    break;
                default:
                    $this->messageManager->addNoticeMessage($data['text']);
                    break;
            }
        }

        if ($data['area'] === 'local') {
            switch ($data['type']) {
                case 'success':
                    $this->getLocalMessageRegistry()->addSuccess($data['text']);
                    break;
                case 'warning':
                    $this->getLocalMessageRegistry()->addWarning($data['text']);
                    break;
                case 'error':
                    $this->getLocalMessageRegistry()->addError($data['text']);
                    break;
                default:
                    $this->getLocalMessageRegistry()->addNotice($data['text']);
                    break;
            }
        }
    }
}
