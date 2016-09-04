<?php

namespace App\Http\Modules\Communication\Models;

use App\Http\Models\Model;
use App\Http\Modules\Parent\Models\LazyLoading;

class SendMail extends Model
{
    use LazyLoading;

    protected $screenId = '/cabinet/send-mail';

    protected $repositoryNamespace = 'App\Http\Modules\Communication\Repositories\SendMailRepository';

    public function setQAttribute($value)
    {
        $this->setAttribute('search_text', $value);
        return $value;
    }

    public function showSearch()
    {
        if (isset($this->show_lazy_load_search) && $this->show_lazy_load_search == 1) {
            return true;
        }

        return false;
    }

    public function searchQuery()
    {
        if (isset($this->q) && is_string($this->q)) {
            return $this->q;
        }
        return '';
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
