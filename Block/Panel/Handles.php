<?php

namespace Balloz\DeveloperToolbar\Block\Panel;

use Balloz\DeveloperToolbar\Block\PanelInterface;
use Magento\Framework\View\Element\Template;

class Handles extends Template implements PanelInterface
{
    public function getIdentifier() {
        return 'handles';
    }

    public function getName() {
        return 'Handles';
    }

    public function getLayoutHandles() {
        return $this->getLayout()->getUpdate()->getHandles();
    }
}