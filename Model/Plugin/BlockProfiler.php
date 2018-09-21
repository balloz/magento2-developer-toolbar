<?php

namespace Balloz\DeveloperToolbar\Model\Plugin;

use Magento\Framework\App\ResourceConnection\ConnectionFactory;
use Magento\Framework\View\Element\BlockInterface;

class BlockProfiler
{
    /** @var \Magento\Framework\App\ResourceConnection $rc */
    protected $rc;

    public function __construct(\Magento\Framework\App\ResourceConnection $resourceConnection) {
        $this->rc = $resourceConnection;
    }

    public function aroundToHtml(BlockInterface $block, callable $proceed)
    {
        $before = count($this->rc->getConnection()->getProfiler()->getQueryProfiles());
        $start = microtime(true);
        $returnValue = $proceed();
        $end = microtime(true);
        $after = count($this->rc->getConnection()->getProfiler()->getQueryProfiles());
        $block->setData('__query_count', $after - $before);
        $block->setData('__render_time', 1000 * ($end - $start));

        return $returnValue;
    }
}
