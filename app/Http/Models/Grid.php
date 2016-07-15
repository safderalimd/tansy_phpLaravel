<?php

namespace App\Http\Models;

use App\Http\Models\Model;
use App\Http\Grid\Header;

class Grid extends Model
{
    protected $screenId = null;

    protected $repositoryNamespace = 'App\Http\Repositories\GridRepository';

    protected $header;

    protected $rows;

    public function __construct($screenId)
    {
        $this->screenId = $screenId;
        parent::__construct();
    }

    public function loadData()
    {
        $data = $this->repository->grid($this);
        $this->header = new Header(first_resultset($data));
        $this->rows = second_resultset($data);
        // $this->settings = second_resultset($data);
    }

    public function columns()
    {
        return $this->header->columns();
    }

    public function buttons()
    {
        return $this->header->buttons();
    }

    public function rows()
    {
        return $this->rows;
    }
}
