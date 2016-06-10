<?php

namespace App\Http\Modules\reports\Accounting\Repositories;

use App\Http\Repositories\Repository;

class ReceiptPrintRepository extends Repository
{
    public function getReceiptGrid($id)
    {
        return $this->select(
            'SELECT
                receipt_id,
                receipt_number,
                receipt_date,
                receipt_amount,
                new_balance,
                account_name,
                mobile_phone,
                account_entity_id
            FROM view_act_rcv_receipt_grid
            WHERE account_entity_id = :id
            ORDER BY account_name ASC;', ['id' => $id]
        );
    }

    public function getReceiptHeader($id)
    {
        return $this->select(
            'SELECT
                receipt_id,
                receipt_number,
                receipt_date,
                receipt_amount,
                new_balance,
                paid_by_name,
                financial_year_balance,
                mobile_phone
            FROM view_act_rcv_receipt_header
            WHERE receipt_id = :id;', ['id' => $id]
        );
    }

    public function getReceiptDetail($id)
    {
        return $this->select(
            'SELECT
                receipt_id,
                credit_amount,
                description
            FROM view_act_rcv_receipt_detail
            WHERE receipt_id = :id;', ['id' => $id]
        );
    }

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
