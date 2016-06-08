<?php

namespace App\Http\Modules\Accounting\Models;

use App\Http\Models\Model;

class Payment extends Model
{
    protected $screenId = 2013;

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
            $payment->setAttribute('filter_type', $rowType);
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
            $payment->setAttribute('filter_type', 'Individual');
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

    public function shouldSendReceiptSms()
    {
        $sendSms = $this->repository->getCheckboxDefaultValue();

        if (!isset($sendSms[0]['send_payment_sms'])) {
            return false;
        }

        return (bool) $sendSms[0]['send_payment_sms'];
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
        $payment = static::details($this->pk);
        $rows = $payment->rows();

        // todo: ask client what php validations to be made for payment

        $this->repository->payNow($this);

        // send receipt sms if checkbox is on
        if (isset($this->send_receipt_sms)) {
            $phone = null;
            if (isset($rows[0]['mobile_phone'])) {
                $phone = $rows[0]['mobile_phone'];
            }
            if (!empty($phone)) {
                // send an sms with the receipt
            }
        }
    }
}
