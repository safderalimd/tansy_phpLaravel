<?php

namespace App\Http\Modules\dashboard\sms\Models;

use App\Http\Models\Model;

class Sms extends Model
{
    protected $screenId = 2012;

    protected $repositoryNamespace = 'App\Http\Modules\dashboard\sms\Repositories\SmsRepository';

    public $pieDetails;

    public $gridDetails;

    public $smsPieChart;

    public function loadData()
    {
        $details = $this->repository->smsDetails($this);

        if (isset($details[0])) {
            $this->pieDetails = $details[0];
        }

        if (isset($details[1])) {
            $this->gridDetails = $details[1];
        }

        $this->smsPieChart = array_map(function($item) {
            return [
                'value' => $item['sms_send_count'],
                'label' => $item['sms_type'],
            ];
        }, $this->pieDetails);
    }
}
