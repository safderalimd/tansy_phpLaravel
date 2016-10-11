<?php

namespace App\Http\Modules\reports\Accounting\Repositories;

use App\Http\Repositories\Repository;
use App\Http\Models\Model;

class AccountStatementRepository extends Repository
{
    public function getStudentById($model)
    {
        $procedure = 'sproc_sch_student_detail';

        $iparams = [
            ':iparam_student_entity_id',
        ];

        $oparams = [];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function getReceiptHeaderByStudent($id)
    {
        $model = new Model;
        $model->setAttribute('paid_by_account_id', $id);

        $procedure = 'sproc_act_rcv_receipt_header';

        $iparams = [
            ':iparam_receipt_id',
            ':iparam_paid_by_account_id',
        ];

        $oparams = [];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }
}
