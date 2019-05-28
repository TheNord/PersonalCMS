<?php

namespace App\ReadModel;

class Pagination
{
    private $totalCount;
    private $page;
    private $perPage;

    public function __construct(int $totalCount, int $page, int $perPage)
    {
        $this->totalCount = $totalCount;
        $this->page = $page;
        $this->perPage = $perPage;
    }

    public function getTotalCount()
    {
        return $this->totalCount;
    }

    public function getPage()
    {
        return $this->page;
    }

    // получаем количество страниц
    public function getPagesCount()
    {
        // делим общее количество постов на количество постов на странице и округляем в большую сторону
        return ceil($this->totalCount / $this->perPage);
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    public function getLimit()
    {
        return $this->perPage;
    }

    public function getOffset()
    {
        return ($this->page - 1) * $this->perPage;
    }
}
