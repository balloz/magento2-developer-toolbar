<?php

namespace Balloz\DeveloperToolbar\Block\Panel;

use Balloz\DeveloperToolbar\Block\PanelInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Layout\Element;

class Fpc extends Template implements PanelInterface
{
    public function getIdentifier() {
        return 'fpc';
    }

    public function getName() {
        return 'FPC';
    }

    public function getUncacheables() {
        $layout = $this->getLayout();

        // TODO: Find a better way to access the layout structure
        $reflection = new \ReflectionClass($layout);
        $xmlProperty = $reflection->getProperty('_xml');
        $xmlProperty->setAccessible(true);
        $xml = $xmlProperty->getValue($layout);

        return $xml->xpath('//' . Element::TYPE_BLOCK . '[@cacheable="false"]');
    }

    public function isFpcCacheable() {
        return $this->getLayout()->isCacheable();
    }

    public function getLayoutHandles() {
        return $this->getLayout()->getUpdate()->getHandles();
    }
}