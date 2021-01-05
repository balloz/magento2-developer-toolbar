<?php

namespace Balloz\DeveloperToolbar\Model\Plugin;

use Magento\Framework\App\ResourceConnection\ConnectionFactory;

class ProfilerEnabler
{
    public function beforeCreate(ConnectionFactory $factory, array $connectionConfig) {
        if (php_sapi_name() !== 'cli') {
            $connectionConfig['profiler'] = [
                'enabled' => true
            ];
        }

        return [$connectionConfig];
    }
}
