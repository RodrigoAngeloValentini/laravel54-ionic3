<?php

namespace CodeFlix;

use Kris\LaravelFormBuilder\Form;

class PayPalProfileForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => 'Nome',
                'rules' => 'required|max:255'
            ])
            ->add('logo_url', 'text', [
                'label' => 'Logo Url',
                'rules' => 'required|url|max:255'
            ]);
    }
}
