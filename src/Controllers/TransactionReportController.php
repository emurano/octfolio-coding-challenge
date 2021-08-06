<?php

namespace EricMurano\Controllers;

use EricMurano\Core\Database\DatabaseFactory;
use EricMurano\Core\Http\HttpRequest;
use EricMurano\Core\Http\HttpResponse;
use EricMurano\Core\Http\SiteMetadata;
use EricMurano\DataRetrievers\ExtraQueryTransactionReportRetriever;
use EricMurano\DataRetrievers\GroupConcatTransactionReportRetriever;
use EricMurano\DataRetrievers\PagingConfiguration;
use EricMurano\DataRetrievers\TransactionReportRetriever;

class TransactionReportController
{
    private TransactionReportRetriever $reportRetriever;

    /**
     * @param DatabaseFactory $databaseFactory
     */
    public function __construct(DatabaseFactory $databaseFactory)
    {
        $this->reportRetriever = new ExtraQueryTransactionReportRetriever($databaseFactory);
    }

    public function handleGet(HttpRequest $httpRequest, HttpResponse $httpResponse, SiteMetadata $siteMetadata) : void
    {
        $page = $httpRequest->getVariable('page');
        $page = ((int)$page <= 0) ? 1 : $page;
        $pageSize = $httpRequest->getVariable('pageSize');
        $pageSize = ((int)$pageSize <= 0) ? 10 : $pageSize;
        $searchTerm = $httpRequest->getVariable('searchText') ?? '';

        $totalCount = $this->reportRetriever->recordCount($searchTerm);
        $rowData = $this->reportRetriever->findPage($searchTerm, new PagingConfiguration($page, $pageSize));

        $responseObject = [
            'paging' => [
                'currentPage' => $page,
                'numPages' => $totalCount == 0 ? 0 : floor($totalCount / $pageSize) + 1,
                'numRecords' => $totalCount,
                'pageSize' => $pageSize
            ],
            'records' => []
        ];
        $responseObject['records'] = $rowData;

        $httpResponse
            ->setContentType('application/json')
            ->appendContent(json_encode($responseObject));
    }
}