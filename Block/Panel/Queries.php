<?php

namespace Balloz\DeveloperToolbar\Block\Panel;

use Balloz\DeveloperToolbar\Block\PanelInterface;
use Magento\Framework\View\Element\Template;

class Queries extends Template implements PanelInterface
{
    protected $rc;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resourceConnection,
        Template\Context $context,
        array $data = []
    ) {
        $this->rc = $resourceConnection;
        parent::__construct($context, $data);
    }

    public function getIdentifier() {
        return 'queries';
    }

    public function getName() {
        return 'Queries';
    }

    public function prettyInterval($interval) {
        if ($interval < 10) {
            $className = 'green';
        } elseif ($interval < 20) {
            $className = 'yellow';
        } else {
            $className = 'red';
        }
        return '<span class="query-interval '.$className.'">'.number_format($interval, 2).'ms</span>';
    }

    public function sumDurations(array $queries) {
        $total = 0;

        foreach ($queries as $query) {
            $total += $query->getElapsedSecs();
        }

        return round($total * 1000);
    }

    public function getQueries() {
        $rc = $this->rc;
        $profiler = $rc->getConnection()->getProfiler();
        return [$rc::DEFAULT_CONNECTION => $profiler->getQueryProfiles()];
    }
}