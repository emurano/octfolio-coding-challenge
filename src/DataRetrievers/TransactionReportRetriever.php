<?php

namespace EricMurano\DataRetrievers;

interface TransactionReportRetriever
{
    public function recordCount(string $searchTerm): int;

    public function findPage(string $searchTerm, PagingConfiguration $pagingConfiguration):array;
}