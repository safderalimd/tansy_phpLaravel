<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;
use App\Http\Models\Traits\OwnerOrganization;

class FeeDueReport extends Model
{
    protected $screenId = '/cabinet/pdf---due-report';

    protected $repositoryNamespace = 'App\Http\Modules\reports\School\Repositories\FeeDueReportRepository';

    use OwnerOrganization;

    public $pdfData;

    public $reportName = 'Fee Due Report';

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

        $this->setOwnerOrganizationInfo();
        $this->setFilterCriteria();
    }

    public function setFilterCriteria()
    {
        $this->setAttribute('primary_key_id', $this->pk);
        $criteria = $this->repository->getFilterCriteria($this);

        if (isset($criteria[0]) && isset($criteria[0]['drop_down_list_name'])) {
            $this->filterCriteria = $criteria[0]['drop_down_list_name'];
        }
    }
}
