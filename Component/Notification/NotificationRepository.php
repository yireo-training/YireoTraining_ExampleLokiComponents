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
    public const MAX_TEXT_LENGTH = 255;
    private const AREAS = ['global', 'local'];
    private const TYPES = ['notice', 'success', 'warning', 'error'];

    public function __construct(
        private MessageManager $messageManager,
        private Ajax $ajax
    ) {
    }

    public function getValue(): mixed
    {
        if (false === $this->ajax->isAjax()) {
            $this->messageManager->addNoticeMessage('Hit the global buttons');
            $this->getLocalMessageRegistry()->addNotice('Hit the local buttons');
        }

        return null;
    }

    public function saveValue(mixed $data): void
    {
        $data = (array)$data;
        if (false === $this->isValid($data)) {
            return;
        }

        if ($data['area'] === 'global') {
            switch ($data['type']) {
                case 'success':
                    $this->messageManager->addSuccessMessage($data['text']);
                    break;
                case 'warning':
                    $this->messageManager->addComplexWarningMessage('yireoTrainingExampleLokiComponents');
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

    private function isValid(array $data): bool
    {
        if (false === in_array($data['area'] ?? null, self::AREAS, true)) {
            return false;
        }

        if (false === in_array($data['type'] ?? null, self::TYPES, true)) {
            return false;
        }

        $text = $data['text'] ?? null;

        return is_string($text) && $text !== '' && mb_strlen($text) <= self::MAX_TEXT_LENGTH;
    }
}
