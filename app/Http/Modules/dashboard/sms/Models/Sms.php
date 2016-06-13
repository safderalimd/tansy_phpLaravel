<?php

namespace App\Http\Modules\dashboard\sms\Models;

use App\Http\Models\Model;

class Sms extends Model
{
    protected $screenId = 2015;

    protected $repositoryNamespace = 'App\Http\Modules\dashboard\sms\Repositories\SmsRepository';

    public $pieDetails;

    public $gridDetails;

    public $smsPieChart;

    public function loadData()
    {
        $details = $this->repository->smsDetails($this);
        $this->pieDetails = first_resultset($details);
        $this->gridDetails = second_resultset($details);

        $this->smsPieChart = array_map(function($item) {
            return [
                'value' => $item['sms_send_count'],
                'label' => $item['sms_type'],
            ];
        }, $this->pieDetails);
    }
}
