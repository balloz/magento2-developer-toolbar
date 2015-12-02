<?php

namespace Balloz\DeveloperToolbar\Model\Plugin;

use Magento\Framework\App\ResourceConnection\ConnectionFactory;

class ProfilerEnabler
{
    public function beforeCreate(ConnectionFactory $factory, array $connectionConfig) {
        $connectionConfig['profiler'] = [
            'enabled' => true
        ];

        return [$connectionConfig];
    }
}
