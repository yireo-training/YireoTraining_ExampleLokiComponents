<?php
declare(strict_types=1);

namespace YireoTraining\ExampleLokiComponents\Test\Integration\Controller\Example;

use Magento\Framework\View\LayoutInterface;
use Magento\TestFramework\TestCase\AbstractController;

class IndexTest extends AbstractController
{
    /**
     * @magentoAppArea frontend
     * @magentoConfigFixture current_store loki_example_components/general/enabled 0
     */
    public function testNotFoundWhenDisabled()
    {
        $this->dispatch('loki_components_example/example/index');
        $this->assert404NotFound();
    }

    /**
     * @magentoAppArea frontend
     * @magentoConfigFixture current_store loki_example_components/general/enabled 0
     */
    public function testChildControllerNotFoundWhenDisabled()
    {
        $this->dispatch('loki_components_example/example/comments');
        $this->assert404NotFound();
    }

    /**
     * @magentoAppArea frontend
     * @magentoConfigFixture current_store loki_example_components/general/enabled 1
     */
    public function testPageWhenEnabled()
    {
        $this->dispatch('loki_components_example/example/index');
        $this->assertSame(200, $this->getResponse()->getHttpResponseCode());
        $this->assertStringContainsString('Yireo Loki Components Examples', (string)$this->getResponse()->getBody());
    }

    /**
     * @magentoAppArea frontend
     * @magentoConfigFixture current_store loki_example_components/general/enabled 0
     */
    public function testFooterBlockMissingWhenDisabled()
    {
        $this->dispatch('customer/account/login');
        $layout = $this->_objectManager->get(LayoutInterface::class);
        $this->assertFalse($layout->getBlock('loki-component-example.overview.footer'));
    }

    /**
     * @magentoAppArea frontend
     * @magentoConfigFixture current_store loki_example_components/general/enabled 1
     */
    public function testFooterBlockPresentWhenEnabled()
    {
        $this->dispatch('customer/account/login');
        $layout = $this->_objectManager->get(LayoutInterface::class);
        $this->assertNotFalse($layout->getBlock('loki-component-example.overview.footer'));
    }
}
