<?php

namespace App\Http\Modules\reports\School\Repositories;

use App\Http\Repositories\Repository;

class DailyCollectionRepository extends Repository
{
    public function getPdfData($startDate, $endDate)
    {
        return $this->select(
            'SELECT
                calendar_date,
                receipt_collection_amount,
                cash_counter_amount,
                closed_datetime,
                closed_by,
                date_id
             FROM view_act_rcv_daily_collection
             WHERE calendar_date BETWEEN :start_date AND :end_date;',
             ['start_date' => $startDate, 'end_date' => $endDate]
        );
    }

    // Todo: filter this select
    public function getSchoolName()
    {
        return $this->select(
            'SELECT
                organization_name,
                work_phone,
                mobile_phone,
                email,
                address1,
                address2,
                city_area,
                postal_code,
                city_id,
                organization_type_id,
                organization_entity_id
            FROM view_org_organization_detail_owner
            LIMIT 1;'
        );
    }
}
