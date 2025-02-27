<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class ExampleListing implements ArgumentInterface
{
    public function __construct(
        private array $links = []
    ) {
    }

    public function getLinks(): array
    {
        return $this->links;
    }
}
