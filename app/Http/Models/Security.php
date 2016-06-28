<?php

namespace App\Http\Models;

use App\Http\Models\Model;
use Group;

class Security extends Model
{
    protected $screenId = null;

    protected $repositoryNamespace = 'App\Http\Repositories\SecurityRepository';

    public function __construct($screenId, $studentEntityId, $classStudentId)
    {
        parent::__construct();

        $this->setAttribute('screen_id', $screenId);
        $this->setAttribute('student_entity_id', $studentEntityId);
        $this->setAttribute('class_student_id', $classStudentId);

        // if its a parent group accessing a student dashboard, verify access
        if ($this->parentAccessingDashboard() && ! $this->studentExists()) {
            return false;
        }

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

        // if its a parent group accessing a student dashboard, verify access
        if ($this->parentAccessingDashboard()) {
            if ($this->valid_dashboard !== 1) {
                return false;
            }
        }

        return true;
    }

    public function parentAccessingDashboard()
    {
        return ( !is_null($this->student_entity_id) && Group::isParent() );
    }

    public function studentExists()
    {
        $exists = $this->repository->studentExists($this);
        if (!isset($exists[0])) {
            return false;
        }

        $keys = array_keys($exists[0]);
        if (!isset($keys[0])) {
            return false;
        }

        if ($exists[0][$keys[0]] == 1) {
            return true;
        }

        return false;
    }
}
