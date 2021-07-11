<?php
declare(strict_types = 1);
namespace In2code\Lux\Domain\DataProvider;

use In2code\Lux\Domain\Repository\NewsvisitRepository;
use In2code\Lux\Utility\LocalizationUtility;
use In2code\Lux\Utility\ObjectUtility;
use TYPO3\CMS\Extbase\Object\Exception;

/**
 * Class LanguagesNewsDataProvider
 */
class LanguagesNewsDataProvider extends AbstractDataProvider
{
    /**
     * Set values like:
     *  [
     *      'amounts' => [
     *          123,
     *          50,
     *          12
     *      ],
     *      'titles' => [
     *          'Page visits "German"',
     *          'Page visits "English"',
     *          'Page visits "Japanese"'
     *      ]
     *  ]
     *
     * @return void
     * @throws Exception
     */
    public function prepareData(): void
    {
        $languages = $this->getLanguagesFromSystem();
        foreach ($languages as $language) {
            $this->data['amounts'][] = $language['count'];
            $this->data['titles'][] = $language['label'];
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    protected function getLanguagesFromSystem(): array
    {
        /** @var NewsvisitRepository $newsvisitRepository */
        $newsvisitRepository = ObjectUtility::getObjectManager()->get(NewsvisitRepository::class);
        $rows = $newsvisitRepository->getAllLanguages($this->filter);

        foreach ($rows as &$row) {
            $row['label'] = $row['title'] ?: 'Standard';
            $row['label'] = LocalizationUtility::translateByKey('dataprovider.languages.label', [$row['label']]);
        }
        return $rows;
    }
}
