<?php

namespace App\Http\Modules\reports\Accounting\Repositories;

use App\Http\Repositories\Repository;
use App\Http\Models\Model;

class ReceiptPrintRepository extends Repository
{
    public function receipt($model)
    {
        $procedure = 'sproc_act_rcv_pdf_receipt';

        $iparams = [
            ':iparam_receipt_id',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function receiptsGrid($model)
    {
        $procedure = 'sproc_act_rcv_receipt_grid';

        $iparams = [
            ':iparam_account_entity_id',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_receipt_version',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function getReceiptHeader($id)
    {
        $model = new Model;
        $model->setAttribute('receipt_id', $id);

        $procedure = 'sproc_act_rcv_receipt_header';

        $iparams = [
            ':iparam_receipt_id',
            ':iparam_paid_by_account_id',
        ];

        $oparams = [];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function getReceiptDetail($id)
    {
        $model = new Model;
        $model->setAttribute('receipt_id', $id);

        $procedure = 'sproc_act_rcv_receipt_detail';

        $iparams = [
            ':iparam_receipt_id',
        ];

        $oparams = [];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }
}
