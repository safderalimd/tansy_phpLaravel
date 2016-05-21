<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;

class StudentExport extends Model
{
    protected $screenId = 3013;

    protected $repositoryNamespace = 'App\Http\Modules\reports\School\Repositories\StudentExportRepository';

    public function pdfData()
    {
        return $this->repository->getPdfData($this->primary_key_id);
    }
}
