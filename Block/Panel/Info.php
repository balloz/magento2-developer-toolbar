<?php

namespace Balloz\DeveloperToolbar\Block\Panel;

use Balloz\DeveloperToolbar\Block\PanelInterface;
use Magento\Framework\View\Element\Template;

class Info extends Template implements PanelInterface
{
    protected $storeManager;

    public function __construct(
        \Magento\Store\Model\StoreManager $storeManager,
        Template\Context $context,
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    public function getIdentifier() {
        return 'info';
    }

    public function getName() {
        return 'Info';
    }

    public function getInfo() {
        return [
            'Website code' => $this->storeManager->getWebsite()->getCode(),
            'Store code' => $this->storeManager->getStore()->getCode(),
            'Max. memory used (so far)' => number_format(memory_get_peak_usage() / 1024, 2).'kb',
            'Number of classes loaded' => count(get_declared_classes()),
            'Number of interfaces loaded' => count(get_declared_interfaces())
        ];
    }
}
