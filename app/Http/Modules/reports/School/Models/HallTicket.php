<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;
use App\Http\Models\Traits\OwnerOrganization;

class HallTicket extends Model
{
    protected $screenId = '/cabinet/pdf---hall-ticket';

    protected $repositoryNamespace = 'App\Http\Modules\reports\School\Repositories\HallTicketRepository';

    use OwnerOrganization;

    public $tickets = [];

    public $reportName = 'Hall Ticket';

    public $schoolName = '-';

    public $schoolWorkPhone = '-';

    public $schoolCity = '-';

    public $examFilter = '';

    public $fiscalYear = '';

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
        $this->tickets = $tickets->groupBy('student_entity_id');

        $this->setSchoolInfo();
        $this->setOwnerOrganizationInfo();
    }

    public function setSchoolInfo()
    {
        $this->schoolName = isset($this->school_name) ? $this->school_name : '';
        $this->schoolCity = isset($this->school_city) ? $this->school_city : '';
        $this->schoolWorkPhone = isset($this->school_phone) ? $this->school_phone : '';
        $this->fiscalYear = isset($this->fiscal_year) ? $this->fiscal_year : '';
    }

    public function showImage()
    {
        if (isset($this->show_image_in_hall_ticket) && $this->show_image_in_hall_ticket == 1) {
            return true;
        }

        return false;
    }

    public function hallTicketVersion()
    {
        $version = $this->repository->hallTicketVersion();
        if (isset($version[0]['hall_ticket_version'])) {
            return $version[0]['hall_ticket_version'];
        }
        return null;
    }
}
