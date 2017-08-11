<?php

namespace CodeFlix\Http\Controllers\Api;

use CodeFlix\Http\Requests\OrderRequest;
use CodeFlix\Models\Plan;
use CodeFlix\PayPal\PaymentClient;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;
use PayPal\Api\Payment;

class PaymentsController extends Controller
{
    private $paymentClient;

    public function __construct(PaymentClient $paymentClient)
    {
        $this->paymentClient = $paymentClient;
    }

    public function makePayment(Plan $plan)
    {
        $payment = $this->paymentClient->makePayment($plan);
        return [
            'approval_url' => $payment->getApprovalLink(),
            'payment_id' => $payment->getId()
        ];
    }

    public function store(OrderRequest $request, Plan $plan)
    {
        $order = $this->paymentClient->doPayment($plan, $request->get('payment_id'), $request->get('payer_id'));
        return $order;
    }
}
