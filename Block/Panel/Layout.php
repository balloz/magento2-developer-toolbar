<?php

namespace Balloz\DeveloperToolbar\Block\Panel;

use Balloz\DeveloperToolbar\Block\PanelInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Layout as MagentoLayout;

class Layout extends Template implements PanelInterface
{
    protected $entries;

    public function getIdentifier() {
        return 'layout';
    }

    public function getName() {
        return 'Layout';
    }

    protected function buildEntries(MagentoLayout $layout, &$structure, $name = 'root', $alias = '', $level = 0) {
        if (!isset($structure[$name])) {
            return [];
        }

        $instance = $layout->getBlock($name);

        $block = $structure[$name];
        $entries = [];
        $entries[] = [
            'level' => $level,
            'name' => $name,
            'alias' => $alias,
            'type' => $block['type'],
            'label' => isset($block['label']) ? $block['label'] : '',
            'extra' => array_filter([
                'htmlTag' => isset($block['htmlTag']) ? $block['htmlTag'] : '',
                'htmlId' => isset($block['htmlId']) ? $block['htmlId'] : '',
                'htmlClass' => isset($block['htmlClass']) ? $block['htmlClass'] : '',
                'template' => $instance ? $instance->getTemplate() : ''
            ]),
            'queryCount' => $instance ? $instance->getData('__query_count') : 0,
            'queryStartIndex' => $instance ? $instance->getData('__query_index_start') : false,
            'queryEndIndex' => $instance ? $instance->getData('__query_index_end') : false,
            'duration' => $instance ? $instance->getData('__render_time') : 0,
            'cached' => $instance ? $instance->getData('__served_from_cache') : false,
            'cacheLifetime' => $instance && $instance->getData('__cache_lifetime') !== null ? $instance->getData('__cache_lifetime') : false
        ];

        if (isset($block['children'])) {
            foreach ($block['children'] as $child => $alias) {
                $entries = array_merge($entries, $this->buildEntries($layout, $structure, $child, $alias, $level + 1));
            }
        }

        return $entries;
    }

    public function getEntries() {
        if (!$this->entries) {
            $layout = $this->getLayout();

            // TODO: Find a better way to access the layout structure
            $reflection = new \ReflectionClass($layout);
            $structure = $reflection->getProperty('structure');
            $structure->setAccessible(true);
            $structure = $structure->getValue($layout);

            $elements = $structure->exportElements();
            $this->entries = $this->buildEntries($layout, $elements);
        }

        return $this->entries;
    }

    public function formatExtra($extra) {
        $parts = [];

        foreach ($extra as $key => $value) {
            $parts[] = "{$key}: {$value}";
        }

        return implode(', ', $parts);
    }

    public function colorInterval($interval) {
        if ($interval < 5) {
            return 'color-green';
        } elseif ($interval < 10) {
            return 'color-yellow';
        } else {
            return 'color-red';
        }
    }
}