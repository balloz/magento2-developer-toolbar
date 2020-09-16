<?php

namespace Balloz\DeveloperToolbar\Block\Panel;

use Balloz\DeveloperToolbar\Block\PanelInterface;
use Balloz\DeveloperToolbar\Model\Console as ConsoleModel;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Layout\Element;

class Console extends Template implements PanelInterface
{
    private $console;

    public function __construct(
        Template\Context $context,
        ConsoleModel $console,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->console = $console;
    }

    public function getIdentifier()
    {
        return 'console';
    }

    public function getName()
    {
        return 'Console';
    }

    public function getEntries()
    {
        return $this->console->getEntries();
    }
}
