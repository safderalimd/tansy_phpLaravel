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

    public function rows()
    {
        if (is_null($this->fi) || !is_null($this->pi)) {
            $this->setAttribute('return_type', 'Reimbursement');
            $this->setAttribute('filter_type', 'All Students');
            $this->setAttribute('subject_entity_id', 0);
            $this->setAttribute('product_entity_id', $this->pi);
            $this->setAttribute('fiscal_year_entity_id', $this->fi);
            return $this->repository->getAllReimbursements($this);
        }

        return [];
    }

    public function updateRows()
    {
        $this->setAttribute('actEID_schEntID_dateID_totAmnt_PaidAmnt_list', $this->hidden_amounts);
        $this->setAttribute('product_entity_id', $this->pi);
        $this->setAttribute('fiscal_year_entity_id', $this->fi);
        return $this->repository->update($this);
    }
}
