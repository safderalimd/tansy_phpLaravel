<?php

namespace App\Http\Modules\Accounting\Models;

use App\Http\Models\Model;

class Payment extends Model
{
    protected $screenId = 2010;

    protected $repositoryNamespace = 'App\Http\Modules\Accounting\Repositories\PaymentRepository';

    protected $rows = [];

    public $totalDue = 0;

    public function getAllPayments()
    {
        return $this->repository->getAllPayments($this);
    }

    // show payment grid
    public static function summary($rowType, $primaryKey)
    {
        $payment = new static;

        if (!empty($rowType) && !empty($primaryKey)) {
            $payment->setAttribute('return_type', 'Summary');
            $payment->setAttribute('filter_type', 'entity'); // or $rowType
            $payment->setAttribute('subject_entity_id', $primaryKey);
            $rows = $payment->repository->getAllPayments($payment);
            $payment->setRows($rows);
        }

        return $payment;
    }

    // show payment form
    public static function details($primaryKey)
    {
        $payment = new static;

        if (!empty($primaryKey)) {
            $payment->setAttribute('return_type', 'Detail');
            $payment->setAttribute('filter_type', 'entity'); // or $rowType
            $payment->setAttribute('subject_entity_id', $primaryKey);
            $rows = $payment->repository->getAllPayments($payment);

            usort($rows, function($a, $b) {
                if ($a['product_name'] == $b['product_name']) {
                    if ($a['schedule_name'] == $b['schedule_name']) {
                        return strtotime($a['due_start_date']) > strtotime($b['due_start_date']);
                    }
                    return strcmp($a['schedule_name'], $b['schedule_name']);
                }
                return strcmp($a['product_name'], $b['product_name']);

                // original sort
                // return strtotime($a['due_end_date']) > strtotime($b['due_end_date']);
            });

            // calculate total due
            foreach ($rows as $row) {
                $payment->totalDue += floatval($row['due_amount']);
            }

            $payment->setRows($rows);
        }

        return $payment;
    }

    public function rows()
    {
        return $this->rows;
    }

    public function setRows($rows)
    {
        $this->rows = $rows;
    }

    public function payNow()
    {
        return $this->repository->payNow($this);
    }
}
