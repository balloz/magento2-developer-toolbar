<?php

namespace Balloz\DeveloperToolbar\Block;

use Balloz\DeveloperToolbar\Block\PanelInterface;

class Toolbar extends \Magento\Framework\View\Element\Template
{
    protected $panels;

    public function getPanels() {
        if (!$this->panels) {
            $panels = array();
            $layout = $this->getLayout();

            foreach ($this->getChildNames() as $child) {
                $block = $this->getChildBlock($child);

                if (!$block instanceof PanelInterface) {
                    continue;
                }

                $panels[] = $block;
            }

            $this->panels = $panels;
        }

        return $this->panels;
    }
}