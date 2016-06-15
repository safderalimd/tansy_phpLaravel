<?php

namespace App\Http\Modules\dashboard\accounting\Models;

use App\Http\Models\Model;

class Payment extends Model
{
    protected $screenId = 2014;

    public $dueDoughnutDetails = [];

    public $dueDoughnutChart;

    public $collectionPie;

    public $collectionGrid;

    public $dueAmount = 0;

    protected $repositoryNamespace = 'App\Http\Modules\dashboard\accounting\Repositories\PaymentRepository';

    public function loadData()
    {
        $model = new static;
        $model->setAttribute('filter_type', 'All Students');
        $model->setAttribute('subject_entity_id', 0);
        $model->setAttribute('return_type', 'Dashboard');
        $dueList = $model->repository->dueList($model);

        $dueAmount = first_resultset($dueList);
        if (isset($dueAmount[0]['due_amount'])) {
            $this->dueAmount = $dueAmount[0]['due_amount'];
        }

        // get data for the first chart and grid
        $dueDoughnut = second_resultset($dueList);
        $this->dueDoughnutDetails = third_resultset($dueList);

        $this->dueDoughnutChart = array_map(function($item) {
            return [
                'value' => $item['due_amount'],
                'label' => $item['product_name'],
            ];
        }, $dueDoughnut);

        // call this sproc to set output parameters
        $this->repository->feePayment($this);

        // $this->dueDoughnut = first_resultset($fees);
        // $this->dueDoughnutDetails = second_resultset($fees);

        // $this->dueDoughnutChart = array_map(function($item) {
        //     return [
        //         'value' => $item['due_amount'],
        //         'label' => $item['product_name'],
        //     ];
        // }, $this->dueDoughnut);

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
            $this->setAttribute('filter_type', 'Today');
        } elseif ($id == 1) {
            $this->setAttribute('filter_type', 'Current week');
        } elseif ($id == 2) {
            $this->setAttribute('filter_type', 'Current Month');
        } elseif ($id == 3) {
            $this->setAttribute('filter_type', 'Current Quarter');
        } elseif ($id == 4) {
            $this->setAttribute('filter_type', 'Current Fiscal Year');
        } elseif ($id == 5) {
            $this->setAttribute('filter_type', 'Today');
        }
    }

}
