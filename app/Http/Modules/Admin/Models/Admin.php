<?php

namespace App\Http\Modules\Admin\Models;

use App\Http\Models\Model;

class Admin extends Model
{
    protected $screenId = 1003;

    protected $repositoryNamespace = 'App\Http\Modules\Admin\Repositories\AdminRepository';

    public $dueAmount = 0;

    public function __construct($arguments = [])
    {
        parent::__construct($arguments);

        // call procedure to load oparams to the model
        $this->repository->homeData($this);

        $this->setDueAmount();
    }

    public function setDueAmount()
    {
        $this->setAttribute('filter_type', 'All Students');
        $this->setAttribute('subject_entity_id', 0);
        $this->setAttribute('return_type', 'Dashboard');
        $dueList = $this->repository->dueList($this);

        $dueAmount = first_resultset($dueList);
        if (isset($dueAmount[0]['due_amount'])) {
            $this->dueAmount = $dueAmount[0]['due_amount'];
        }
    }
}
