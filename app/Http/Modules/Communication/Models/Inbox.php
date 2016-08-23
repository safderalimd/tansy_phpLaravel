<?php

namespace App\Http\Modules\Communication\Models;

use App\Http\Models\Model;

class Inbox extends Model
{
    protected $screenId = '/cabinet/inbox';

    protected $repositoryNamespace = 'App\Http\Modules\Communication\Repositories\InboxRepository';

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

    public function setQAttribute($value)
    {
        $this->setAttribute('search_text', $value);
        return $value;
    }

    public function loadData()
    {
        $this->setAttribute('start_row_number', $this->getStartRowNr());
        $this->messages = $this->repository->messages($this);
    }

    public function messages()
    {
        return $this->messages;
    }

    public function showSearch()
    {
        return true;

        if (isset($this->show_lazy_load_search) && $this->show_lazy_load_search == 1) {
            return true;
        }

        return false;
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

    public function searchQuery()
    {
        if (isset($this->q) && is_string($this->q)) {
            return $this->q;
        }
        return '';
    }

    public function send()
    {
        return $this->repository->sendMessage($this);
    }

    public function contacts()
    {
        return $this->repository->contacts($this);
    }

    public function deleteMessage()
    {
        return $this->repository->deleteMessage($this);
    }

    public function messageDetail()
    {
        $this->setAttribute('email_id', $this->id);
        $message = $this->repository->messageDetail($this);
        if (isset($message[0])) {
            return $message[0];
        }

        return [];
    }
}
