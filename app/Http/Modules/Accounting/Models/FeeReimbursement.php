<?php

namespace App\Http\Modules\Accounting\Models;

use App\Http\Models\Model;

class FeeReimbursement extends Model
{
    protected $screenId = '/cabinet/payment-v2';

    protected $repositoryNamespace = 'App\Http\Modules\Accounting\Repositories\FeeReimbursementRepository';

    protected $selects = [
        'payment_type_id',
    ];

    public function setPiAttribute($value)
    {
        $this->setAttribute('product_entity_id', $value);
        return $value;
    }

    public function setFiAttribute($value)
    {
        $this->setAttribute('fiscal_year_entity_id', $value);
        return $value;
    }

    public function setAeiAttribute($value)
    {
        $this->setAttribute('account_types_entity_id', $value);
        return $value;
    }

    public function rows()
    {
        if (is_null($this->fi) || is_null($this->pi) || is_null($this->aei)) {
            return [];
        }

        $this->setAttribute('return_type', 'Reimbursement');
        $this->setAttribute('subject_entity_id', 0);
        return $this->repository->getAllReimbursements($this);
    }

    public function updateRows()
    {
        $this->setAttribute('aID_schID_dtID_tAmt_pAmt_rcpNm_rcpDt_list', $this->hidden_amounts);
        return $this->repository->update($this);
    }
}
