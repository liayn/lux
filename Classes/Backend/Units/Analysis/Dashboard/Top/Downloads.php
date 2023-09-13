<?php

declare(strict_types=1);

namespace In2code\Lux\Backend\Units\Analysis\Dashboard\Top;

use In2code\Lux\Backend\Units\AbstractUnit;
use In2code\Lux\Backend\Units\UnitInterface;
use In2code\Lux\Controller\AnalysisController;
use In2code\Lux\Domain\Repository\DownloadRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Downloads extends AbstractUnit implements UnitInterface
{
    protected string $cacheLayerClass = AnalysisController::class;
    protected string $cacheLayerFunction = 'dashboardAction';
    protected string $filterClass = 'Analysis';
    protected string $filterFunction = 'dashboard';

    protected function assignAdditionalVariables(): array
    {
        $downloadRepository = GeneralUtility::makeInstance(DownloadRepository::class);
        return [
            'downloads' => $downloadRepository->findCombinedByHref($this->filter),
        ];
    }
}
