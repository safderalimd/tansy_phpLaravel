<?php

namespace App\Http\Modules\Parent\Models;

trait LazyLoading
{
    protected $messages;

    public function isFirstPage()
    {
        return is_null($this->page);
    }

    public function getStartRowNr()
    {
        return $this->getPageNr() * $this->rowsPerPage() + 1;
    }

    public function getPageNr()
    {
        if (!is_null($this->page) && is_numeric($this->page)) {
            return $this->page;
        }

        return 0;
    }

    public function nextPageNr()
    {
        return $this->getPageNr() + 1;
    }

    public function loadData()
    {
        $this->setAttribute('page_number', $this->getStartRowNr());
        $this->messages = first_resultset($this->repository->messages($this));
    }

    public function messages()
    {
        return $this->messages;
    }

    public function rowsPerPage()
    {
        if (isset($this->r) && is_numeric($this->r)) {
            return $this->r;
        }

        // for first page
        if (isset($this->lazy_load_batch_size) && is_numeric($this->lazy_load_batch_size)) {
            return $this->lazy_load_batch_size;
        }

        return 20;
    }

    public function batchSize()
    {
        if (isset($this->lazy_load_batch_size) && is_numeric($this->lazy_load_batch_size)) {
            return $this->lazy_load_batch_size;
        }

        return 0;
    }
}
