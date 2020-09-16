<?php

namespace Balloz\DeveloperToolbar;

class Console
{
    protected static $console;

    public static function log(...$arguments)
    {
        if (!self::$console) {
            $om = \Magento\Framework\App\ObjectManager::getInstance();
            self::$console = $om->get('Balloz\DeveloperToolbar\Model\Console');
        }

        self::$console->log(...$arguments);
    }
}
