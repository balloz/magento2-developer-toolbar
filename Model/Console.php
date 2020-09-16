<?php

namespace Balloz\DeveloperToolbar\Model;

use Magento\Framework\Debug;

class Console
{
    protected $entries = [];

    public function log(...$arguments)
    {
        foreach ($arguments as $arg) {
            if (is_array($arg)) {
                $this->entries[] = print_r($arg, true);
            } elseif (is_object($arg)) {
                if (method_exists($arg, '__toString')) {
                    $this->entries[] = "Object of type " . get_class($arg) . ': ' . $arg;
                } else {
                    $this->entries[] = "Object of type " . get_class($arg);
                }
            } else {
                $this->entries[] = $arg;
            }
        }
    }

    public function getEntries()
    {
        return $this->entries;
    }
}
