<?php

namespace App\Http\Modules\Communication\Models;

use App\Http\Models\Model;

class Inbox extends Model
{
    protected $screenId = '/cabinet/inbox';

    protected $repositoryNamespace = 'App\Http\Modules\Communication\Repositories\InboxRepository';

    public function messages()
    {
        $this->setAttribute('page_number', 1);
        return $this->repository->messages($this);
    }

    public function totalMessages()
    {
        if (isset($this->total_rows) && is_numeric($this->total_rows)) {
            return $this->total_rows;
        }

        return 0;
    }

    public function send()
    {
        return $this->repository->sendMessage($this);
    }
}
