<?php

namespace CodeFlix\Forms;

use Kris\LaravelFormBuilder\Form;

class CategoryForm extends Form
{
    public function buildForm()
    {
        $id = $this->getData('id');

        $this
            ->add('name', 'text', [
                'label' => 'Nome da Categoria',
                'rules' => "required|max:25|unique:categories,name,$id"
            ]);
    }
}