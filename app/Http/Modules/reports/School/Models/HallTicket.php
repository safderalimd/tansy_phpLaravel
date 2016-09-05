<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;

class HallTicket extends Model
{
    protected $screenId = '/cabinet/pdf---hall-ticket';

    protected $repositoryNamespace = 'App\Http\Modules\reports\School\Repositories\HallTicketRepository';

    public $tickets = [];

    public $reportName = 'Hall Ticket';

    public $schoolName = '-';

    public $schoolWorkPhone = '-';

    public $examFilter = '';

    public function setAeiAttribute($value)
    {
        $this->setAttribute('filter_entity_id', $value);
        return $value;
    }

    public function setEidAttribute($value)
    {
        $this->setAttribute('exam_entity_id', $value);
        return $value;
    }

    public function loadPdfData()
    {
        $tickets = $this->repository->tickets($this);
        $tickets = collect($tickets);
        $this->tickets = $tickets->groupBy('account_entity_id');

        // $this->setExamFilter();
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

    public function setExamFilter()
    {
        foreach ($this->mainExam() as $option) {
            if ($option['exam_entity_id'] == $this->exam_entity_id) {
                $this->examFilter = $option['exam'];
                break;
            }
        }
    }

    public function showImage()
    {
        if (isset($this->show_image_in_hall_ticket) && $this->show_image_in_hall_ticket == 1) {
            return true;
        }

        return false;
    }
}
