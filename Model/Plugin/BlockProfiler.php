<?php

namespace Balloz\DeveloperToolbar\Model\Plugin;

use Magento\Framework\App\ResourceConnection\ConnectionFactory;
use Magento\Framework\View\Element\BlockInterface;

class BlockProfiler
{
    /** @var \Magento\Framework\App\ResourceConnection */
    protected $rc;

    /** @var \Magento\Framework\App\CacheInterface */
    protected $cache;

    /** @var \Magento\Framework\App\Cache\StateInterface */
    protected $cacheState;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resourceConnection,
        \Magento\Framework\View\Element\Context $context
    ) {
        $this->rc = $resourceConnection;
        $this->cache = $context->getCache();
        $this->cacheState = $context->getCacheState();
    }

    public function aroundToHtml(BlockInterface $block, callable $proceed)
    {
        $before = count($this->rc->getConnection()->getProfiler()->getQueryProfiles());

        $start = microtime(true);
        $returnValue = $proceed();
        $end = microtime(true);
        $after = count($this->rc->getConnection()->getProfiler()->getQueryProfiles());

        // TODO: Find a better way to access the layout structure
        $reflection = new \ReflectionClass($block);
        $clMethod = $reflection->getMethod('getCacheLifetime');
        $clMethod->setAccessible(true);
        $cacheLifetime = $clMethod->invoke($block);

        $queryCount = $after - $before;
        $renderTime = 1000 * ($end - $start);
        $servedFromCache = (bool)$this->cache->load($block->getCacheKey());
        $block->setData('__query_count', $queryCount);
        $block->setData('__render_time', $renderTime);
        $block->setData('__served_from_cache', $servedFromCache);
        $block->setData('__cache_lifetime', $cacheLifetime);
        $block->setData('__query_index_start', $before);
        $block->setData('__query_index_end', $after);

        return $returnValue;
    }
}
