<?php

declare(strict_types = 1);

namespace In2code\Lux\Domain\Cache;

use In2code\Lux\Domain\Repository\CategoryRepository;
use In2code\Lux\Domain\Repository\DownloadRepository;
use In2code\Lux\Domain\Repository\FingerprintRepository;
use In2code\Lux\Domain\Repository\IpinformationRepository;
use In2code\Lux\Domain\Repository\LinkclickRepository;
use In2code\Lux\Domain\Repository\LinklistenerRepository;
use In2code\Lux\Domain\Repository\LogRepository;
use In2code\Lux\Domain\Repository\NewsRepository;
use In2code\Lux\Domain\Repository\NewsvisitRepository;
use In2code\Lux\Domain\Repository\PageRepository;
use In2code\Lux\Domain\Repository\PagevisitRepository;
use In2code\Lux\Domain\Repository\SearchRepository;
use In2code\Lux\Domain\Repository\VisitorRepository;
use In2code\Lux\Exception\ConfigurationException;
use In2code\Lux\Exception\UnexpectedValueException;
use In2code\Lux\Utility\CacheLayerUtility;

/**
 * AbstractLayer
 */
abstract class AbstractLayer
{
    /**
     * @var string
     */
    protected $cacheName = '';

    /**
     * @var string
     */
    protected $identifier = '';

    /**
     * @var VisitorRepository
     */
    protected $visitorRepository = null;

    /**
     * @var IpinformationRepository
     */
    protected $ipinformationRepository = null;

    /**
     * @var LogRepository
     */
    protected $logRepository = null;

    /**
     * @var PagevisitRepository
     */
    protected $pagevisitsRepository = null;

    /**
     * @var PageRepository
     */
    protected $pageRepository = null;

    /**
     * @var DownloadRepository
     */
    protected $downloadRepository = null;

    /**
     * @var NewsvisitRepository
     */
    protected $newsvisitRepository = null;

    /**
     * @var NewsRepository
     */
    protected $newsRepository = null;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository = null;

    /**
     * @var LinkclickRepository
     */
    protected $linkclickRepository = null;

    /**
     * @var LinklistenerRepository
     */
    protected $linklistenerRepository = null;

    /**
     * @var FingerprintRepository
     */
    protected $fingerprintRepository = null;

    /**
     * @var SearchRepository
     */
    protected $searchRepository = null;

    /**
     * @param VisitorRepository $visitorRepository
     * @param IpinformationRepository $ipinformationRepository
     * @param LogRepository $logRepository
     * @param PagevisitRepository $pagevisitsRepository
     * @param PageRepository $pageRepository
     * @param DownloadRepository $downloadRepository
     * @param NewsvisitRepository $newsvisitRepository
     * @param NewsRepository $newsRepository
     * @param CategoryRepository $categoryRepository
     * @param LinkclickRepository $linkclickRepository
     * @param LinklistenerRepository $linklistenerRepository
     * @param FingerprintRepository $fingerprintRepository
     * @param SearchRepository $searchRepository
     */
    public function __construct(
        VisitorRepository $visitorRepository,
        IpinformationRepository $ipinformationRepository,
        LogRepository $logRepository,
        PagevisitRepository $pagevisitsRepository,
        PageRepository $pageRepository,
        DownloadRepository $downloadRepository,
        NewsvisitRepository $newsvisitRepository,
        NewsRepository $newsRepository,
        CategoryRepository $categoryRepository,
        LinkclickRepository $linkclickRepository,
        LinklistenerRepository $linklistenerRepository,
        FingerprintRepository $fingerprintRepository,
        SearchRepository $searchRepository
    ) {
        $this->visitorRepository = $visitorRepository;
        $this->ipinformationRepository = $ipinformationRepository;
        $this->logRepository = $logRepository;
        $this->pagevisitsRepository = $pagevisitsRepository;
        $this->pageRepository = $pageRepository;
        $this->downloadRepository = $downloadRepository;
        $this->newsvisitRepository = $newsvisitRepository;
        $this->newsRepository = $newsRepository;
        $this->categoryRepository = $categoryRepository;
        $this->linkclickRepository = $linkclickRepository;
        $this->linklistenerRepository = $linklistenerRepository;
        $this->fingerprintRepository = $fingerprintRepository;
        $this->searchRepository = $searchRepository;
    }

    /**
     * @return array
     */
    public function getAllArguments(): array
    {
        return array_merge($this->getCachableArguments(), $this->getUncachableArguments());
    }

    /**
     * @param string $cacheName
     * @param string $identifier
     * @return void
     */
    public function initialize(string $cacheName, string $identifier): void
    {
        $this->cacheName = $cacheName;
        $this->identifier = $identifier;
    }

    /**
     * @return int
     * @throws ConfigurationException
     * @throws UnexpectedValueException
     */
    public function getCacheLifetime(): int
    {
        if ($this->cacheName === '') {
            throw new ConfigurationException('CacheName must not be empty', 1636364317);
        }
        return CacheLayerUtility::getCachelayerLifetimeByCacheName($this->cacheName);
    }
}
