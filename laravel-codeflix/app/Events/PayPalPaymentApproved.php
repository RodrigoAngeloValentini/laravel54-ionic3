<?php

namespace CodeFlix\Events;

use CodeFlix\Models\Plan;
use PayPal\Api\Payment;

class PayPalPaymentApproved
{
    /**
     * @var Plan
     */
    private $plan;

    private $order;
    /**
     * @var Payment
     */
    private $payment;

    public function __construct(Plan $plan, Payment $payment)
    {
        //
        $this->plan = $plan;
        $this->payment = $payment;
    }

    public function getPlan()
    {
        return $this->plan;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    public function getPayment()
    {
        return $this->payment;
    }
}
