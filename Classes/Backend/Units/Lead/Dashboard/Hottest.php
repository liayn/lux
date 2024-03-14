<?php

declare(strict_types=1);

namespace In2code\Lux\Backend\Units\Lead\Dashboard;

use In2code\Lux\Backend\Units\AbstractUnit;
use In2code\Lux\Backend\Units\UnitInterface;
use In2code\Lux\Controller\LeadController;
use In2code\Lux\Domain\Repository\VisitorRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Hottest extends AbstractUnit implements UnitInterface
{
    protected string $cacheLayerClass = LeadController::class;
    protected string $cacheLayerFunction = 'dashboardAction';
    protected string $filterClass = 'Lead';
    protected string $filterFunction = 'dashboard';

    protected function assignAdditionalVariables(): array
    {
        if ($this->cacheLayer->isCacheAvailable('Box/Leads/Hottest/' . $this->filter->getHash())) {
            return [];
        }
        $visitorRepository = GeneralUtility::makeInstance(VisitorRepository::class);
        return [
            'hottestVisitors' => $visitorRepository->findByHottestScorings($this->filter->setLimit(10)),
        ];
    }
}
