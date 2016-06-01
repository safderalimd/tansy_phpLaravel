<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;

class FeeDueReport extends Model
{
    protected $screenId = 3017;

    public $pdfData;

    protected $repositoryNamespace = 'App\Http\Modules\reports\School\Repositories\FeeDueReportRepository';

    public $reportName = 'Fee Due Report';

    public $schoolName = '-';

    public $schoolWorkPhone = '-';

    public $filterCriteria = '-';

    public function setPkAttribute($value)
    {
        $this->setAttribute('subject_entity_id', $value);
        return $value;
    }

    public function setRtAttribute($value)
    {
        $this->setAttribute('filter_type', $value);
        return $value;
    }

    public function loadPdfData()
    {
        $this->setAttribute('return_type', 'ClassPDF');
        $this->pdfData = $this->repository->getAllFees($this);

        $this->setSchoolNameAndPhone();
        $this->setFilterCriteria();
    }

    public function setSchoolNameAndPhone()
    {
        $name = $this->repository->getSchoolName();
        if (isset($name[0]) && isset($name[0]['organization_name'])) {
            $this->schoolName = $name[0]['organization_name'];
        }
        if (isset($name[0]) && isset($name[0]['work_phone'])) {
            $this->schoolWorkPhone = $name[0]['work_phone'];
        }
    }

    public function setFilterCriteria()
    {
        $criteria = $this->repository->getFilterCriteria($this->pk);

        if (isset($criteria[0]) && isset($criteria[0]['drop_down_list_name'])) {
            $this->filterCriteria = $criteria[0]['drop_down_list_name'];
        }
    }
}
