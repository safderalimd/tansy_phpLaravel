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
        // get data for the first chart and grid
        $fees = $this->repository->feePayment($this);
        $this->dueDoughnut = first_resultset($fees);
        $this->dueDetails = second_resultset($fees);

        $this->dueDoughnutChart = array_map(function($item) {
            return [
                'value' => $item['due_amount'],
                'label' => $item['product_name'],
            ];
        }, $this->dueDoughnut);

        // get data for the second chart and grid
        $collectionData = $this->repository->collection($this);
        $this->collectionChart = first_resultset($collectionData);
        $this->collectionGrid = second_resultset($collectionData);

        $this->collectionChart = array_map(function($item) {
            return [
                'value' => $item['collection_amount'],
                'label' => $item['product_name'],
            ];
        }, $this->collectionChart);
    }

    public function setCollectionFilter($id)
    {
        if (empty($id)) {
            $this->setAttribute('filter_type', 'Current week');
        } elseif ($id == 1) {
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
