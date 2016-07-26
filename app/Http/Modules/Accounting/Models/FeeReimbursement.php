<?php

namespace App\Http\Modules\Accounting\Models;

use App\Http\Models\Model;

class FeeReimbursement extends Model
{
    protected $screenId = '/cabinet/payment-v2';

    protected $repositoryNamespace = 'App\Http\Modules\Accounting\Repositories\FeeReimbursementRepository';

    public function rows()
    {
        if (!is_null($this->rt) && !is_null($this->ak) || !is_null($this->pi)) {
            $this->setAttribute('return_type', 'Reimbursement');
            $this->setAttribute('filter_type', $this->rt);
            $this->setAttribute('subject_entity_id', $this->ak);
            $this->setAttribute('product_entity_id', $this->pi);
            return $this->repository->getAllReimbursements($this);
        }

        return [];
    }

    public function updateRows()
    {
        $this->setAttribute('actEID_schEntID_dateID_totAmnt_PaidAmnt_list', $this->hidden_amounts);
        $this->setAttribute('product_entity_id', $this->pi);
        return $this->repository->update($this);
    }
}
