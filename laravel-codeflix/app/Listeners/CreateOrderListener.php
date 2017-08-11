<?php

namespace CodeFlix\Listeners;

use CodeFlix\Events\PayPalPaymentApproved;
use CodeFlix\Repositories\OrderRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateOrderListener
{
    /**
     * @var OrderRepository
     */
    private $repository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(OrderRepository $repository)
    {
        //
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  PayPalPaymentApproved  $event
     * @return void
     */
    public function handle(PayPalPaymentApproved $event)
    {
        $plan = $event->getPlan();
        $order = $this->repository->create([
           'user_id' => \Auth::guard('api')->user()->id,
            'value' => $plan->value,
            'code' => $event->getPayment()->getId()
        ]);
        $event->setOrder($order);
    }
}
