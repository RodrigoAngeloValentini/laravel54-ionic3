<?php
/**
 * Created by PhpStorm.
 * User: rodrigoangelo
 * Date: 27/07/17
 * Time: 21:36
 */

namespace CodeFlix\PayPal;


use CodeFlix\Events\PayPalPaymentApproved;
use CodeFlix\Models\Plan;

class PaymentClient
{
    public function doPayment(Plan $plan){

        $event = new PayPalPaymentApproved($plan);
        event($event);
        return $event->getOrder();
    }
}