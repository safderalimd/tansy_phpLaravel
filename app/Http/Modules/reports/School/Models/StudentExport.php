<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;

class StudentExport extends Model
{
    protected $screenId = 3013;

    public $pdfData;

    protected $repositoryNamespace = 'App\Http\Modules\reports\School\Repositories\StudentExportRepository';

    public function setPkAttribute($value)
    {
        $this->setAttribute('primary_key_id', $value);
        return $value;
    }

    public function setRtAttribute($value)
    {
        $this->setAttribute('row_type', $value);
        return $value;
    }

    public function loadPdfData()
    {
        switch ($this->row_type) {
            case 'All Clasess':
                $this->pdfData = $this->repository->getPdfData();
                break;
            case 'Class':
                $this->pdfData = $this->repository->getPdfData('class_entity_id', $this->pk);
                break;
            case 'ClassCategory':
                $this->pdfData = $this->repository->getPdfData('class_category_entity_id', $this->pk);
                break;
            case 'ClassGroup':
                $this->pdfData = $this->repository->getPdfData('class_group_entity_id', $this->pk);
                break;
            default:
                throw new \Exception("Invalid row type.");
                break;
        }
    }
}
