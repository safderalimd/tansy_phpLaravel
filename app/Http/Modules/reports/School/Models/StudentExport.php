<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;

class StudentExport extends Model
{
    protected $screenId = 3013;

    public $pdfData;
    // public $schoolName = 'School Name';

    protected $repositoryNamespace = 'App\Http\Modules\reports\School\Repositories\StudentExportRepository';

    public function setPkAttribute($value)
    {
        $this->setAttribute('primary_key_id', $value);
        return $value;
    }

    public function loadPdfData()
    {
        $this->pdfData = $this->repository->getPdfData($this->primary_key_id);

        // if (count($this->pdfData)) {
            // $this->schoolName = $this->pdfData[0]['school_name'];
        // }
    }
}
