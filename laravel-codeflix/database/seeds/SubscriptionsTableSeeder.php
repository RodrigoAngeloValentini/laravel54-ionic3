<?php

use Illuminate\Database\Seeder;

class SubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $plans = app(\CodeFlix\Repositories\PlanRepository::class)->all();
        $orders = app(\CodeFlix\Repositories\OrderRepository::class)->all();
        $repository = app(\CodeFlix\Repositories\SubscriptionRepository::class);

        foreach (range(1, $orders->count()) as $key => $element){
            $repository->create([
                'plan_id' => $plans->random()->id,
                'order_id' => $orders[$key]->id
            ]);
        }
    }
}
