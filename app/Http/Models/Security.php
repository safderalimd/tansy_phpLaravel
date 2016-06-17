<?php

namespace App\Http\Models;

use App\Http\Models\Model;

class Security extends Model
{
    protected $screenId = null;

    protected $repositoryNamespace = 'App\Http\Repositories\SecurityRepository';

    public function __construct($screenId, $studentEntityId)
    {
        parent::__construct();

        $this->setAttribute('screen_id', $screenId);
        $this->setAttribute('student_entity_id', $studentEntityId);

        return $this->repository->checkPermission($this);
    }

    public function hasScreenPermission()
    {
        if (is_null($this->screen_id)) {
            return false;
        }

        if ($this->valid_access !== 1) {
            return false;
        }

        // if ($this->valid_dashboard !== 0) {
        //     return false;
        // }

        return true;
    }
}
