<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;

class DailyCollection extends Model
{
    protected $screenId = '/cabinet/pdf---daily-collection';

    public $pdfData = [];

    protected $repositoryNamespace = 'App\Http\Modules\reports\School\Repositories\DailyCollectionRepository';

    public $reportName = 'Daily Collection';

    public $schoolName = '-';

    public $schoolWorkPhone = '-';

    public function loadPdfData()
    {
        $this->pdfData = $this->repository->getPdfData($this->start, $this->end);

        $this->setSchoolNameAndPhone();
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
}
