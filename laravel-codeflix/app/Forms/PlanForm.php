<?php

namespace CodeFlix;

use CodeFlix\Models\Plan;
use Kris\LaravelFormBuilder\Form;

class PlanForm extends Form
{
    public function buildForm()
    {
        $durations = [
            Plan::DURATION_MONTHLY => 'Mensalmente',
            Plan::DURATION_YEARLY => 'Anualmente'
        ];

        $this
            ->add('duration', 'select', [
                'choices' => $durations,
                'rules' => "required|in:" . implode(',', array_keys($durations))
            ])
            ->add('name', 'text', [
                'rules' => "required|max:255"
            ])
            ->add('description', 'text', [
                'rules' => "required|max:255"
            ])
            ->add('value', 'text', [
                'rules' => "required|numeric"
            ]);
    }
}
