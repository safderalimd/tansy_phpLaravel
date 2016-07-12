<?php

namespace App\Http\Models;

use App\Http\Models\Model;
use App\Http\Grid\Header;

class Grid extends Model
{
    protected $screenId = 3005;

    protected $repositoryNamespace = 'App\Http\Repositories\GridRepository';

    protected $header;

    protected $rows;

    public function __construct()
    {
        parent::__construct();

        $data = $this->repository->grid($this);
        $this->header = new Header(first_resultset($data));
        $this->settings = second_resultset($data);
        $this->rows = third_resultset($data);
    }

    public function columns()
    {
        return $this->header->columns();
    }

    public function rows()
    {
        return $this->rows;
    }
}
