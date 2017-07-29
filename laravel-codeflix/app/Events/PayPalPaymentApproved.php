<?php

namespace CodeFlix\Events;

use CodeFlix\Models\Plan;

class PayPalPaymentApproved
{
    /**
     * @var Plan
     */
    private $plan;

    private $order;

    public function __construct(Plan $plan)
    {
        //
        $this->plan = $plan;
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
}
