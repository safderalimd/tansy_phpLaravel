<?php

namespace App\Http\Modules\dashboard\sms\Models;

use App\Http\Models\Model;

class DashboardSms extends Model
{
    protected $screenId = '/cabinet/sms-dashboard';

    protected $repositoryNamespace = 'App\Http\Modules\dashboard\sms\Repositories\DashboardSmsRepository';

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
