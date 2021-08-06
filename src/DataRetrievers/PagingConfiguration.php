<?php

namespace EricMurano\DataRetrievers;

class PagingConfiguration
{
    private int $page;
    private int $pageSize;

    /**
     * @param int $page
     * @param int $pageSize
     */
    public function __construct(int $page, int $pageSize)
    {
        $this->page = $page;
        $this->pageSize = $pageSize;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }
}