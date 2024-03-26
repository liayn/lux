<?php

declare(strict_types=1);

namespace In2code\Lux\Update\AddSites;

use In2code\Lux\Domain\Model\Linkclick;
use In2code\Lux\Utility\DatabaseUtility;

class AddSitesForLinkclick extends AbstractSiteUpgrade
{
    public function run(): void
    {
        $connection = DatabaseUtility::getConnectionForTable(Linkclick::TABLE_NAME);
        $records = $connection
            ->executeQuery('select * from ' . Linkclick::TABLE_NAME . ' where deleted=0')
            ->fetchAllAssociative();
        foreach ($records as $record) {
            $siteIdentifier = $this->getSiteIdentifierFromPage($record['page']);
            $connection->executeQuery(
                'update ' . Linkclick::TABLE_NAME . ' set site = "' . $siteIdentifier . '" where uid=' . $record['uid']
            );
        }
    }
}
