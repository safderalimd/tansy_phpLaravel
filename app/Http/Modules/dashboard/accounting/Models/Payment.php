<?php

namespace App\Http\Modules\dashboard\accounting\Models;

use App\Http\Models\Model;

class Payment extends Model
{
    protected $screenId = 2011;

    public $dueDoughnut = [];

    public $dueDetails = [];

    public $dueDoughnutChart;

    public $collectionPie;

    public $collectionGrid;

    protected $repositoryNamespace = 'App\Http\Modules\dashboard\accounting\Repositories\PaymentRepository';

    public function loadData()
    {
        $fees = $this->repository->feePayment($this);

        if (isset($fees[0])) {
            $this->dueDoughnut = $fees[0];
        }

        if (isset($fees[1])) {
            $this->dueDetails = $fees[1];
        }

        $this->dueDoughnutChart = array_map(function($item) {
            return [
                'value' => $item['due_amount'],
                'label' => $item['product_name'],
            ];
        }, $this->dueDoughnut);

        // $this->collectionPie = $this->repository->collection($this);
        // dd($this->collectionPie);
    }

    public function setCollectionFilter($id)
    {
        if ($id == 1) {
            $this->setAttribute('filter_type', 'Current week');
        } elseif ($id == 2) {
            $this->setAttribute('filter_type', 'Current Month');
        } elseif ($id == 3) {
            $this->setAttribute('filter_type', 'Current Quarter');
        } elseif ($id == 4) {
            $this->setAttribute('filter_type', 'Current Fiscal Year');
        }
    }

}
