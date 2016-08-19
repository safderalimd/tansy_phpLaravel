<?php

namespace App\Http\Modules\System\Models;

use App\Http\Models\Model;

class ProgressReportVersion extends Model
{
    protected $screenId = '/cabinet/progress-report-version';

    protected $repositoryNamespace = 'App\Http\Modules\System\Repositories\ProgressReportVersionRepository';

    public function setEeiAttribute($value)
    {
        $this->setAttribute('exam_entity_id', $value);
        return $value;
    }

    public function setRtAttribute($value)
    {
        $this->setAttribute('report_type', $value);
        return $value;
    }

    public function rows()
    {
        if (is_null($this->exam_entity_id) || is_null($this->report_type)) {
            return [];
        }

        return $this->repository->getGrid($this);
    }

    public function examDropdown()
    {
        return $this->repository->examDropdown($this);
    }

    public function reportType()
    {
        return $this->repository->reportType($this);
    }

    public function reportVersion()
    {
        if (is_null($this->report_type)) {
            return [];
        }

        return $this->repository->reportVersion($this);
    }
}
